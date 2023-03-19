<?php

/*
 * Template Name: Обращения физ./юр. лиц
*/


?>

<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>
<?php $page_id = $post->ID; ?>
<?php $managers = carbon_get_post_meta(get_queried_object_id(), 'crb_manager_description'); ?>

<div class="adfox-banner-background">
	<?php render_adv('page', get_the_ID(), 'background'); ?>
</div>
<main class="appeal">
	<div class="container container_adv"><?php render_adv('page', $page_id, 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar(get_the_title(), false); ?>
				<div class="appeal__content">
					<?php echo the_content(); ?>
				</div>
				<div class="appeal__form">
					<?php echo do_shortcode(carbon_get_the_post_meta('crb_apeal_form')); ?>
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