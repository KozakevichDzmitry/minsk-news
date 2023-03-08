<?php
require_once('./../../../wp-load.php');
require_once(__DIR__ . '/vendor/autoload.php');

define('COMPONENTS_PATH', dirname(__FILE__) . '/components/');

require_once(COMPONENTS_PATH . "topic-bar.php");
require_once(COMPONENTS_PATH . "news-templates/culture-news-template.php");
require_once(COMPONENTS_PATH . "news-templates/district-news-template.php");
require_once(COMPONENTS_PATH . "news-templates/economy-tempalte.php");
require_once(COMPONENTS_PATH . 'news-templates/incidents-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/main-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php');
require_once(COMPONENTS_PATH . 'news-templates/pallete-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/society-news-tempalte.php');
require_once(COMPONENTS_PATH . 'news-templates/sport-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/urban-economy-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/world-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/author-columns-template.php');
require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/timeline-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/video-news-tempalte.php');
require_once(COMPONENTS_PATH . 'news-templates/main-template.php');
require_once(COMPONENTS_PATH . 'event-gallery-slider.php');
require_once(COMPONENTS_PATH . 'event-loop-messages.php');
require_once(COMPONENTS_PATH . 'author-column-post-slide.php');
require_once(COMPONENTS_PATH . 'news-templates.php');

require_once(__DIR__ . '/functions.php');

use Thruway\Peer\Client;
use Thruway\Peer\Router;
use Thruway\Transport\RatchetTransportProvider;

$loop = React\EventLoop\Factory::create();

$pusher = new Client("realm1", $loop);

