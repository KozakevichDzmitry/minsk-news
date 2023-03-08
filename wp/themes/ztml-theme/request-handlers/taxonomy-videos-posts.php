<?php

require_once(REQUEST_HANDLERS . 'base-post.php');

function taxonomy_videos_posts_load()
{
	$template = array(
		'view' => 'render_new_template_video'
	);

	$res = base_load_posts(
		array(
			'load' => $_POST['load'],
			'offset' => $_POST['offset'],
			'type' => 'video',
			'date' => $_POST['date'],
			'tax_query' => $_POST['tax_query'],
		)
	);

	ob_start();

	$template_posts_html = ob_start();

?>

	<?php foreach ($res['posts'] as $post) : ?>
			<?php $template['view']($post->ID); ?>
	<?php endforeach; ?>


<?php


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

add_action('wp_ajax_taxonomy_videos_posts_load', 'taxonomy_videos_posts_load');
add_action('wp_ajax_nopriv_taxonomy_videos_posts_load', 'taxonomy_videos_posts_load');
