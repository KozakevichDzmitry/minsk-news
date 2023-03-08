<?php

require_once(COMPONENTS_PATH . 'news-templates.php');
require_once(COMPONENTS_PATH . 'news-templates/timeline-news-template.php');

function timeline_news_load()
{
	$args = array();

	$args['posts_per_page'] = $_POST['load'];
	$args['offset'] = $_POST['offset'];
	$args['post_status'] = 'publish';
	$args['post_type'] = 'any';
	$args['tax_query'] = array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'news-list',
			'field' => 'slug',
			'terms' => 'feed'
		),
		array(
			'taxonomy' => 'meri-list',
			'field' => 'slug',
			'terms' => 'feed'
		)
	);

	$posts = get_posts($args);

	foreach ($posts as $id => $pst) {
		if ($id === count($posts) - 1) {
			render_timeline_line_news($pst->ID, true);
		} else {
			render_timeline_line_news($pst->ID);
		}
	}

	die();
}

add_action('wp_ajax_timeline_news_load', 'timeline_news_load');
add_action('wp_ajax_nopriv_timeline_news_load', 'timeline_news_load');

function timeline_main_news_load()
{
	$args = array();

	$args['posts_per_page'] = $_POST['load'];
	$args['offset'] = $_POST['offset'];
	$args['post_status'] = 'publish';
	$args['post_type'] = 'news';

	$posts = get_posts($args);

	foreach ($posts as $pst) {
		render_news_template_line($pst->ID);
	}

	die();
}

add_action('wp_ajax_timeline_main_news_load', 'timeline_main_news_load');
add_action('wp_ajax_nopriv_timeline_main_news_load', 'timeline_main_news_load');
