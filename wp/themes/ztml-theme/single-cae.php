<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . "topic-minibar.php"); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>

<?php require_once(COMPONENTS_PATH . "adv.php"); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>

<div class="adfox-banner-background">
	<?php render_adv('post', $post->ID, 'background'); ?>
</div>
<main id="single-cae" class="single-cae cae">
	<div class="container container_adv"><?php render_adv('post', $post->ID, 'before_main'); ?></div>
    <div class="container main-container">
        <div class="content-wrapper">
            <div class="main-content">
                <?php render_topic_bar('Причины и следствие', false); ?>
                <div class="mob-container">
                    <div class="cards-list">
                        <?php render_cae_item_list($post->ID); ?>
                    </div>
                </div>
            </div>
            <div class="second-content">
                <?php render_most_read_news_template(true, 'page', $post->ID); ?>
                <?php render_top_three_news_template('page', $post->ID); ?>
                <?php render_newspapers_template('page', $post->ID); ?>
            </div>
        </div>
        <?php render_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>