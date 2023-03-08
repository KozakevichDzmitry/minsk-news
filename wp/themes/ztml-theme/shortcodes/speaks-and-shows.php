<?php

function speaks_and_shows()
{
	$news_posts_quary = new WP_Query([
		'posts_per_page' => 1,
		'post_status' => array('publish', 'future'),
		'post_type' => 'video',
		'tax_query' => array(
			array(
				'taxonomy' => 'videos',
				'field' => 'slug',
				'terms' => 'govorit-i-pokazyvaet-minsk',
			)
		)
	]);

	$news_posts = $news_posts_quary->posts;

	echo '<h3 class="widget-title">Гoвoрит и пoказывает Минск</h3>';

	echo '<div class="box box-list no-lines">';
	foreach ($news_posts as $pst) {
		render_new_template_video($pst->ID, true);
	}
	echo '</div>';
}

add_shortcode('speaks_and_shows_scn', 'speaks_and_shows');
