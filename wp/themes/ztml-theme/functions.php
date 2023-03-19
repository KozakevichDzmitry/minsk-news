<?php

// Все работает?
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . "/tv-parser.php");

use ZMQContext as ZMQC;

define('COMPONENTS_PATH', dirname(__FILE__) . '/components/');
define('FUNC_PATH', dirname(__FILE__) . '/functionality/');
define('REQUEST_HANDLERS', dirname(__FILE__) . '/request-handlers/');
define('IMAGES_PATH', dirname(__FILE__) . '/assets/images/');
define('LIBS_PATH', dirname(__FILE__) . '/libs/');
define('WIDGETS_PATH', dirname(__FILE__) . '/widget-templates/');
define('SHORTCODES_PATH', dirname(__FILE__) . '/shortcodes/');
if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], ' Chrome/' ) !== false ) {
    define('WEBP_SUPPORT', true);
}else{
    define('WEBP_SUPPORT', false);
}
if (!defined('_S_VERSION')) {
    define('_S_VERSION', '2.0');
}

require_once(dirname(__FILE__) . '/gallery/gallery.php');
require_once(FUNC_PATH . 'carbon-fields.php');
require_once(FUNC_PATH . 'events-taxanomy.php');
require_once(FUNC_PATH . 'newspaper-taxonomy.php');
require_once(FUNC_PATH . 'district-taxonomy.php');
require_once(FUNC_PATH . 'nav-locations.php');
require_once(FUNC_PATH . 'cae-taxonomy.php');
require_once(FUNC_PATH . 'aaq-taxonomy.php');
require_once(FUNC_PATH . 'aqq-appeals.php');
require_once(FUNC_PATH . 'primite-meri-taxonomy.php');
require_once(FUNC_PATH . 'authors-column-taxonomy.php');
require_once(FUNC_PATH . 'video-taxonomy.php');
require_once(FUNC_PATH . 'programs-post_type.php');
require_once(FUNC_PATH . 'post-dublicate.php');
require_once(FUNC_PATH . 'news-taxonomy.php');
require_once(FUNC_PATH . 'widgets.php');
require_once(FUNC_PATH . 'trim_excerpt.php');
require_once(FUNC_PATH . 'custom_excerpt_length.php');
require_once(FUNC_PATH . 'get_attached_news.php');
require_once(FUNC_PATH . 'get_default_news.php');
require_once(FUNC_PATH . 'get_post_view.php');
require_once(FUNC_PATH . 'get_my_taxonomies.php');
require_once(FUNC_PATH . 'get_post_primary_category.php');
require_once(FUNC_PATH . 'customize_my_wp_admin_bar.php');

require_once(COMPONENTS_PATH . "pdf-attachments.php");
require_once(COMPONENTS_PATH . 'satms-list-tem.php');
require_once(COMPONENTS_PATH . 'cae-list-item.php');
require_once(COMPONENTS_PATH . 'line-news-list-item.php');
require_once(COMPONENTS_PATH . 'news-templates/main-news-template.php');
require_once(COMPONENTS_PATH . 'single-satm-slide.php');
require_once(COMPONENTS_PATH . 'plus_and_zen_post.php');

require_once(REQUEST_HANDLERS . 'posts.php');
require_once(REQUEST_HANDLERS . 'timeline.php');
require_once(REQUEST_HANDLERS . 'news.php');
require_once(REQUEST_HANDLERS . 'news-posts.php');
require_once(REQUEST_HANDLERS . 'taxonomy-news-posts.php');
require_once(REQUEST_HANDLERS . 'taxonomy-authors-column-posts.php');
require_once(REQUEST_HANDLERS . 'taxonomy-take-action.php');
require_once(REQUEST_HANDLERS . 'taxonomy-cae-posts.php');
require_once(REQUEST_HANDLERS . 'main-timline-tape.php');
require_once(REQUEST_HANDLERS . 'author-materials.php');
require_once(REQUEST_HANDLERS . 'loadmore.php');
require_once(REQUEST_HANDLERS . 'load_posts.php');
require_once(REQUEST_HANDLERS . 'taxonomy-videos-posts.php');
require_once(REQUEST_HANDLERS . 'ethers-posts.php');
require_once(REQUEST_HANDLERS . 'web-sockets.php');
require_once(REQUEST_HANDLERS . 'tv-program.php');

