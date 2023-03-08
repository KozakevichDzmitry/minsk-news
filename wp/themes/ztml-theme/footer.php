<?php require_once(COMPONENTS_PATH . "icons/logo-large-icon.php"); ?>
<?php require_once(COMPONENTS_PATH . "icons/logo-smi-icon.php"); ?>

<?php require_once(COMPONENTS_PATH . "timeline.php"); ?>

<footer class="footer">
	<div class="container">
		<div class="footer__content">
			<div class="footer__info">
				<aside class="footer__logo">
                    <a href="<?php echo get_home_url(); ?>">
					    <?php render_logo_large_icon(); ?>
                    </a>
					<div class="footer__privacy">
						<a href="/usloviya-ispolzovaniya-materialov-up-agentstvo-minsk-novosti/">
							Условия использования материалов<br>
							УП «Агентство «Минск-Новости»
						</a>
					</div>
				</aside>
			</div>
			<div class="footer__navigation">
				<aside>
					<h4 class="footer__title">
						<span>Навигация</span>
					</h4>
					<?php render_footer_nav(); ?>
				</aside>
			</div>
			<div class="footer__adv-info">
				<aside>
					<h4 class="footer__title">
						<span>Реклама</span>
					</h4>
					<p class="footer__advertising">
						Расскажи о себе и своем бизнесе<br />
						с помощью медиахолдинга<br />
						УП «Агентство «Минск-Новости»!
					</p>
					<a href="<?php echo get_permalink(103); ?>" class="footer__advertising-btn">Разместить рекламу</a>
				</aside>
			</div>
			<div class="footer__media">
				<aside>
					<h4 class="footer__title">
						<span>Наши СМИ</span>
					</h4>
					<?php render_logo_smi_icon(); ?>
				</aside>
			</div>
		</div>
	</div>
	<?php render_timeline(); ?>
</footer>

<?php wp_footer(); ?>

</body>

</html>