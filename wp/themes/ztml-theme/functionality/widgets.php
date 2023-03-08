<?php

function dynamic_widgets_init()
{
	register_sidebar(array(
		'name' => __('Main Sidebar', 'wpb'),
		'id' => 'main-sidebar',
		'description' => __('The main sidebar appears on the right on each page except the front page template', 'wpb'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}

add_action('widgets_init', 'dynamic_widgets_init');
