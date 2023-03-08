<?php
/*
 * Template Name: Смотрите
*/

?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/see-video-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/video-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'adv.php'); ?>
<?php $page_id = $post->ID; ?>
<?php
$last_videos_quary = new WP_Query([
    'post_type' => 'video',
    'posts_per_page' => '3',
    'post_status' => 'publish',
    'tax_query' => [
        'taxonomy' => 'videos',
        'slug' => 'novosti-minska'
    ]
]);

$last_videos_posts = $last_videos_quary->posts;
?>

<?php get_header(); ?>
    <div class="adfox-banner-background">
        <?php render_adv('page', get_the_ID(), 'background'); ?>
    </div>
    <main class="all-videos">
        <div class="container container_adv"><?php render_adv('page', $page_id, 'before_main'); ?></div>
        <div class="container main-container">
            <div class="content-wrapper">
                <div class="main-content">
                    <?php render_topic_bar(get_the_title(), false); ?>
                    <div class="mob-container">
                        <div class="content">
                            <?php echo apply_filters('the_content', get_the_content()) ?>
                        </div>
                        <div class="posts-content">
                            <?php render_see_video_template($last_videos_posts[0]->ID); ?>
                            <div>
                                <?php render_see_video_template($last_videos_posts[1]->ID); ?>
                                <?php render_see_video_template($last_videos_posts[2]->ID); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second-content">
                    <?php render_video_news_template(array('novosti-minska', 'minsk-courier', 'govorit-i-pokazyivaet-minsk'),
                        ['orderby' => 'name', 'order' => 'DESC',]); ?>
                    <?php render_newspapers_template('page', $page_id); ?>
                </div>
            </div>
            <?php render_sidebar(); ?>
        </div>
    </main>

<?php get_footer(); ?>