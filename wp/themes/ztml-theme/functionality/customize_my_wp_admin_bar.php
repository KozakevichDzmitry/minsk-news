<?php
function customize_my_wp_admin_bar($wp_admin_bar)
{
    $new_content_node = $wp_admin_bar->get_node('new-content');
    $new_content_node->href = '/wp-admin/post-new.php?post_type=news';
    $wp_admin_bar->add_node($new_content_node);
}