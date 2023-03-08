<?php

require_once(REQUEST_HANDLERS . 'base-post.php');

function main_timline_tape_load()
{
	$template = array(
		'view' => 'render_news_template_line'
	);

	$tax = array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'news-list',
			'field' => 'slug',
			'terms' => 'main'
		),
		array(
			'taxonomy' => 'meri-list',
			'field' => 'slug',
			'terms' => 'main'
		)
	);

	$res = base_load_posts(
		array(
			'load' => $_POST['load'],
			'offset' => $_POST['offset'],
			'type' => 'any',
			'date' => $_POST['date'],
			'tax_query' => $tax,
		)
	);

	foreach ($res['posts'] as $post) {
		$template['view']($post->ID);
	}

	die();
}

add_action('wp_ajax_main_timline_tape_load', 'main_timline_tape_load');
add_action('wp_ajax_nopriv_main_timline_tape_load', 'main_timline_tape_load');
