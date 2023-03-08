<?php
/*
Plugin Name: ТОП-3 Минск && Итоги
Author: Velial Cypher
Description: not found
Version: 0.0.1
*/

add_action('admin_menu', function () {
	add_option('top_itogi_name', '');
	add_option('top_itogi_name2', '');

	add_option('top1_url', '');
	add_option('top1_views', '');
	add_option('top1_title', '');
	add_option('top1_img', '');
	add_option('top1_postid', '');

	add_option('top2_url', '');
	add_option('top2_views', '');
	add_option('top2_title', '');
	add_option('top2_img', '');
	add_option('top2_postid', '');

	add_option('top3_url', '');
	add_option('top3_views', '');
	add_option('top3_title', '');
	add_option('top3_img', '');
	add_option('top3_postid', '');

	add_options_page(
		'ТОП-3 Минск',
		'ТОП-3 Минск & ИТОГИ',
		'edit_others_posts',
		basename(__FILE__),
		function () {
			require_once(dirname(__FILE__) . "/controllers/settings.php");
			require_once(dirname(__FILE__) . "/templates/dashboard.php");
		}
	);
});
