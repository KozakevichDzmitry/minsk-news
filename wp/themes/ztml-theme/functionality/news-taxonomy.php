<?php

function news_taxonomy()
{
	register_post_type(
		'news',
		array(
			'label'               => __('news'),
			'labels'              => array(
				'name'                => _x('Новости', 'Post Type General Name'),
				'singular_name'       => _x('Новость', 'Post Type Singular Name'),
				'menu_name'           => __('Новости'),
			),
			'supports'            => array('title', 'author', 'thumbnail', 'editor'),
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
		)
	);

	register_taxonomy('news-district', 'news', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x('Районы', 'taxonomy general name'),
			'singular_name' => _x('Районы', 'taxonomy singular name'),
			'menu_name' => __('Районы'),
		),
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => true,
		'show_in_rest' => true,
	));

	register_taxonomy(
		'news-list',
		array('news'),
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

add_action('init', 'news_taxonomy', 0);
