<?php

$top_itogi_name = get_option('top_itogi_name');
$top_itogi_name2 = get_option('top_itogi_name2');

$top1_url = get_option('top1_url');
$top1_views = get_option('top1_views');
$top1_title = get_option('top1_title');
$top1_img = get_option('top1_img');

$top2_url = get_option('top2_url');
$top2_views = get_option('top2_views');
$top2_title = get_option('top2_title');
$top2_img = get_option('top2_img');

$top3_url = get_option('top3_url');
$top3_views = get_option('top3_views');
$top3_title = get_option('top3_title');
$top3_img = get_option('top3_img');

if (isset($_POST['submit'])) {
	if (function_exists('current_user_can') && !current_user_can('manage_options'))
		die(_e('Hacker?', 'top_minsk_itogi'));

	if (function_exists('check_admin_referer')) {
		check_admin_referer('top_minsk_itogi_form');
	}

	$top_itogi_name = $_POST['top_itogi_name'];
	$top_itogi_name2 = $_POST['top_itogi_name2'];

	$top1_url = $_POST['top1_url'];
	$top1_views = $_POST['top1_views'];
	$top1_title = $_POST['top1_title'];

	$top2_url = $_POST['top2_url'];
	$top2_views = $_POST['top2_views'];
	$top2_title = $_POST['top2_title'];

	$top3_url = $_POST['top3_url'];
	$top3_views = $_POST['top3_views'];
	$top3_title = $_POST['top3_title'];

	$postid1 = url_to_postid($top1_url);
	$postid2 = url_to_postid($top2_url);
	$postid3 = url_to_postid($top3_url);

	$imgsize = 'td_324x235';
	$top1_img = get_the_post_thumbnail_url($postid1, $imgsize);
	$top2_img = get_the_post_thumbnail_url($postid2, $imgsize);
	$top3_img = get_the_post_thumbnail_url($postid3, $imgsize);

	update_option('top_itogi_name', $top_itogi_name);
	update_option('top_itogi_name2', $top_itogi_name2);

	update_option('top1_url', $top1_url);
	update_option('top1_views', $top1_views);
	update_option('top1_title', $top1_title);
	update_option('top1_img', $top1_img);
	update_option('top1_postid', $postid1);

	update_option('top2_url', $top2_url);
	update_option('top2_views', $top2_views);
	update_option('top2_title', $top2_title);
	update_option('top2_img', $top2_img);
	update_option('top2_postid', $postid2);

	update_option('top3_url', $top3_url);
	update_option('top3_views', $top3_views);
	update_option('top3_title', $top3_title);
	update_option('top3_img', $top3_img);
	update_option('top3_postid', $postid3);
}
