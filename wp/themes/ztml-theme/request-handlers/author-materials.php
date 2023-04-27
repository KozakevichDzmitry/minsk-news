<?php

function author_materials_load()
{
	$res = base_load_posts(
		array(
			'load' => $_POST['load'],
			'offset' => $_POST['offset'],
			'type' => array('news', 'authors-column'),
            'author' => $_POST['authorID'],
			'date' => $_POST['date'],
		)
	);

	ob_start();

	$template_posts_html = ob_start();

	foreach ($res['posts'] as $post) {
		if ($post->post_type === 'news') {
			render_line_regular_news($post->ID, true);
		} elseif ($post->post_type === 'authors-column') {
			render_line_news_list_item($post->ID, true);
		}
	}

	$template_posts_html = ob_get_clean();
	ob_end_flush();

	echo json_encode(
		array(
			'posts' => $template_posts_html,
		)
	);

	die();
}

add_action('wp_ajax_author_materials_load', 'author_materials_load');
add_action('wp_ajax_nopriv_author_materials_load', 'author_materials_load');
