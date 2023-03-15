<?php
add_shortcode("iframe", "iframe_scn");
function iframe_scn($atts)
{
    $atts = shortcode_atts(array(
        'src' => 'https://www.youtube.com/watch?v=be6vDZj3-fs',
        'frameborder' => '0',
        'allowfullscreen' => 'allowfullscreen'
    ), $atts);

    return '<iframe title="YouTube video player" src="' . $atts['src'] . '" width="560" height="315" frameborder="' . $atts['frameborder'] . '" allowfullscreen="' . $atts['allowfullscreen'] . '"></iframe>';
}