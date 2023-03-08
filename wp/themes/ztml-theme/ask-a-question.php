<?php

/*
 * Template Name: Задайте вопрос столичным властям
*/

?>

<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'ether-item.php'); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>
<?php $page_id = $post->ID; ?>
<?php
$show_count = 10;
$load_count = 5;

$efiri_args = array(
	'post_type' => 'post',
	'post_type' => 'aaq',
	'post_status' => 'publish',
	'posts_per_page' => $show_count
);

$efiri_posts = get_posts($efiri_args);
$count_posts = wp_count_posts('aaq')->publish;

?>

<?php
$show_descriptions_status = carbon_get_post_meta(get_queried_object_id(), 'crb_aaq_show_description');
$show_appeals_status = carbon_get_post_meta(get_queried_object_id(), 'crb_aaq_show_appeals');
$show_ethers_status = carbon_get_post_meta(get_queried_object_id(), 'crb_aaq_show_ethers');
?>

<div class="adfox-banner-background">
	<?php render_adv('page', get_the_ID(), 'background'); ?>
</div>
<main class="aaq">
	<div class="container container_adv"><?php render_adv('page', get_the_ID(), 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar(get_the_title(), false); ?>
				<div class="aqq-content">
					<p class="title">Уважаемые жители столицы, Мингорисполком совместно с агентством «Минск-Новости» реализует проект «Задайте вопрос столичным властям».</p>

					<?php if (!$show_descriptions_status) : ?>
						<div class="part">
							<div class="part-item">
								<?php echo get_the_post_thumbnail(); ?>
							</div>
							<div class="part-item">
								<?php echo the_content(); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<?php
				$appeals_posts = get_posts(array(
					'post_type' => 'aqq-appeals',
					'post_status' => 'publish',
					'posts_per_page' => -1
				));
				?>

				<?php if (!$show_appeals_status) : ?>
					<?php if (!empty($appeals_posts)) : ?>
						<div class="aaq-question-list">
							<?php foreach ($appeals_posts as $pst) : ?>
								<div class="aaq-question-list-item">
									<div class="aaq-question-list-item__name">
										<p><?php echo $pst->post_title; ?></p>
									</div>
									<div class="aaq-question-list-item__ask">
										<?php echo $pst->post_content; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if (!$show_ethers_status) : ?>
					<?php if ($efiri_posts) : ?>
						<div class="efirs-list">
							<?php foreach ($efiri_posts as $pst) : ?>
								<?php render_ether_item($pst->ID); ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if (intval($show_count) < $count_posts) : ?>
						<div class="load-moree-btn">
							<button data-all-posts="<?php echo $count_posts; ?>">Показать еще</button>
						</div>
					<?php endif ?>
				<?php endif; ?>
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