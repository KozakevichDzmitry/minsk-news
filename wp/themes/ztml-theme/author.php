<?php
require_once(COMPONENTS_PATH . 'topic-bar.php');
require_once(COMPONENTS_PATH . 'sidebar.php');

require_once(COMPONENTS_PATH . 'news-templates.php');
require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php');
require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php');
require_once(COMPONENTS_PATH . 'calendar.php');

$show_count = 27;
$load_count = 27;
$author_ID=get_queried_object()->ID;
$meri_args = array(
    'post_status' => 'publish',
    'posts_per_page' => $show_count,
    'post_type' => 'any',
    'author' => $author_ID
);

$meri_posts = get_posts($meri_args);
$count_posts = count_user_posts( $author_ID , ['news','video','authors-column'], true );

?>

<?php
$first_post_id = get_posts(array(
    'numberposts' => 1,
    'post_type' => 'any',
    'post_status' => 'publish',
    'author' => $author_ID,
    'order' => 'DESC'
))[0]->ID;

$last_post_id = get_posts(array(
    'numberposts' => 1,
    'post_type' => 'any',
    'post_status' => 'publish',
    'author' => $author_ID,
    'order' => 'ASC'
))[0]->ID;

?>

<?php get_header(); ?>

    <main class="printing" data-authorID="<?php echo $author_ID?>">
        <div class="container main-container">
            <div class="content-wrapper">
                <div class="main-content">
                    <?php render_topic_bar(get_the_author_meta('display_name'), true, array(
                        'render' => 'render_calendar',
                        'args' => array(
                            'id' => 'datepicker-all-authors-materials-template',
                            'min_date' => get_the_time('Y-m-d', $last_post_id),
                            'max_date' => get_the_time('Y-m-d', $first_post_id),
                        )
                    ));
                    ?>
                    <div class="ta-list">
                        <?php if (!empty($meri_posts)) : ?>
                            <?php foreach ($meri_posts as $post) : ?>
                                <?php render_line_regular_news($post->ID, true); ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php if (intval($show_count) < $count_posts) : ?>
                        <div class="load-moree-btn">
                            <button data-all-posts="<?php echo $count_posts ?>">Показать еще</button>
                        </div>
                    <?php endif ?>
                </div>
                <div class="second-content">
                    <?php render_most_read_news_template(true); ?>
                    <?php render_top_three_news_template(); ?>
                    <?php render_newspapers_template(); ?>
                </div>
            </div>
            <?php render_sidebar(); ?>
        </div>
    </main>


<?php get_footer(); ?>