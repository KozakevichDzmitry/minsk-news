<?php

require_once(COMPONENTS_PATH . 'line-regular-news.php');

function load_more_news()
{
	$args = array(
		'post_type' => 'news',
		'post_status' => 'publish',
	);

	$args['posts_per_page'] = $_POST['load'];
	$args['offset'] = $_POST['show'];

	// $posts = get_posts($args);

	// foreach ($posts as $pst) {
	// 	render_line_regular_news($pst->ID, true);
	// }
}

add_action('wp_ajax_load_more_news', 'load_more_news');
add_action('wp_ajax_nopriv_load_more_news', 'load_more_news');
