<?php

/*
 * Template Name: Все видео
*/

?>

<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'calendar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/video-news-tempalte.php'); ?>

<?php get_header(); ?>

<?php
$show_count = 27;
$load_count = 27;

$meri_args = array(
	'post_status' => 'publish',
	'posts_per_page' => $show_count,
	'post_type' => 'video',
);

$meri_posts = get_posts($meri_args);
$count_posts = wp_count_posts('video')->publish;
?>

<?php
$first_post_id = get_posts(array(
	'numberposts' => 1,
	'post_type' => 'video',
	'post_status' => 'publish',
	'order' => 'DESC',
))[0]->ID;

$last_post_id = get_posts(array(
	'numberposts' => 1,
	'post_type' => 'video',
	'post_status' => 'publish',
	'order' => 'ASC',
))[0]->ID;
?>

<main id="videos-list" class="videos-satm">
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar(get_the_title(), true, array(
					'render' => 'render_calendar',
					'args' => array(
						'id' => 'datepicker-all-videos-template',
						'min_date' => get_the_time('Y-m-d', $last_post_id),
						'max_date' => get_the_time('Y-m-d', $first_post_id),
					)
				));
				?>

				<div class="videos-list-content">
					<?php foreach ($meri_posts as $pst) : ?>
							<?php render_new_template_video($pst->ID, true, true, true); ?>
					<?php endforeach; ?>
				</div>

				<?php if (intval($show_count) < $count_posts) : ?>
					<div class="load-moree-btn">
						<button data-all-posts="<?php echo $count_posts; ?>">Показать еще</button>
					</div>
				<?php endif ?>
			</div>

			<div class="second-content">
				<?php render_video_news_template("Минский курьер", array(
					array(
						'taxonomy' => 'videos',
						'terms' => 'minskij-kurer',
						'field' => 'slug',
						'operator' => 'IN'
					)
				)); ?>
				<?php render_newspapers_template(); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>