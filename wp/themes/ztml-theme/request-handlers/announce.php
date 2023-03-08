<?php
require_once(COMPONENTS_PATH . 'news-templates.php');
function announce_link()
{
    $id = $_POST['id'];
    ob_start();
    render_new_template_video($id,false, false);

    wp_die();
}

add_action('wp_ajax_announce_link', 'announce_link');
add_action('wp_ajax_nopriv_announce_link', 'announce_link');