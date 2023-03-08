<?php

function district_taxonomy()
{
	register_post_type(
		'district',
		array(
			'label'               => __('districts'),
			'labels'              => array(
				'name'                => _x('Район', 'Post Type General Name'),
				'singular_name'       => _x('Район', 'Post Type Singular Name'),
				'menu_name'           => __('Районы'),
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
			'rewrite' => true
		)
	);
}

add_action('init', 'district_taxonomy', 0);
