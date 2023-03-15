<?php
function get_default_news($count, $term, $exclude_list, $add_tax = [])
{
    $q_args = array(
        'post_type' => 'news',
        'posts_per_page' => $count,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'news-list',
                'terms' => $term,
                'field' => 'slug',
            )
        ),
        'post__not_in' => $exclude_list,
    );
    if ($add_tax != NULL) {
        $q_args['tax_query'] = array('relation' => 'AND', $add_tax, $q_args['tax_query'][0]);
    }
    $news_posts = new WP_Query($q_args);

    return $news_posts->posts;
}