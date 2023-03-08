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
    $modern_link = get_permalink($post_ID);
    $share_block .= '<div class="share-block"><div onclick="share_popup(\'https://www.facebook.com/share.php?u=' . $modern_link . '\', \'Поделиться в Facebook\', 650, 500)" class="nk_share_button nk_share_button--fb btn_soc_fb">
		' . render_facebook_share_icon() . '
	</div>';
    $share_block .= '<div onclick="share_popup(\'https://telegram.me/share/url?url=' . $modern_link . '&text=' . get_the_title($post->ID) . '\', \'Поделиться в Телеграме\', 580, 415)" class="nk_share_button nk_share_button--telegram btn_soc_tg">
		' . render_telegram_share_icon() . '
	</div>';
    $share_block .= '<div onclick="share_popup(\'https://vk.com/share.php?url=' . $modern_link . '&title=' . get_the_title($post->ID) . '&image=' . get_the_post_thumbnail_url($post) . '\', \'Поделиться ВКонтакте \', 650, 600)" class="nk_share_button nk_share_button--vk btn_soc_vk">
		' . render_vk_share_icon() . '
	</div>';
    $share_block .= '<div onclick="share_popup(\'https://twitter.com/intent/tweet?text=' . get_permalink($post->ID) . ' ' . urlencode($post->post_title) . '\', \'Твитнуть\', 580, 415)" class="nk_share_button nk_share_button--tw btn_soc_tw">
		' . render_twitter_share_icon() . '
	</div>';
    $share_block .= '<div onclick="share_popup(\'https://connect.ok.ru/offer?url=' . $modern_link . '\', \'Поделиться в Одноклассниках\', 580, 415)" class="nk_share_button nk_share_button--ok btn_soc_ok">
	' . render_ok_share_icon() . '
	</div>';
    $share_block .= '<div onclick="share_popup(\'viber://forward?text=' . $modern_link . '\', \'Поделиться в Вайбере\', 580, 415)" class="nk_share_button nk_share_button--viber btn_soc_vb">
	' . render_viber_icon() . '</div></div>';
    return $share_block;
}

add_shortcode('share_links', 'share_links');
