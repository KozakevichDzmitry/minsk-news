<?php

function render_wpadcenter_ads($name)
{
	if (function_exists('carbon_get_the_post_meta') && function_exists('wpadcenter_display_ad')) {
		$id = carbon_get_the_post_meta($name);
		return wpadcenter_display_ad(array('id' => $id, 'align' => 'none'));
	}
}
