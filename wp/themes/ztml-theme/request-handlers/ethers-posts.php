<?php

require_once(COMPONENTS_PATH . 'ether-item.php');
require_once(REQUEST_HANDLERS . 'base-post.php');

function ethers_posts_load()
{
	$template = array(
		'view' => 'render_ether_item'
	);

	$res = base_load_posts(
		array(
			'load' => $_POST['load'],
			'offset' => $_POST['offset'],
			'type' => 'aaq',
			'date' => NULL,
			'tax_query' => NULL,
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

add_action('wp_ajax_ethers_posts_load', 'ethers_posts_load');
add_action('wp_ajax_nopriv_ethers_posts_load', 'ethers_posts_load');
