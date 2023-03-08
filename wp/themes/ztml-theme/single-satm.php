<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . "topic-minibar.php"); ?>

<?php require_once(COMPONENTS_PATH . "icons/video-content-icon.php"); ?>
<?php require_once(COMPONENTS_PATH . "icons/share-icon.php"); ?>

<?php require_once(COMPONENTS_PATH . 'satms-list-tem.php'); ?>

<?php require_once(COMPONENTS_PATH . 'single-satm-slide.php'); ?>

<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>

<?php
$satms = new WP_Query(
	array(
		'post_count' => 3,
		'post_type' => 'satm',
		'post_status' => 'publish',
	)
);
?>

<div class="adfox-banner-background">
	<?php render_adv('post', $post->ID, 'background'); ?>
</div>
<main id="single-satm" class="single-satm">
	<div class="container container_adv"><?php render_adv('post', $post->ID, 'before_main'); ?></div>
	<?php plus_and_zen_post($post->ID); ?>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<div class="main-single-satm">
					<?php single_satm_slide($post); ?>
				</div>

				<div class="single-satm-slider" style="display: none;">
					<?php single_satm_slide($post); ?>
					<?php single_satm_slide($post); ?>
					<?php single_satm_slide($post); ?>
					<?php single_satm_slide($post); ?>
				</div>

				<div class="satm-related">
					<div class="cards-list">
						<?php foreach ($satms->posts as $post) : ?>
							<?php render_satms_list_items($post); ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="second-content">
				<?php render_newspapers_template('post', $post->ID); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>