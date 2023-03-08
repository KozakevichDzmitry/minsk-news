<?php
/*
Plugin Name: Статистика по журналистам
Author: Velial Cypher
Description: not found
Version: 0.0.1
*/

require_once(dirname(__FILE__) . "/controllers/statistics.php");

add_action('admin_menu', function () {
	add_menu_page(
		'Статистика по журналистам',
		'Статистика',
		'edit_others_posts',
		'author-statistics',
		function () {
			require_once(dirname(__FILE__) . "/templates/dashboard.php");
			wp_enqueue_script('author-statistics-main-js', plugin_dir_url(__FILE__) . 'js/index.js', array('jquery'));
		},
		'dashicons-buddicons-buddypress-logo',
		6
	);
});
