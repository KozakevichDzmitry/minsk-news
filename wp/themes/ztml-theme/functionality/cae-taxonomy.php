<?php

function cae_taxonomy()
{
	register_post_type(
		'cae',
		array(
			'label'               => __('cae'),
			'labels'              => array(
				'name'                => _x('Подкаст', 'Post Type General Name'),
				'singular_name'       => _x('Подкаст', 'Post Type Singular Name'),
				'menu_name'           => __('Причины и следствие'),
			),
			'supports'            => array('title', 'author', 'editor'),
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
}

add_action('init', 'cae_taxonomy', 0);
