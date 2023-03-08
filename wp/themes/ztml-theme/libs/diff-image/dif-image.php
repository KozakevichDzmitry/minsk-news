<?php

function diff_image_scn($atts)
{
	$str = '<div class="diff-image">';
	$str .= '<figure style="background-image: url(' . $atts['old'] . ');">';
	$str .= '<div id="compare" style="background-image: url(' . $atts['new'] . ');"></div>';
	$str .= '</figure>';
	$str .= '<input oninput="beforeAfter()" onchange="beforeAfter()" type="range" min="0" max="100" value="50" id="slider" />';
	$str .= '</div>';
	return $str;
}

add_shortcode('diff_image', 'diff_image_scn');