$pusher->on('open', function ($session) use ($loop) {
    $context = new React\ZMQ\Context($loop);

    $pull = $context->getSocket(ZMQ::SOCKET_PULL);
    $pull->bind('tcp://0.0.0.0:5555');

    $pull->on('message', function ($entry) use ($session) {
        $entryData = json_decode($entry, true);

        $category_render_templates = [
            'most-read' => 'render_most_read_news_template',
            'society' => 'render_society_news_template',
            'cityhold' => 'render_urban_economy_news_template',
            'economics' => 'render_economy_news_template',
            'culture' => 'render_culture_news_template',
            'sport' => 'render_sport_news_template',
            'palitra' => 'render_pallete_news_template',
            'insidents' => 'render_incidents_news_tempalte',
            'novosti-mira' => 'render_world_news_template',
            'glavnoe' => 'render_news_template_line',
            'primary' => 'render_new_template_image',
            'main' => 'render_news_template_line',
            'feed' => 'render_timeline_line_news'
        ];

        $new_categories_post = array();

        $cats = array_keys($category_render_templates);

        $entryData = json_decode($entry, true);
        $post_type = $entryData['event_type'];
        $post_id = $entryData['post_id'];
        $post = get_post($post_id);

        if ($entryData['event'] === 'newspaper') {

            $tax = wp_get_post_terms($post->ID, 'newspapers', ['fields' => 'slugs']);
            $template_posts_html = ob_start();
            render_pdf_attachments_item($post->ID);
            $template_posts_html = ob_get_clean();
            ob_end_flush();

            $session->publish($post_type, [json_encode([
                'data' => $template_posts_html,
                'tax' => $tax,
                'postID' => $entryData['post_id'],
            ])]);

        }
        else if ($entryData['event'] === 'news_block_update') {
            foreach ($entryData['update_blocks'] as $cat) {
                if (!in_array($cat, $cats)) continue;
                ob_start();

                if ($cat == 'main' or $cat == 'feed') $category_render_templates[$cat]($entryData['post_id']);
                else if ($cat == 'glavnoe')  $category_render_templates[$cat]($entryData['post_id'], true, false, true);
                else if ($cat == 'primary')  $category_render_templates[$cat]($entryData['post_id']);
                else $category_render_templates[$cat]();

                $block_html = ob_get_clean();

                $new_categories_post[] = [
                    'data' => $block_html,
                    'cat' => $cat,
                    'postID' => $entryData['post_id'],
                ];
                if ($cat == 'glavnoe') {
                    ob_start();
                    render_timline_news_template($entryData['post_id']);
                    $block_html = ob_get_clean();
                    $timeline_posts[] = [
                        'data' => $block_html,
                        'cat' => 'glavnoe-feed',
                        'postID' => $entryData['post_id'],
                    ];
                    if (count($timeline_posts) > 0) {
                        $session->publish('news', [json_encode($timeline_posts)]);
                    }
                }
            }
            if (count($new_categories_post) > 0) {
                $session->publish('news', [json_encode($new_categories_post)]);
            }


            if (!empty($entryData['author_id'])) {
                $posts = get_posts(array(
                    'author' => $entryData['author_id'],
                    'posts_per_page' => -1,
                    'post_type' => 'any',
                    'post_status' => 'publish',
                    'post__in' => array($entryData['post_id']),
                    'order' => 'DESC'
                ));

                if (count($posts) >= 1) {
                    $author_post_block_html = ob_start();
                    render_author_column_post_slide($posts[0]);
                    $author_post_block_html = ob_get_clean();
                    ob_end_flush();

                    $session->publish('authors_column', [json_encode([
                        'data' => $author_post_block_html,
                        'author_id' => $entryData['author_id'],
                        'postID' => $entryData['post_id'],
                    ])]);
                }
            }
            if (!empty($entryData['district_update_blocks'])) {
                $district_news_quary = new WP_Query([
                    'post_type' => array('news', 'meri'),
                    'posts_per_page' => '2',
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'news-district',
                            'field' => 'slug',
                            'terms' => $entryData['district_update_blocks']
                        )
                    )
                ]);

                $district_news_posts = $district_news_quary->posts;

                $block_html = ob_start();
                echo '<div class="district-news">';
                render_news_template_line($district_news_posts[0]->ID);
                render_news_template_line($district_news_posts[1]->ID,false, false, false, false);
                echo '</div>';
                $block_html = ob_get_clean();
                ob_end_flush();

                $session->publish('district', [json_encode([
                    'data' => $block_html,
                    'slug' => $entryData['district_update_blocks'],
                    'postID' => $entryData['post_id'],
                ])]);
            }

        }
        else if ($entryData['event'] === 'video_block_update') {
                $tax = wp_get_post_terms($post->ID, 'videos', ['fields' => 'slugs']);

                $template_posts_html = ob_start();
                render_new_template_video($post->ID);
                $template_posts_html = ob_get_clean();
                ob_end_flush();

                $session->publish($post_type, [json_encode([
                    'data' => $template_posts_html,
                    'tax' => $tax,
                    'postID' => $post->ID,
                ])]);
        }
        else if ($entryData['event'] === 'update_page_event') {
            $slider_block_html = ob_start();
            render_event_gallery_slider($entryData['post_id']);
            $slider_block_html = ob_get_clean();
            ob_end_flush();

            $messages_block_html = ob_start();
            render_event_loop_messages($entryData['post_id']);
            $messages_block_html = ob_get_clean();
            ob_end_flush();

            $session->publish('event', [
                json_encode(
                    [
                        'data' => [
                            'slider' => $slider_block_html,
                            'messages' => $messages_block_html
                        ],
                        'post_id' => $entryData['post_id']
                    ]
                )
            ]);
        }
        else if ($entryData['event'] === 'authors_column_update') {
            $posts = get_posts(array(
                'author' => $entryData['author_id'],
                'posts_per_page' => -1,
                'post_type' => 'authors-column',
                'post_status' => 'publish',
                'post__in' => array($entryData['post_id']),
                'order' => 'DESC'
            ));

            if (count($posts) >= 1) {
                $author_post_block_html = ob_start();
                render_author_column_post_slide($posts[0]);
                $author_post_block_html = ob_get_clean();
                ob_end_flush();

                $session->publish('authors_column', [json_encode([
                    'data' => $author_post_block_html,
                    'author_id' => $entryData['author_id'],
                    'postID' => $entryData['post_id'],
                ])]);
            }
        }
    });
});

$router = new Router($loop);
$router->addInternalClient($pusher);
$router->addTransportProvider(new RatchetTransportProvider("0.0.0.0", 8888));
$router->start();
