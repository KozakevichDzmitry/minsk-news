<?php

require_once(REQUEST_HANDLERS . 'base-post.php');

function taxonomy_cae_load()
{
	$template = array(
		'view' => 'render_cae_item_list'
	);

	$res = base_load_posts(
		array(
			'load' => $_POST['load'],
			'offset' => $_POST['offset'],
			'type' => $_POST['post_type'],
			'date' => $_POST['date'],
			'tax_query' => $_POST['tax_query'],
		)
	);

	ob_start();

	$template_posts_html = ob_start();

	foreach ($res['posts'] as $post) {
		$template['view']($post->ID);
	}

	$template_posts_html = ob_get_clean();
	ob_end_flush();

	echo json_encode(
		array(
			'posts' => $template_posts_html,
			'count' => $res['count']
		)
	);

	die();
}

add_action('wp_ajax_taxonomy_cae_load', 'taxonomy_cae_load');
add_action('wp_ajax_nopriv_taxonomy_cae_load', 'taxonomy_cae_load');
