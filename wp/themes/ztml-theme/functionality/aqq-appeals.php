<?php

function aqq_appeals()
{
	register_post_type(
		'aqq-appeals',
		array(
			'label'               => __('aqq-appeals'),
			'labels'              => array(
				'name'                => _x('Обращения', 'Post Type General Name'),
				'singular_name'       => _x('Обращения', 'Post Type Singular Name'),
				'menu_name'           => __('Обращения'),
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
			'rewrite' => true
		)
	);
}

add_action('init', 'aqq_appeals', 0);
