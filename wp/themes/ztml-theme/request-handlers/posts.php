<?php

require_once(COMPONENTS_PATH . 'half-post.php');

function load_posts_by_date()
{
	$args = unserialize(stripslashes($_POST['query']));
	$args['posts_per_page'] = $_POST['load'];
	$args['offset'] = $_POST['show'];
	$args['post_status'] = 'publish';
	$args['post_type'] = $_POST['post_type'];

	if (!empty($_POST['date'])) {
		$date = date('Y-m-d', strtotime($_POST['date'] . ' 00:00:00'));
		$args['date_query'] = array(
			array(
				'before' => "$date 00:00:00",
			),
		);
		$args['order'] = 'ASC';
	}

	$posts = get_posts($args);

	if ($_POST['tpl'] == "single-authors-column") {
		foreach ($posts as $pst) {
			render_half_post($pst->ID);
		}
	} else {
		foreach ($posts as $pst) {
			render_line_news_list_item($pst->ID, true);
		}
	}

	die();
}

add_action('wp_ajax_load_posts_by_date', 'load_posts_by_date');
add_action('wp_ajax_nopriv_load_posts_by_date', 'load_posts_by_date');
