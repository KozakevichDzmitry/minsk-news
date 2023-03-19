<?php
/*
 * Template Name: Радио-минск
*/
?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'topic-minibar.php'); ?>

<?php require_once(COMPONENTS_PATH . 'management-item.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>

<?php require_once(COMPONENTS_PATH . '/icons/marker-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . '/icons/instagram-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . '/icons/telegram-colored-icon.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>
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

<?php get_header(); ?>

<div class="adfox-banner-background">
	<?php render_adv('page', $page_id, 'background'); ?>
</div>
<main id="radio-minsk" class="radio-minsk">
	<div class="container container_adv"><?php render_adv('page', $page_id, 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<div style="display: flex; align-items: center; justify-content: space-between; padding: 0;">
					<?php render_topic_bar(get_the_title(), false); ?>
					<div class="radio-player" id="radio-min-player">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/radio-minsk/radio.png" alt="radio" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/radio-minsk/radio-p.jpg'; ?>">
						<audio id="radio_minsk" preload="metadata">
							<source src="https://radio.mk.by:8443/mk128" type="audio/mpeg">
						</audio>
					</div>
				</div>
				<div class="mob-container">
					<div class="radio-minsk-info">
						<div class="image">
							<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?>">
						</div>
						<div class="mobile-radio-player" id="mobile-radio-min-player">
							<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/radio-minsk/radio.png" alt="radio" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/radio-minsk/radio-p.jpg'; ?>">
							<audio id="mobile_radio_minsk" preload="metadata">
								<source src="https://radio.mk.by:8443/mk128" type="audio/mpeg">
							</audio>
						</div>
						<div class="content">
							<?php echo get_the_content(); ?>
						</div>
					</div>
					<div class="mobile-content">
						<?php echo get_the_content(); ?>
					</div>
					<div>
						<ul class="radio-freq-list">
							<?php foreach ($vfat as $district) : ?>
								<li class="radio-freq-list__item">
									<?php render_marker_icon(); ?>
									<span class="radio-freq-item__city">
										<?php echo $district['city']; ?>
									</span>
									<span class="radio-freq-item__freq">
										<?php echo $district['freq']; ?>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div id="programs">
						<div class="block-title">
							<?php echo carbon_get_the_post_meta('program_title') ?>
						</div>
						<div class="programs-list">
							<div class="programs-wrapper card-list swiper-wrapper">
								<?php foreach (get_posts(array(
									'post_type' => 'programs',
									'posts_per_page' => 30,
									'order' => 'ASC'
								)) as $pst) : ?>
                                <div class="program-card swiper-slide">
                                    <div class="card-item">
                                        <div class="card-item__image">
                                            <img src="<?php echo get_the_post_thumbnail_url($pst->ID) ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id($pst->ID), '_wp_attachment_image_alt', TRUE); ?>" />
                                        </div>
                                        <div class="card-item__title">
                                            <?php echo get_the_title($pst->ID) ?>
                                        </div>
                                        <div class="card-item__subtitle">
                                            <?php echo carbon_get_post_meta($pst->ID, 'subtitle') ?>
                                        </div>
                                    </div>
                                </div>
								<?php endforeach ?>
							</div>
                            <div class="programs-list__pagination swiper-pagination"></div>
						</div>
                        <div class="programs-arrow-prev swiper-arrow swiper-arrow-prev"></div>
                        <div class="programs-arrow-next swiper-arrow swiper-arrow-next"></div>
					</div>
					<div id="contacts" class="contacts">
						<div class="contacts-list">
							<?php foreach (carbon_get_the_post_meta('contacts') as $item) : ?>
								<div class="contacts-item">
									<div class="contacts-item__title">
										<?php echo $item['title'] ?>
									</div>
									<div class="contacts-item__content">
										<?php echo apply_filters('the_content', $item['content']) ?>
									</div>
								</div>
							<?php endforeach ?>

							<div class="contacts-item">
								<div class="contacts-item__title">
									<?php echo carbon_get_the_post_meta('search_sound_title') ?>
								</div>
								<div class="contacts-item__content">
									<?php echo apply_filters('the_content', carbon_get_the_post_meta('search_sound_content')) ?>
									<a class="radio-minsk__btn" href="https://radiominsk.by/PlayList/Index">Поиск звучавших песен</a>
								</div>
							</div>

						</div>
					</div>
					<div id="team">
						<div class="block-title">
							<span>Команда</span>
						</div>
						<?php $team = carbon_get_the_post_meta('crb_radio_minsk_team'); ?>
						<div class="team-list">
							<div class="team-wrapper card-list swiper-wrapper">
								<?php foreach ($team as $member) : ?>
                                <div class="team-card swiper-slide">
                                    <div class="card-item">
                                        <div class="card-item__image">
                                            <img src="<?php echo $member['crb_radio_minsk_member_photo']; ?>" />
                                        </div>
                                        <div class="card-item__content">
                                            <div class="card-item__title">
												<span>
													<?php echo $member['crb_radio_minsk_member_fio']; ?>
												</span>
                                            </div>
                                            <div class="card-item__subtitle">
												<span>
													<?php echo $member['crb_radio_minsk_member_short']; ?>
												</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<?php endforeach; ?>
							</div>
                            <div class="team-list__pagination swiper-pagination"></div>
						</div>
                        <div class="team-arrow-prev swiper-arrow swiper-arrow-prev"></div>
                        <div class="team-arrow-next swiper-arrow swiper-arrow-next"></div>
					</div>
                    <div id="advertising">
                        <a class="radio-minsk__btn" href="<?php echo get_home_url(). '/reklama/#price-list-5'; ?>">Разместить рекламу</a>
                    </div>
				</div>
			</div>
			<div class="second-content">
				<?php render_newspapers_template('page', $page_id); ?>
			</div>
		</div>
		<?php render_sidebar(function () {
		?>
			<div>
				<?php render_topic_minibar("Программы", get_page_link() . '#programs'); ?>
				<?php render_topic_minibar("Команда", get_page_link() . '#team'); ?>
				<?php render_topic_minibar("Контакты", get_page_link() . '#contacts'); ?>
				<?php render_topic_minibar("Реклама", get_page_link() . '#advertising'); ?>
			</div>
		<?php
		}); ?>
	</div>
</main>

<?php get_footer(); ?>