<?php

function vide_taxonomy()
{
	register_post_type(
		'video',
		array(
			'label'               => __('video'),
			'labels'              => array(
				'name'                => _x('Видео запись', 'Post Type General Name'),
				'singular_name'       => _x('Видео запись', 'Post Type Singular Name'),
				'menu_name'           => __('Видео'),
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
		'videos',
		array('video'),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x('Категории', 'taxonomy general name'),
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

add_action('init', 'vide_taxonomy', 0);
