<?php
add_action('save_post_news', 'update_front_news', 100, 2);
function update_front_news($post_id)
{

    if (wp_is_post_revision($post_id) || get_post($post_id)->post_status != 'publish') return;

    $terms = wp_get_post_terms($post_id, 'news-list', ['fields' => 'slugs']);

    $users = carbon_get_post_meta(16, 'authors_column_sticked_authors');

    $post_author = NULL;
    $authorID = get_post_field('post_author');
    foreach ($users as $user) {

        if ($authorID == $user['id']) {
            $post_author = $authorID;
        }
    }

    $context = new ZMQC();
    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
    $socket->connect("tcp://127.0.0.1:5555");
    $socket->send(json_encode([
        'event' => 'news_block_update',
        'post_id' => $post_id,
        'update_blocks' => $terms,
        'district_update_blocks' => wp_get_post_terms($post_id, 'news-district', ['fields' => 'slugs']),
        'event_type' => get_post_type($post_id),
        'author_id' => $post_author,
    ]));
}

add_action('save_post_video', 'update_front_video', 100, 2);
function update_front_video($post_id)
{
    if (wp_is_post_revision($post_id) || get_post($post_id)->post_status != 'publish') return;

    $context = new ZMQC();
    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
    $socket->connect("tcp://127.0.0.1:5555");
    $socket->send(json_encode([
        'event' => 'video_block_update',
        'post_id' => $post_id,
        'event_type' => get_post($post_id)->post_type,
        'carbon' => true
    ]));

}

add_action('save_post_authors-column', 'update_front_authors_column', 100, 2);
function update_front_authors_column($post_id)
{
    if (wp_is_post_revision($post_id) || get_post($post_id)->post_status != 'publish') return;

    $users = carbon_get_post_meta(16, 'authors_column_sticked_authors');

    $post_author = NULL;
    foreach ($users as $user) {
        if (get_post($post_id)->post_author == $user['id']) {
            $post_author = $user['id'];
        }
    }

    if ($post_author == NULL) return;

    $context = new ZMQC();
    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
    $socket->connect("tcp://127.0.0.1:5555");
    $socket->send(json_encode([
        'event' => 'authors_column_update',
        'author_id' => $post_author,
        'post_id' => $post_id,
        'carbon' => true
    ]));

}

add_action('save_post_newspaper', 'update_front_newspaper', 100, 2);
function update_front_newspaper($post_id)
{
    if (wp_is_post_revision($post_id) || get_post($post_id)->post_status != 'publish') return;

    $context = new ZMQC();
    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
    $socket->connect("tcp://127.0.0.1:5555");
    $socket->send(json_encode([
        'event' => 'newspaper',
        'post_id' => $post_id,
        'event_type' => get_post($post_id)->post_type,
        'carbon' => true
    ]));
}