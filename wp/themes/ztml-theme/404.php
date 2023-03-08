<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>

<?php get_header(); ?>

<main class="appeal">
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<div>
					<div class="td-404-title">Упс... Ошибка 404 </div>
					<div class="td-404-sub-title">Извините, но страница, которую Вы ищете, не существует.</div>
					<div class="td-404-sub-sub-title">
						Вы можете перейти на
						<a href="https://minsknews.by/">ГЛАВНАЯ СТРАНИЦА</a>
					</div>
				</div>
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
			</div>
			<div class="second-content">
				<?php render_top_three_news_template(); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>



