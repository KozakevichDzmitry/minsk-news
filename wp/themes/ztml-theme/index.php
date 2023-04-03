<?php get_header(); ?>

<?php require_once(FUNC_PATH . 'get_post_view.php'); ?>

<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'half-post.php'); ?>



<?php require_once(COMPONENTS_PATH . "icons/advertising-icon.php"); ?>
<?php require_once(COMPONENTS_PATH . "icons/marker-icon.php"); ?>
<?php require_once(COMPONENTS_PATH . "icons/location-icon.php"); ?>
<?php require_once(COMPONENTS_PATH . "icons/camera-icon.php"); ?>
<?php require_once(COMPONENTS_PATH . "icons/video-content-icon.php"); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>

<?php require_once(COMPONENTS_PATH . 'icons/collapse-btn-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/expand-btn-icon.php'); ?>

<main class="site-main">
	<div class="container main-container">
		<div class="content-wrapper">
            <div class="main-content">
                <?php gt_set_post_view($post->ID); ?>
                <?php render_news_whole_post($post->ID); ?>
            </div>
			<?php render_newspapers_template(); ?>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>