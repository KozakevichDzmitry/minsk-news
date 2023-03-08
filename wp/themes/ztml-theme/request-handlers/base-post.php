<?php

function base_load_posts(
	$fn_args = array(
		'load' => 10,
		'offset' => 0,
		'type' => 'news',
	)
) {
    $q_args = array(
        'posts_per_page' => $fn_args['load'],
        'post_type' => $fn_args['type'],
        'offset' => $fn_args['offset'],
        'post_status' => 'publish',
        'order' => "DESC",
    );
    if ($fn_args['author']) {
        $q_args['author'] =  $fn_args['author'];
    }

	if (!empty($fn_args['tax_query'])) {
		$q_args['tax_query'] =  array($fn_args['tax_query']);
	}

	if (!empty($fn_args['date'])) {
		$date = date('Y-m-d', strtotime($fn_args['date'] . ' 00:00:00'));
		$q_args['date_query'] = array(
			array(
				'after' => "$date 00:00:00",
			),
		);
		$q_args['order'] = 'ASC';
	}


	$posts = get_posts($q_args);
    $count_posts = wp_count_posts($q_args['post_type'])->publish;


	return array(
		'posts' => $posts,
		'count' => $count_posts,
	);
}
