<?php

function events_taxonomy()
{
	register_post_type(
		'event',
		array(
			'label'               => __('events'),
			'labels'              => array(
				'name'                => _x('Мероприятия', 'Post Type General Name'),
				'singular_name'       => _x('Мероприятия', 'Post Type Singular Name'),
				'menu_name'           => __('Мероприятия'),
			),
			'show_in_rest' => false,
			'supports'            => array('title', 'author', 'thumbnail', 'editor', 'custom-fields'),
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

add_action('init', 'events_taxonomy', 0);
