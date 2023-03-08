<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'post-topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/video-news-tempalte.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>

<?php get_header(); ?>

<?php
$realated_videos = new WP_Query(
	array(
		'posts_per_page' => 3,
		'post_type' => 'video',
		'post__not_in' => array($post->ID),
		'post_status' => 'publish',
	)
);
?>

<div class="adfox-banner-background">
	<?php render_adv('post', $post->ID, 'background'); ?>
</div>
<main id="single-video" class="single-video">
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<div class="container container_adv"><?php render_adv('post', $post->ID, 'before_main'); ?></div>
				<?php plus_and_zen_post($post->ID); ?>
				<div class="mob-container">
					<?php render_post_topic_bar($post->ID); ?>
					<div class="content">
						<?php echo apply_filters('the_content', get_the_content(), $post->ID); ?>
					</div>

					<?php $video_list = carbon_get_post_meta($post->ID, 'video_post_list'); ?>

					<div class="videos-gallery">
						<?php if (count($video_list) > 1) : ?>
							<?php for ($i = 0; $i < 1; $i++) : ?>
								<div class="video-preview">
									<?php $eternal_video = $video_list[$i]['video_post_type_eternal_video_item'][0]; ?>
									<?php $youtube_video = $video_list[$i]['video_post_type_youtube-link_item']; ?>
									<?php if (!empty($eternal_video) && empty($youtube_video)) : ?>
										<?php do_shortcode('[eternal_video_scn attachment_id=' . $eternal_video . ']'); ?>
									<?php elseif (empty($eternal_video) && !empty($youtube_video)) : ?>
										<?php echo $youtube_video; ?>
									<?php elseif (!empty($eternal_video) && !empty($youtube_video)) : ?>
										<?php echo $youtube_video; ?>
									<?php endif; ?>
								</div>
							<?php endfor; ?>
							<div class="videos-list">
								<?php for ($j = 1; $j < count($video_list); $j++) : ?>
									<div class="video-preview">
										<?php $eternal_video = $video_list[$j]['video_post_type_eternal_video_item'][0]; ?>
										<?php $youtube_video = $video_list[$j]['video_post_type_youtube-link_item']; ?>
										<?php if (!empty($eternal_video) && empty($youtube_video)) : ?>
											<?php do_shortcode('[eternal_video_scn attachment_id=' . $eternal_video . ']'); ?>
										<?php elseif (empty($eternal_video) && !empty($youtube_video)) : ?>
											<?php echo $youtube_video; ?>
										<?php elseif (!empty($eternal_video) && !empty($youtube_video)) : ?>
											<?php echo $youtube_video; ?>
										<?php endif; ?>
									</div>
								<?php endfor; ?>
							</div>
						<?php else : ?>
							<?php foreach ($video_list as $video) : ?>
								<div class="video-preview">
									<?php $eternal_video = $video_list[0]['video_post_type_eternal_video_item'][0]; ?>
									<?php $youtube_video = $video_list[0]['video_post_type_youtube-link_item']; ?>
									<?php if (!empty($eternal_video) && empty($youtube_video)) : ?>
										<?php do_shortcode('[eternal_video_scn attachment_id=' . $eternal_video . ']'); ?>
									<?php elseif (empty($eternal_video) && !empty($youtube_video)) : ?>
										<?php echo $youtube_video; ?>
									<?php elseif (!empty($eternal_video) && !empty($youtube_video)) : ?>
										<?php echo $youtube_video; ?>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

			</div>
			<div class="second-content">
				<?php render_video_news_template("Смотрите", array(
					array(
						'taxonomy' => 'videos',
						'terms' => 'minsk-courier',
						'field' => 'slug',
						'operator' => 'IN'
					)
				)); ?>
				<?php render_newspapers_template('post', $post->ID); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>