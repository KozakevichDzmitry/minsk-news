<?php
add_shortcode('socials', 'social_shortcode');
function social_shortcode()
{
    $r = '<div class="social-icons">';
    foreach (carbon_get_the_post_meta('socials') as $item) :
        $r .= '<div class="social-icon__wparapper">';
        $r .= '<a href="' . $item['link'] . '"><img alt="' . get_post_meta($item['icon'], '_wp_attachment_image_alt', TRUE) . '" src="' . wp_get_attachment_url($item['icon']) . '" width="30"></a>';
        $r .= '</div>';
    endforeach;
    $r .= '</div>';
    return $r;
}