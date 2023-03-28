<?php
/*
 * Mai Ru Feed
*/
add_action('init', 'customRSS');
function customRSS()
{
    add_feed('mail-ru', 'customRSSFunc');
}

function customRSSFunc()
{
    require_once(dirname(__FILE__) . '/mail-ru-feed/rss-mail-ru.php');
}