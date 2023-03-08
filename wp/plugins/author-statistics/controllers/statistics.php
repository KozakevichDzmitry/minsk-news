<?php

function get_statistics_handler()
{
	global $wpdb;

	$sql_quary = $wpdb->prepare(
		"SELECT u.ID,display_name,COUNT(p.post_author) as count FROM (SELECT ID, display_name FROM $wpdb->users) as u LEFT JOIN $wpdb->posts p ON u.ID = p.post_author AND post_date BETWEEN %s AND %s GROUP BY display_name",
		array(
			date("Y-m-d", strtotime($_POST['fromDate'])),
			date("Y-m-d", strtotime($_POST['toDate']))
		)
	);

	echo json_encode($wpdb->get_results($sql_quary));
	wp_die();
}

add_action("wp_ajax_get_statistics_handler", "get_statistics_handler");
