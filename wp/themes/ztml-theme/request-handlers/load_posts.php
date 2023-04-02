<?php
add_action('wp_ajax_loadmore', 'load_posts');
add_action('wp_ajax_nopriv_loadmore', 'load_posts');
function load_posts()
{
    $args = unserialize(stripslashes($_POST['query']));
    $args['posts_per_page'] = $_POST['load'];
    $args['offset'] = $_POST['show'];
    $posts = get_posts($args);

    if (!empty($posts)) {
        foreach ($posts as $pst) {
            get_template_part('./components/tpl-' . $_POST['tpl'], null, ['ID' => $pst->ID]);
        }
        die();
    }
}