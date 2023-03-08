<?php

add_action('init', function () {
	register_nav_menus(
		array(
			'main-header-nav'   => __('Шапка'),
			'burger-header-nav' => __('Бургер'),
			'sub-header-nav'    => __('Под шапкой'),
			'footer-nav'        => __('Подвал')
		)
	);
});
