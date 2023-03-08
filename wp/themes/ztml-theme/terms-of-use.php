<?php

/*
 * Template Name: Условия использования
*/

?>

<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>


<?php require_once(COMPONENTS_PATH . 'icons/facebook-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/instagram-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/ok-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/telegram-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/twitter-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/vk-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/youtube-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/tiktok-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/marker-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/mice-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/volume-icon.php'); ?>

<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'adv.php'); ?>

<?php $managers = carbon_get_post_meta(get_queried_object_id(), 'crb_manager_description'); ?>
<?php $page_id = $post->ID; ?>
<?php

?>

    <div class="adfox-banner-background">
        <?php render_adv('page', get_the_ID(), 'background'); ?>
    </div>
    <main class="terms-of-use">
        <div class="container container_adv"><?php render_adv('page', get_the_ID(), 'before_main'); ?></div>
        <div class="container main-container">
            <div class="content-wrapper">
                <div class="main-content page-content">
                    <?php render_topic_bar(get_the_title(), false); ?>
                    <div class="appeal__content">
                        <?php echo the_content(); ?>
                    </div>
                </div>
                <div class="second-content">
                    <?php render_most_read_news_template(true, 'page', $page_id); ?>
                    <?php render_newspapers_template('page', $page_id); ?>
                </div>
            </div>
            <?php render_sidebar(); ?>
        </div>
    </main>

<?php get_footer(); ?>