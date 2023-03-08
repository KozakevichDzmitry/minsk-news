<?php

/*
 * Template Name: Об Агентстве
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

<?php require_once(COMPONENTS_PATH . 'icons/person-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/eye-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/artical-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'icons/persons-icon.php'); ?>

<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'adv.php'); ?>

<?php $managers = carbon_get_post_meta(get_queried_object_id(), 'crb_manager_description'); ?>
<?php $page_id = $post->ID; ?>
<?php

$vfat = array(
	array(
		'city' => 'Минск',
		'freq' => '92.4'
	),
	array(
		'city' => 'Витебск',
		'freq' => '106.4'
	),
	array(
		'city' => 'Могилев',
		'freq' => '98.1'
	),
	array(
		'city' => 'Гомель',
		'freq' => '105.6'
	),
	array(
		'city' => 'Брест',
		'freq' => '100.4'
	),
);
?>

<div class="adfox-banner-background">
	<?php render_adv('page', get_the_ID(), 'background'); ?>
</div>
<main class="about">
	<div class="container container_adv"><?php render_adv('page', get_the_ID(), 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content page-content">
				<?php render_topic_bar(get_the_title(), false); ?>
				<div class="appeal__content">
					<?php echo the_content(); ?>
				</div>
				<div class="about-content">
					<div class="metrics">
						<?php foreach (carbon_get_the_post_meta('numbers') as $item) : ?>
							<div class="card">
								<div class="card__icon">
									<img src="<?php echo wp_get_attachment_image_url($item['image']) ?>" alt="<?php echo get_post_meta($item['image'], '_wp_attachment_image_alt', TRUE); ?>">
								</div>
								<div class="card__content">
									<span class="card__title">&#62; <b><?php echo $item['title'] ?></b></span>
									<span class="card__text">
										<?php echo $item['text'] ?>
									</span>
								</div>
							</div>
						<?php endforeach ?>
					</div>

					<div class="about-content__text">
						<?php echo apply_filters('the_content', carbon_get_the_post_meta('content2')) ?>
					</div>

					<div class="socials-links">
						<?php foreach (carbon_get_the_post_meta('about_socials') as $item) : ?>
							<a href="<?php echo $item['link'] ?>"><img src="<?php echo wp_get_attachment_image_url($item['icon']) ?>" alt="<?php echo get_post_meta($item['link'], '_wp_attachment_image_alt', TRUE); ?>"></a>
						<?php endforeach ?>
					</div>

					<div class="about-content__text">
						<?php echo apply_filters('the_content', carbon_get_the_post_meta('content3')) ?>
					</div>

					<div>
						<ul class="radio-freq-list">
							<?php foreach (carbon_get_the_post_meta('cities') as $district) : ?>
								<li class="radio-freq-list__item">
									<?php render_marker_icon(); ?>
									<span class="radio-freq-item__city">
										<?php echo $district['title']; ?>
									</span>
									<span class="radio-freq-item__freq">
										<?php echo $district['text']; ?>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>

					<div class="info">
						<?php foreach (carbon_get_the_post_meta('numbers2') as $item) : ?>
							<div class="card">
								<div class="card__icon">
									<img src="<?php echo wp_get_attachment_url($item['image']) ?>" alt="<?php echo get_post_meta($item['image'], '_wp_attachment_image_alt', TRUE); ?>">
								</div>
								<div class="card__content">
									<span class="card__title"><?php echo $item['title'] ?></span>
									<div>
										<?php echo $item['text'] ?>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>

					<div class="about-content__text">
						<?php echo apply_filters('the_content', carbon_get_the_post_meta('content4')) ?>
					</div>

					<div>
						<a href="#" class="outline-btn">Противодействие коррупции</a>
						<a href="<?php echo get_site_url() . '/wp-content/uploads/Politika-konvertirovan.pdf'; ?>" class="policy-link">Политика УП «Агентство «Минск-новости» в отношении обработки персональных данных</a>
					</div>
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