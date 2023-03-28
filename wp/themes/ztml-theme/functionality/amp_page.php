<?php
add_action('pre_amp_render_post', 'amp_ads_add');

function amp_ads_add()
{
    add_filter('the_content', 'insert_ads_to_amp');
}

function insert_ads_to_amp($content)
{

    $new_content = ads_add_paragraph(array(
// формат следующий: 'номер абзаца' => 'рекламный код',
        '1' => '<amp-ad
width="auto" 
height="320"
layout="fixed-height"
type="yandex"
data-block-id="R-A-721996-39"
data-html-access-allowed="true">
</amp-ad>',
        '3' => '<amp-ad
width="auto" 
height="320"
layout="fixed-height"
type="yandex"
data-block-id="R-A-721996-52"
data-html-access-allowed="true">
</amp-ad>',
        '5' => '<amp-ad
width="auto" 
height="320"
layout="fixed-height"
type="yandex"
data-block-id="R-A-721996-53"
data-html-access-allowed="true">
</amp-ad>',
        '7' => '<amp-ad
width="auto" 
height="320"
layout="fixed-height"
type="yandex"
data-block-id="R-A-721996-54"
data-html-access-allowed="true">
</amp-ad>',
        '9' => '<amp-ad
width="auto" 
height="320"
layout="fixed-height"
type="yandex"
data-block-id="R-A-721996-55"
data-html-access-allowed="true">
</amp-ad>',
    ), $content);

    return $new_content;

}

function ads_add_paragraph($ads, $content)
{
    if (!is_array($ads)) {
        return $content;
    }

    $closing_p = '</p>';
    $paragraphs = explode($closing_p, $content);

    foreach ($paragraphs as $index => $paragraph) {
        if (trim($paragraph)) {
            $paragraphs[$index] .= $closing_p;
        }

        $n = $index + 1;
        if (isset($ads[$n])) {
            $paragraphs[$index] .= $ads[$n];
        }
    }

    return implode('', $paragraphs);
}