<?php
require_once(COMPONENTS_PATH . 'news-whole-post.php');

function loadmore_news()
{
	global $post;
	$args = array(
		'post_status' => 'publish',
		'posts_per_page' => $_POST['load'],
		'post_type' => 'news',
		'exclude' => $_POST['exclude'],
		'offset' => $_POST['offset'],
	);

	$posts = get_posts($args);

	if (!empty($posts)) {
		foreach ($posts as $post) {
			update_post_meta($post->ID, 'post_key', 'meta_value');
			render_news_whole_post($post->ID);
		}
	}

	die();
}

add_action('wp_ajax_loadmorenews', 'loadmore_news');
add_action('wp_ajax_nopriv_loadmorenews', 'loadmore_news');
