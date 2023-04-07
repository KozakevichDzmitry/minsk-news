<?php
function get_attached_news($count, $term, $add_tax = NULL, $attached = false, $cache_results=true)
{
    $date_now = (new DateTime("now", new DateTimeZone('Europe/Minsk')))->format('Y-m-d H:i:s');

    $q_args = array(
        'post_type' => 'news',
        'posts_per_page' => $count,
        'no_found_rows' => true,
        'post_status' => 'publish',
        'orderby' => 'publish_date',
        'order' => 'DESC',
        'cache_results' => $cache_results,
        'tax_query' => array(
            array(
                'taxonomy' => 'news-list',
                'field' => 'slug',
                'terms' => $term,
            ),
        ),
    );
    if ($attached) {
        $q_args['meta_query'] = array(
            array(
                'key' => 'news_is_attached',
                'value' => 'yes',
            ),
            array(
                'key' => '_news_is_attached_time_to',
                'value' => $date_now,
                'compare' => '>',
                'type' => 'DATETIME '
            ),
            array(
                'key' => '_news_is_attached_time_from',
                'value' => $date_now,
                'compare' => '<',
                'type' => 'DATETIME '
            ),
        );
        $q_args['date_query'] = array('after' => '1 months ago');
    }


    if ($add_tax != NULL) {
        $q_args['tax_query'] = array('relation' => 'AND', $add_tax, $q_args['tax_query'][0]);
    }

    $news_posts = new WP_Query($q_args);
    $exclude_list = array();

    foreach ($news_posts->posts as $post) {
        array_push($exclude_list, $post->ID);
    }

    $needs_posts_count = $count - count($news_posts->posts);

    if ($needs_posts_count > 0) {
        $adds_news_args = [
            'post_type' => 'news',
            'posts_per_page' => $needs_posts_count,
            'post_status' => 'publish',
            'cache_results' => $cache_results,
            'tax_query' => array(
                array(
                    'taxonomy' => 'news-list',
                    'terms' => $term,
                    'field' => 'slug',
                )
            ),
            'orderby' => 'date',
            'post__not_in' => $exclude_list,
        ];

        if ($add_tax != NULL) {
            $adds_news_args['tax_query'] = array(
                array(
                    'taxonomy' => 'news-list',
                    'terms' => $term,
                    'field' => 'slug',
                ),
                'relation' => 'AND',
                $add_tax
            );
        }

        $adds_news_quary = new WP_Query($adds_news_args);
        $news_posts->posts = array_merge($news_posts->posts, $adds_news_quary->posts);

        $add_posts_id_exclude = array();

        foreach ($adds_news_quary->posts as $post) {
            array_push($add_posts_id_exclude, $post->ID);
        }

        $exclude_list = array_merge($exclude_list, $add_posts_id_exclude);
    }

    return array(
        'posts' => $news_posts->posts,
        'ids' => $exclude_list
    );
}