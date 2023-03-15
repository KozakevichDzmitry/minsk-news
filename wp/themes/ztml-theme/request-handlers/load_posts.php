<?php
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