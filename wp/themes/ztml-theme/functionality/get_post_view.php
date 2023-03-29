<?php
function gt_get_post_view($post_id)
{
    global $wpdb;
    $table = _get_meta_table('post');
    $count = $wpdb->get_var("SELECT `meta_value` FROM $table WHERE `meta_key` LIKE 'post_views_count' AND `post_id` = $post_id;");
    return $count;
}

function gt_set_post_view($post_id)
{
    global $wpdb;
    $table = _get_meta_table('post');
    $value = gt_get_post_view($post_id);
    if(is_null($value)) {
        $value = 0;
        $wpdb->insert( $table,array(
            'post_id' => $post_id,
            'meta_key' => 'post_views_count',
            'meta_value' => $value,
        ) );
    }else{
        $value ++;
        $wpdb->query( "UPDATE `$table` SET `meta_value`=$value WHERE `meta_key` LIKE 'post_views_count' AND `post_id`=$post_id;" );
    }

    wp_cache_delete( $post_id, 'post_meta' );
}

function gt_posts_column_views($columns)
{
    $columns['post_views'] = 'Views';
    return $columns;
}

function gt_posts_custom_column_views($column)
{
    if ($column === 'post_views') {
        $id = get_the_ID();
        echo gt_get_post_view($id);
    }
}
