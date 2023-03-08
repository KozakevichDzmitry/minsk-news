<?php

function primite_meri_taxonomy()
{
	register_post_type(
		'meri',
		array(
			'label'               => __('Примите меры'),
			'labels'              => array(
				'name'                => _x('Примите меры', 'Post Type General Name'),
				'singular_name'       => _x('Примите меры', 'Post Type Singular Name'),
				'menu_name'           => __('Примите меры'),
			),
			'supports'            => array('title', 'author', 'editor', 'revisions', 'thumbnail'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
		)
	);

	register_taxonomy(
		'meri-list',
		'meri',
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

add_action('init', 'primite_meri_taxonomy', 0);
