<?php

function newspaper_taxonomy()
{
	register_post_type(
		'newspaper',
		array(
			'label'               => __('newspaper'),
			'labels'              => array(
				'name'                => _x('Издательства', 'Post Type General Name'),
				'singular_name'       => _x('Газета', 'Post Type Singular Name'),
				'menu_name'           => __('Издательства'),
			),
			'supports'            => array('title', 'author', 'editor', 'thumbnail'),
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
			'show_in_rest' => true,
			'rewrite' => true
		)
	);


	register_taxonomy(
		'newspapers',
		array('newspaper'),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x('newspapers', 'taxonomy general name'),
				'singular_name' => _x('Категория', 'taxonomy singular name'),
				'menu_name' => __('Категории'),
			),
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => true
		)
	);
}

add_action('init', 'newspaper_taxonomy', 0);