require_once(SHORTCODES_PATH . 'extrenal-radio-player.php');
require_once(SHORTCODES_PATH . 'eternal-video.php');
require_once(SHORTCODES_PATH . 'subscribe-form.php');
require_once(SHORTCODES_PATH . 'share-links.php');
require_once(SHORTCODES_PATH . 'top-three-minsk.php');
require_once(SHORTCODES_PATH . 'speaks-and-shows.php');
require_once(SHORTCODES_PATH . 'social-icons.php');
require_once(SHORTCODES_PATH . 'iframe_scn.php');

require_once(WIDGETS_PATH . 'activity-widget.php');
function crb_register_custom_fields()
{
    require_once(WIDGETS_PATH . 'news-widget.php');
    require_once(WIDGETS_PATH . 'mery-widget.php');
    require_once(WIDGETS_PATH . 'news-video-widget.php');
    require_once(WIDGETS_PATH . 'announce-widget.php');

}

add_action('carbon_fields_register_fields', 'crb_register_custom_fields');

add_theme_support('admin-bar', array('callback' => '__return_false'));
add_theme_support('post-thumbnails');
add_image_size( 'post-thumbnails', 430, 325 );
add_image_size( 'newspaper-thumbnails', 280, 210 );

function add_post_formats()
{
    add_theme_support('post-formats', array('gallery', 'quote', 'video', 'aside', 'image', 'link'));
}

add_action('after_setup_theme', 'add_post_formats', 20);

add_filter('wpcf7_form_elements', function ($form) {
    return do_shortcode($form);
});

