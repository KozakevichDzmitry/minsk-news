<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . "topic-minibar.php"); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates/culture-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/district-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/economy-tempalte.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/society-news-tempalte.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/urban-economy-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>

<?php

$districts = new WP_Query(array(
	'post_type' => 'district',
	'post_status' => 'publish'
));
$page_id = get_the_ID();
$page_template_slug = $post->post_name;
?>
<div class="adfox-banner-background">
	<?php render_adv('page', $page_id, 'background'); ?>
</div>
<main id="district" class="district">
	<div class="container container_adv"><?php render_adv('page', $page_id, 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar(get_the_title(), true, [], false); ?>
                <div class="swiper-gallery district-slider">
                    <div class="swiper-gallery__wrapper district-slider__wrapper swiper-wrapper">
                        <?php foreach (carbon_get_the_post_meta('crb_district_gallery_iamges') as $id) : ?>
                        <?php $url = wp_get_attachment_url($id); ?>
                            <div class="swiper-gallery__item district-slider__item swiper-slide">
                                <a href="<?php echo $url;?>" data-lightbox="swiper-gallery-district">
                                    <img src="<?php echo $url; ?>" alt="<?php echo get_post_meta($id, '_wp_attachment_image_alt', TRUE); ?>" />
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="district-slider__pagination swiper-gallery__pagination swiper-pagination"></div>
                    <div class="district-slider__arrow-prev swiper-arrow swiper-arrow-prev"></div>
                    <div class="district-slider__arrow-next swiper-arrow swiper-arrow-next"></div>
                </div>
				<div class="district__info">
					<?php the_content(); ?>
				</div>
				<div class="district__link">
					<a href="<?php echo carbon_get_the_post_meta('crb_gov_link_url'); ?>">
						<?php echo carbon_get_the_post_meta('crb_gov_link_text'); ?>
					</a>
				</div>
			</div>
			<div class="second-content">
				<?php render_society_news_template(true, true, $page_template_slug, 'page', $page_id); ?>
				<?php render_urban_economy_news_template(true, true, $page_template_slug, 'page', $page_id); ?>
				<?php render_economy_news_template(true, true, $page_template_slug, 'page', $page_id); ?>
				<?php render_most_read_news_template(true, 'page', $page_id); ?>
				<?php render_top_three_news_template('page', $page_id); ?>
				<?php render_newspapers_template('page', $page_id); ?>
			</div>
		</div>
		<?php render_sidebar(function () {
			$districts = new WP_Query(array(
				'post_type' => 'district',
				'post_status' => 'publish'
			));
		?>
			<div>
				<?php if ($districts->have_posts()) : ?>
					<?php while ($districts->have_posts()) : $districts->the_post(); ?>
						<?php render_topic_minibar(get_the_title(), get_post_permalink()); ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		<?php
		}); ?>
	</div>
</main>

<?php get_footer(); ?>