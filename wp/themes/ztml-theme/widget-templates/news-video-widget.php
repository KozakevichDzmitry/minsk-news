<?php

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

require_once(COMPONENTS_PATH . 'news-templates.php');

class NewsVideoWidget extends Widget
{
    function __construct()
    {
        $this->setup('wp_news_video_widget', 'News Video Widget', 'Displays a block with video news', array(
            Field::make('text', 'wp_news_video_widget_title', 'Заголовок'),
            Field::make('text', 'wp_news_video_widget_link', 'Ссылка'),
            Field::make('text', 'wp_news_video_widget_post_count', 'Количество постов')
                ->set_attribute('min', '1')
                ->set_attribute('type', 'number'),
            Field::make('association', 'wp_news_video_widget_cats', 'Категории')
                ->set_types(array(
                    array(
                        'type' => 'term',
                        'taxonomy' => 'videos',
                    )
                ))
        ));
    }

    function front_end($args, $instance)
    {
        $title= '';

        if($instance['wp_news_video_widget_link']){
            $title .= '<a href="' . $instance['wp_news_video_widget_link'] . '">';
            $title .= $instance['wp_news_video_widget_title'] . '</a>';
        }else{
            $title = $instance['wp_news_video_widget_link'];
        }

        echo $args['before_title'] . $title . $args['after_title'];

        echo '<div class="box box-list no-lines">';

        foreach ($instance['wp_news_video_widget_cats'] as $cat) {
            $quary_args = [
                'post_type' => 'video',
                'post_status' => 'publish',
                'posts_per_page' => $instance['wp_news_video_widget_post_count'],
                'tax_query' => [
                    [
                        'taxonomy' => $cat['subtype'],
                        'terms' => $cat['id'],
                        'field' => 'term_id',
                        'operator' => 'IN'
                    ]
                ],
            ];

            $news_posts_quary = new WP_Query($quary_args);

            $news_posts = $news_posts_quary->posts;

            foreach ($news_posts as $pst) {
                render_new_template_video($pst->ID,false, false);
            }
        }

        echo '</div>';
    }
}

add_action('widgets_init', function () {
    register_widget('NewsVideoWidget');
});

