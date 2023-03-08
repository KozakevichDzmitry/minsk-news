<?php
function getWpadcenterPostData()
{
$options[0] = 'Без рекламы';
    $ads = get_posts(array(
        'posts_per_page'=> -1,
        'post_type' => 'wpadcenter-ads',
    ));
    if ($ads) {
        foreach ($ads as $a) {
            $options[$a->ID] = $a->post_name;
        }
    }
    return $options;
}