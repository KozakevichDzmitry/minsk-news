<?php

require_once(COMPONENTS_PATH . "icons/location-icon.php");
require_once(COMPONENTS_PATH . "icons/camera-icon.php");
require_once(COMPONENTS_PATH . "icons/video-content-icon.php");

function render_content_exist_markers($id, $is_white = false)
{
	$photos_extis = carbon_get_post_meta($id, 'crb_post_extist_content_photo');
	$videos_extis = carbon_get_post_meta($id, 'crb_post_extist_content_video');
	$geos_extis = carbon_get_post_meta($id, 'crb_post_extist_content_places');

	if ($photos_extis == true) {
		if ($is_white) {
			render_camera_icon('white', 1);
		} else {
			render_camera_icon();
		}
	}

	if ($videos_extis == true) {
		if ($is_white) {
			render_video_content_icon('white', 1);
		} else {
			render_video_content_icon();
		}
	}

	if ($geos_extis == true) {
		if ($is_white) {
			render_location_icon('white', 1);
		} else {
			render_location_icon();
		}
	}
}
