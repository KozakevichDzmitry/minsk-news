<?php

require_once(COMPONENTS_PATH . '/icons/facebook-share-icon.php');
require_once(COMPONENTS_PATH . '/icons/instagram-share-icon.php');
require_once(COMPONENTS_PATH . '/icons/ok-share-icon.php');
require_once(COMPONENTS_PATH . '/icons/telegram-share-icon.php');
require_once(COMPONENTS_PATH . '/icons/twitter-share-icon.php');
require_once(COMPONENTS_PATH . '/icons/viber-share-icon.php');
require_once(COMPONENTS_PATH . '/icons/vk-share-icon.php');

function share_links($post_ID=null)
{
    global $post;
    $share_block = '';
    if(!$post_ID)$post_ID= $post->ID;
    if(!$post) $post =  get_post($post_ID);
    $modern_link = get_permalink($post_ID);
    $share_block .= '<div class="share-block">';
    $share_block .='<a data-link=' . $modern_link . ' class="share_button" id="facebook">';
    $share_block .= 'facebook</a>';
    $share_block .= '<a data-link=' . $modern_link . ' data-title=' . get_the_title($post_ID) . ' class="share_button" id="telegram">';
    $share_block .= 'telegram</a>';
    $share_block .= '<a data-link=' . $modern_link . ' data-title=' . get_the_title($post_ID) . ' class="share_button" id="vk">';
    $share_block .= 'vk</a>';
    $share_block .= '<a data-link=' . $modern_link . ' data-title=' . urlencode($post->post_title) . ' class="share_button" id="tw">';
    $share_block .= 'twitter</a>';
    $share_block .= '<a data-link=' . $modern_link . ' class="share_button" id="ok">';
    $share_block .= 'ok</a>';
    $share_block .= '<a data-link=' . $modern_link . ' class="share_button" id="viber" onclick="share_popup(\'viber://forward?text=' . $modern_link . '\', \'Поделиться в Вайбере\', 580, 415)">';
    $share_block .= 'viber</a></div>';
    return $share_block;
}

add_shortcode('share_links', 'share_links');
