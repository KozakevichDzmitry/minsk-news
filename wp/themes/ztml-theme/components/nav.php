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
	$nav['after'] = '<button class="expand-btn"><svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 7L5 1L1 7" stroke="#214972" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button></div>';

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