function page_scripts()
{
    global $wp_query;
    global $template;
    $template = basename($template);

    wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/styles/style.min.css', array(), _S_VERSION);
    wp_enqueue_script('main-head', get_template_directory_uri() . '/assets/js/main-head.min.js', array('jquery'), _S_VERSION);
    wp_enqueue_script('main-footer', get_template_directory_uri() . '/assets/js/main-footer.min.js', array('jquery'), _S_VERSION, true);
    wp_localize_script('main-head', 'ajaxpagination', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'query_vars' => json_encode($wp_query->query)
    ));
    sticky_sidebar_register();
    wp_deregister_style('classic-theme-styles');
    wp_deregister_style('contact-form-7');

    if (is_front_page()) {
        calendar_register();
        swiper_register();
        wp_enqueue_script('home', get_template_directory_uri() . '/assets/js/home.min.js', array('jquery', 'jquery-ui', 'swiper', 'calendar'), _S_VERSION, true);
        wp_enqueue_script('autoban-lib', 'https://cdnjs.cloudflare.com/ajax/libs/autobahn/20.9.2/autobahn.min.js', null, null, true);
        wp_enqueue_script('sockets', get_template_directory_uri() . '/assets/js/sockets.min.js', array('jquery', 'autoban-lib'), _S_VERSION, true);
    } else {
        if ($template === 'about.php') {
            wp_enqueue_script('countUp', get_template_directory_uri() . '/assembly/src/libs/countup/countUp.min.js', array('jquery'), _S_VERSION, true);
            wp_enqueue_script('about-page', get_template_directory_uri() . '/assets/js/about.min.js', array('jquery', 'countUp'), _S_VERSION, true);
        } elseif ($template == 'all-news.php') {
            calendar_register();
            swiper_register();
            wp_enqueue_script('all-news', get_template_directory_uri() . '/assets/js/all-news.min.js', array('jquery', 'swiper'), _S_VERSION, true);
        } elseif ($template == 'all-videos.php') {
            calendar_register();
            wp_enqueue_script('all-videos', get_template_directory_uri() . '/assets/js/all-videos.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'appeal.php') {
            wp_enqueue_script('appeal-page', get_template_directory_uri() . '/assets/js/appeal.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'ask-a-question.php') {
//            wp_enqueue_script('eternal-video', get_template_directory_uri() . '/assets/js/eternal-video.min.js', array('jquery'), _S_VERSION, true);
            swiper_register();
            wp_enqueue_script('aaq', get_template_directory_uri() . '/assets/js/aaq.min.js', array('jquery', 'swiper'), _S_VERSION, true);
        } elseif ($template == 'author.php') {
            calendar_register();
            wp_enqueue_script('author-page', get_template_directory_uri() . '/assets/js/author.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'authors-column.php') {
            calendar_register();
            wp_enqueue_script('authors-column', get_template_directory_uri() . '/assets/js/authors-column.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'cae.php') {
            calendar_register();
            wp_enqueue_script('cae', get_template_directory_uri() . '/assets/js/cae.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'single-cae.php') {
            wp_enqueue_script('cae', get_template_directory_uri() . '/assets/js/single-cae.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'events.php') {
            //нет такой стрицы
            swiper_register();
            wp_enqueue_script('events.js', get_template_directory_uri() . '/assets/js/events.min.js', array('jquery', 'swiper'), _S_VERSION, true);
        } elseif ($template == 'management.php') {
            wp_enqueue_script('management', get_template_directory_uri() . '/assets/js/management.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'page-advertisement.php') {
            wp_enqueue_script('advertisement', get_template_directory_uri() . '/assets/js/advertisement.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'radio-minsk.php') {
            swiper_register();
            wp_enqueue_script('radio-minsk-page', get_template_directory_uri() . '/assets/js/radio-minsk.min.js', array('jquery', 'swiper'), _S_VERSION, true);
        } elseif ($template == 'satms.php') {
            //нет такой стрицы
            wp_enqueue_script('satms', get_template_directory_uri() . '/assets/js/satms.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == "single-authors-column.php") {
            wp_enqueue_script('single-authors-column', get_template_directory_uri() . '/assets/js/single-authors-column.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'single-district.php') {
            wp_enqueue_style('swiper-css', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper.css', null, null);
            wp_enqueue_script('swiper-old', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper-old.min.js', array('jquery'), null, true);
            slick_lightbox_register();
            wp_enqueue_script('district-page', get_template_directory_uri() . '/assets/js/single-district.min.js', array('jquery', 'slick-min', 'slick-lightbox-min'), _S_VERSION, true);
        } elseif ($template == "single-event.php") {
            slick_register();
            wp_enqueue_script('single-event', get_template_directory_uri() . '/assets/js/single-event.min.js', array('jquery', 'slick-min'), _S_VERSION, true);
        } elseif ($template == "single-news.php") {
            wp_enqueue_script('single-news', get_template_directory_uri() . '/assets/js/single-news.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'single-satm.php') {
            wp_enqueue_script('single-satm', get_template_directory_uri() . '/assets/js/single-satm.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'take-action.php') {
            calendar_register();
            wp_enqueue_script('take-action', get_template_directory_uri() . '/assets/js/take-action.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == "taxonomy-meri-list.php") {
            calendar_register();
        } elseif ($template == "taxonomy-news-list.php") {
            calendar_register();
            wp_enqueue_script('taxonomy-news', get_template_directory_uri() . '/assets/js/taxonomy-news.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'taxonomy-newspapers.php') {
            wp_enqueue_script('newspaper', get_template_directory_uri() . '/assets/js/newspapers.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'taxonomy-videos.php') {
            calendar_register();
            wp_enqueue_script('taxonomy-videos', get_template_directory_uri() . '/assets/js/taxonomy-videos.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'tv-programme.php') {
            slick_register();
            wp_enqueue_script('accordion-components', get_template_directory_uri() . '/assets/js/components/accordion.min.js', array('jquery'), _S_VERSION, true);
            wp_enqueue_script('tv-programme-page', get_template_directory_uri() . '/assets/js/tv-programms.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == "your-district.php") {
            slick_register();
            wp_enqueue_script('your-district-page', get_template_directory_uri() . '/assets/js/your-district.min.js', array('jquery', 'slick-min', 'slick-lightbox-min'), _S_VERSION, true);
        }
    }
}

function swiper_register()
{
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper.css');
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper.js', array('jquery'));
}

function sticky_sidebar_register()
{
    wp_enqueue_script('sticky-sidebar', get_template_directory_uri() . '/assembly/src/libs/sticky-sidebar/sticky-sidebar.min.js', array('jquery'), null, true);
    wp_enqueue_script('sidebar', get_template_directory_uri() . '/assets/js/sidebar.min.js', array('jquery, sticky-sidebar'),  _S_VERSION, true);
}

function slick_register()
{
    wp_enqueue_style('slick-css', get_template_directory_uri() . '/assembly/src/libs/slick/slick.css');
    wp_enqueue_style('slick-theme-css', get_template_directory_uri() . '/assembly/src/libs/slick/slick-theme.css');
    wp_enqueue_script('slick-min', get_template_directory_uri() . '/assembly/src/libs/slick/slick.min.js', array('jquery'));
}

function slick_lightbox_register()
{
    wp_enqueue_style('slick-lightbox-css', get_template_directory_uri() . '/assembly/src/libs/slick-lightbox/slick-lightbox.css');
    wp_enqueue_script('slick-lightbox-min', get_template_directory_uri() . '/assembly/src/libs/slick-lightbox/slick-lightbox.min.js', array('jquery'));
}

function calendar_register()
{
    wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.13.2/jquery-ui.min.js', array('jquery'), null, true);
    wp_enqueue_script('datepicker-ru', get_template_directory_uri() . '/assembly/src/libs/datepicker-ru/datepicker-ru.js', array('jquery-ui', 'jquery'), null, true);
    wp_enqueue_script('calendar', get_stylesheet_directory_uri() . '/assets/js/calendar.min.js', array('jquery-ui', 'datepicker-ru'), null, true);
}

add_action('wp_enqueue_scripts', 'page_scripts');
add_action('admin_head', function ()
{
    echo '<style>
    .cf-container__tabs-item--current {
  border-bottom-color: #dc1d1d!important;
}

  </style>';
});
// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext' => $filetype['ext'],
        'type' => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4);
add_filter('upload_mimes', function ($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});
add_action('admin_head', function ()
{
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
    width: 100% !important;
    height: auto !important;
        }
        </style>';
});
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes, $real_mime = '')
{

    // WP 5.1 +
    if (version_compare($GLOBALS['wp_version'], '5.1.0', '>=')) {
        $dosvg = in_array($real_mime, ['image/svg', 'image/svg+xml']);
    } else {
        $dosvg = ('.svg' === strtolower(substr($filename, -4)));
    }

    // mime тип был обнулен, поправим его
    // а также проверим право пользователя
    if ($dosvg) {

        // разрешим
        if (current_user_can('manage_options')) {

            $data['ext'] = 'svg';
            $data['type'] = 'image/svg+xml';
        } // запретим
        else {
            $data['ext'] = false;
            $data['type'] = false;
        }

    }

    return $data;
}, 10, 5);

// AJAX загрузка постов
add_action('wp_ajax_loadmore', 'load_posts');
add_action('wp_ajax_nopriv_loadmore', 'load_posts');

add_filter('get_the_excerpt', 'trim_excerpt');

add_filter('excerpt_length', 'custom_excerpt_length', 999);

add_filter('manage_posts_columns', 'gt_posts_column_views');
add_action('manage_posts_custom_column', 'gt_posts_custom_column_views');

add_action('admin_bar_menu', 'customize_my_wp_admin_bar', 80);


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
    get_template_part('rss', 'mail-ru');
}


// amp page
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