<?php

function render_main_header_nav()
{
	global $base_nav_settings;
	$location = 'main-header-nav';
	$nav = $base_nav_settings;
	$nav['theme_location'] = $location;

	if (has_nav_menu($location)) {
		wp_nav_menu($nav);
	}
}

function render_burger_nav()
{
	global $base_nav_settings;
	$location = 'burger-header-nav';
	$nav = $base_nav_settings;
	$nav['theme_location'] = $location;
	$nav['before'] = '<div class="menu-link">';
	$nav['after'] = '</div>';

	if (!empty($nav['container_class'])) {
		$nav['container_class'] = $nav['container_class'] . ' burger-nav';
	} else {
		$nav['container_class'] = ' burger-nav';
	}

	if (has_nav_menu($location)) {
		wp_nav_menu($nav);
	}
}

function render_sub_header_nav()
{
	global $base_nav_settings;
	$location = 'sub-header-nav';
	$nav = $base_nav_settings;
	$nav['theme_location'] = $location;

	if (has_nav_menu($location)) {
		wp_nav_menu($nav);
	}
}

function render_footer_nav()
{
	global $base_nav_settings;
	$location = 'footer-nav';
	$nav = $base_nav_settings;
	$nav['theme_location'] = $location;

	if (has_nav_menu($location)) {
		wp_nav_menu($nav);
	}
}
