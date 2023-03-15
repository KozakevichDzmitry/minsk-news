<?php
function get_my_taxonomies($post_ID)
{
    $post_type = get_post_type($post_ID);
    $taxonomies = get_object_taxonomies($post_type);
    if ($taxonomies) {
        if (in_array('news-list', $taxonomies)) $term = 'news-list';
        else $term = array_shift($taxonomies);
    }
    return $term;
}