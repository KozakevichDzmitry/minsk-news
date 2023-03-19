<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'half-post.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>

<?php require_once(COMPONENTS_PATH . 'line-news-list-item.php'); ?>
<?php $post_id = get_the_ID(); ?>
<div class="adfox-banner-background">
	<?php render_adv('post', $post_id, 'background'); ?>
</div>
<main class="ta single-take-actions">
    <div class="container container_adv"><?php render_adv('post', $post_id, 'before_main'); ?></div>
	<?php plus_and_zen_post($post_id); ?>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<div class="mob-container">
					<?php render_half_post($post->ID); ?>
				</div>

				<?php render_topic_bar('Читайте и подписывайтесь', false); ?>

				<div class="sub-block">
                    <div>
                        <a target="_blank" href="https://t.me/minsknews_by"><img src="<?php echo get_template_directory_uri() . '/assets/images/t-me.png'; ?>" alt="telegram" /></a>
                    </div>
					<div>
						<a target="_blank" href="https://zen.yandex.ru/minsknews"><img alt="Yandex Zen logo" src="<?php echo get_template_directory_uri() . '/assets/images/yandex-logo-dzen.png'; ?>" /></a>
					</div>
					<div>
						<a target="_blank" href="https://news.google.com/publications/CAAiEJC-mX-9vJkoL28IxRv_JPsqFAgKIhCQvpl_vbyZKC9vCMUb_yT7?hl=ru&gl=RU&ceid=RU%3Aru"><img alt="Goolge logo" src="<?php echo get_template_directory_uri() . '/assets/images/google-logo.png'; ?>" /></a>
					</div>
				</div>
			</div>
			<div class="second-content">
                <?php render_newspapers_template('post', $post_id); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>