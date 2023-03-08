<?php

function programs_post_type()
{
	register_post_type(
		'programs',
		array(
			'label'               => __('Программы'),
			'labels'              => array(
				'name'                => _x('Программы', 'Post Type General Name'),
				'singular_name'       => _x('Программа', 'Post Type Singular Name'),
				'menu_name'           => __('Программы'),
			),
			'supports'            => array('title', 'author', 'thumbnail'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite' => true
		)
	);
}

add_action('init', 'programs_post_type', 0);
