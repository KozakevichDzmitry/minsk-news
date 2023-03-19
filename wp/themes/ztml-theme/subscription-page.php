<?php

/*
 * Template Name: Подписка
*/

?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'adv.php'); ?>
<?php $page_id = $post->ID; ?>
<?php get_header(); ?>

<div class="adfox-banner-background">
	<?php render_adv('page', $page_id, 'background'); ?>
</div>
<main class="subscribe">
	<div class="container container_adv"><?php render_adv('page', $page_id, 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar(get_the_title(), false); ?>

				<div class="subscribe-block">
					<?php echo apply_filters('the_content', get_the_content()); ?>
				</div>

				<?php render_topic_bar("Пробный вариант"); ?>
				<div class="test_option_news">
					<iframe class="news_option" src="//e.issuu.com/embed.html#3941402/40249335" width="640" height="480" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
					<iframe class="news_option" src="//e.issuu.com/embed.html#3941402/40252332" width="640" height="480" frameborder="0"></iframe>
				</div>
			</div>
			<div class="second-content">
				<?php render_most_read_news_template(true, 'page', $page_id); ?>
				<?php render_top_three_news_template('page', $page_id); ?>
				<?php render_newspapers_template('page', $page_id); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>