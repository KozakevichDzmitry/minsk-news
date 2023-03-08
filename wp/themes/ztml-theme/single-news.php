<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'half-post.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-whole-post.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'line-news-list-item.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>

<div class="adfox-banner-background">
	<?php render_adv('post', $post->ID, 'background'); ?>
</div>
<main class="authors-column-page">
	<div class="container container_adv"><?php render_adv('post', $post->ID, 'before_main'); ?></div>
	<?php plus_and_zen_post($post->ID); ?>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content" id="<?php echo $post->ID; ?>">
				<?php gt_set_post_view(); ?>
				<?php render_news_whole_post($post); ?>

				<?php render_topic_bar('Читайте и подписывайтесь', false); ?>

				<div class="sub-block">
					<div>
						<a target="_blank" href="https://t.me/minsknews_by"><img src="<?php echo get_template_directory_uri() . '/assets/images/t-me.png'; ?>" alt="telegram" /></a>
					</div>
					<div>
						<a target="_blank" href="https://zen.yandex.ru/minsknews"><img src="<?php echo get_template_directory_uri() . '/assets/images/yandex-logo-dzen.png'; ?>" alt="Yandex Zen logo" /></a>
					</div>
					<div>
						<a target="_blank" href="https://news.google.com/publications/CAAiEJC-mX-9vJkoL28IxRv_JPsqFAgKIhCQvpl_vbyZKC9vCMUb_yT7?hl=ru&gl=RU&ceid=RU%3Aru"><img alt="Goolge logo" src="<?php echo get_template_directory_uri() . '/assets/images/google-logo.png'; ?>" /></a>
					</div>
				</div>

				<?php
				$meri_args = array(
					'post_status' => 'publish',
					'posts_per_page' => 1,
					'post_type' => 'news',
					'post__not_in' => array($post->ID),
				);

				$meri_posts = get_posts($meri_args);
				?>


				<?php if (!empty($meri_posts)) : ?>
					<?php foreach ($meri_posts as $post) : ?>
						<div class="news-whole-post">
							<div class="whole-post-scroll">
								<?php render_news_whole_post($post->ID); ?>
							</div>
							<div class="news-whole-post-wrapper"></div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<div class="loading-posts">
					<span class="spinner"></span>
				</div>
				<div class="second-content">
					<?php render_top_three_news_template('post', $post->ID); ?>
					<?php render_newspapers_template(); ?>
				</div>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>