<?php

/*
 * Template Name: Услуги печати
*/

?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>
<?php $page_id = $post->ID; ?>
<?php $object_id = get_queried_object_id(); ?>

<?php get_header(); ?>
    object_id
<?php

$title = carbon_get_post_meta($object_id, 'crb_title');

$services_caption = carbon_get_post_meta($object_id, 'crb_services_caption');
$services_list = carbon_get_post_meta($object_id, 'crb_printing_services');


$contacts_caption = carbon_get_post_meta($object_id, 'crb_contacts_caption');
$contacts_list = carbon_get_post_meta($object_id, 'crb_contacts');
?>

<div class="adfox-banner-background">
	<?php render_adv('page', $page_id, 'background'); ?>
</div>
<main class="printing">
	<div class="container container_adv"><?php render_adv('page', $page_id, 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar(get_the_title(), false); ?>
				<div class="mob-container">
					<p class="printing-text"><?php echo $title; ?></p>
					<div class="list-container">
						<p class="list__caption">
							<?php echo $services_caption; ?>
						</p>
						<ul class="list">
							<?php foreach ($services_list as $item) : ?>
								<li class="list__item">
									<?php echo $item['crb_service']; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="list-container">
						<p class="list__caption">
							<?php echo $contacts_caption; ?>
						</p>
						<ul class="list">
							<?php foreach ($contacts_list as $item) : ?>
								<li class="list__item">
									<a class="list__item-link" href="<?php echo $item['crb_link'] ?>">
										<?php echo $item['crb_contact']; ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div style="position:relative;overflow:hidden;">
						<iframe class="printing__map" src="https://yandex.by/map-widget/v1/-/CCUBZMXz9A" width="560" height="400" frameborder allowfullscreen style="position:relative;"></iframe>
					</div>
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