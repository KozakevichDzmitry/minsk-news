<?php

// Все работает?
require_once(__DIR__ . '/vendor/autoload.php');

//use ZMQContext as ZMQC;

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

require_once(COMPONENTS_PATH . "pdf-attachments.php");
require_once(COMPONENTS_PATH . 'satms-list-tem.php');
require_once(COMPONENTS_PATH . 'cae-list-item.php');
require_once(COMPONENTS_PATH . 'line-news-list-item.php');

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
require_once(REQUEST_HANDLERS . 'taxonomy-videos-posts.php');
require_once(REQUEST_HANDLERS . 'ethers-posts.php');
require_once(REQUEST_HANDLERS . 'announce.php');

require_once(LIBS_PATH . 'diff-image/dif-image.php');

require_once(SHORTCODES_PATH . 'extrenal-radio-player.php');
require_once(SHORTCODES_PATH . 'eternal-video.php');
require_once(SHORTCODES_PATH . 'subscribe-form.php');
require_once(SHORTCODES_PATH . 'share-links.php');
require_once(SHORTCODES_PATH . 'top-three-minsk.php');
require_once(SHORTCODES_PATH . 'speaks-and-shows.php');
function crb_register_custom_fieldss()
{
    require_once(WIDGETS_PATH . 'news-widget.php');
    require_once(WIDGETS_PATH . 'mery-widget.php');
    require_once(WIDGETS_PATH . 'news-video-widget.php');
    require_once(WIDGETS_PATH . 'announce-widget.php');
}

add_action('carbon_fields_register_fields', 'crb_register_custom_fieldss');

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

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '2.0');
}
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
        wp_enqueue_style('swiper-css', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper.css', null, null);
        wp_enqueue_script('swiper-old', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper-old.min.js', array('jquery'), null, true);
        wp_enqueue_script('home', get_template_directory_uri() . '/assets/js/home.min.js', array('jquery', 'jquery-ui', 'swiper-old', 'calendar'), _S_VERSION, true);
        wp_enqueue_script('autoban-lib', 'https://cdnjs.cloudflare.com/ajax/libs/autobahn/20.9.2/autobahn.min.js', null, null, true);
        wp_enqueue_script('sockets', get_template_directory_uri() . '/assets/js/sockets.min.js', array('jquery', 'autoban-lib'), _S_VERSION, true);
    } else {
        if ($template === 'about.php') {
            wp_enqueue_script('countUp', get_template_directory_uri() . '/assembly/src/libs/countup/countUp.min.js', array('jquery'), _S_VERSION, true);
            wp_enqueue_script('about-page', get_template_directory_uri() . '/assets/js/pages/about.min.js', array('jquery', 'countUp'), _S_VERSION, true);
        } elseif ($template == 'all-news.php') {
            calendar_register();
            slick_register();
            wp_enqueue_script('all-news', get_template_directory_uri() . '/assets/js/all-news.min.js', array('jquery', 'slick-min'), _S_VERSION, true);
        } elseif ($template == 'all-videos.php') {
            calendar_register();
            wp_enqueue_script('all-videos', get_template_directory_uri() . '/assets/js/all-videos.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'appeal.php') {
            wp_enqueue_script('appeal-page', get_template_directory_uri() . '/assets/js/appeal.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'ask-a-question.php') {
            wp_enqueue_script('main-external', get_template_directory_uri() . '/assets/js/components/eternal-video.min.js', array('jquery'), _S_VERSION, true);
            wp_enqueue_script('aaq', get_template_directory_uri() . '/assets/js/aaq.min.js', array('jquery'), _S_VERSION, true);
            slick_register();
        } elseif ($template == 'author.php') {
            calendar_register();
            wp_enqueue_script('author-page', get_template_directory_uri() . '/assets/js/author.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'authors-column.php') {
            calendar_register();
            wp_enqueue_script('authors-column', get_template_directory_uri() . '/assets/js/authors-column.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'cae.php') {
            calendar_register();
            wp_enqueue_script('cae', get_template_directory_uri() . '/assets/js/cae.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'events.php') {
            slick_register();
            wp_enqueue_script('events.js', get_template_directory_uri() . '/assets/js/events.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'management.php') {
            wp_enqueue_script('management', get_template_directory_uri() . '/assets/js/management.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'page-advertisement.php') {
            wp_enqueue_script('advertisement', get_template_directory_uri() . '/assets/js/advertisement.min.js', array('jquery'), _S_VERSION, true);
        } elseif ($template == 'radio-minsk.php') {
            slick_register();
            wp_enqueue_script('radio-minsk-page', get_template_directory_uri() . '/assets/js/radio-minsk.min.js', array('jquery', 'slick-min'), _S_VERSION, true);
        } elseif ($template == 'satms.php') {
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

add_action('wp_enqueue_scripts', 'page_scripts');

add_action('admin_head', 'my_custom_styles');
function my_custom_styles()
{
    echo '<style>
    .cf-container__tabs-item--current {
  border-bottom-color: #dc1d1d!important;
}

  </style>';
}

function swiper_register()
{
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper.css');
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper.js', array('jquery'));
}

function jquery_sticky_register()
{
    wp_enqueue_script('jquery-sticky', get_template_directory_uri() . '/assembly/src/libs/jquery-sticky/jquery-sticky.js', array('jquery'));
}

function sticky_sidebar_register()
{
    wp_enqueue_script('sticky-sidebar', get_template_directory_uri() . '/assembly/src/libs/sticky-sidebar/sticky-sidebar.min.js', array('jquery'), null, true);
    wp_enqueue_script('sidebar', get_template_directory_uri() . '/assets/js/sidebar.min.js', array('jquery, sticky-sidebar'),  _S_VERSION, true);
}

function diff_image_register()
{
    wp_register_style('diff-image-css', get_template_directory_uri() . '/assembly/src/libs/diff-image/dif-image.css');
    wp_register_script('diff-image', get_template_directory_uri() . '/assembly/src/libs/diff-image/dif-image.js', array('jquery'));

    wp_enqueue_style('diff-image-css');
    wp_enqueue_script('diff-image');
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

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

function fix_svg()
{
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}

add_action('admin_head', 'fix_svg');

add_filter('wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5);

# Исправление MIME типа для SVG файлов.
function fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime = '')
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
}


// AJAX загрузка постов
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

add_action('wp_ajax_loadmore', 'load_posts');
add_action('wp_ajax_nopriv_loadmore', 'load_posts');

require_once(__DIR__ . "/tv-parser.php");
function delete_files($path)
{
    $files = glob($path); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file)) {
            unlink($file); // delete file
        }
    }
}

function save_post_action($id, $post)
{
    if (get_page_template_slug($post) === 'tv-programme.php') {

        $zip_url = get_attached_file(carbon_get_post_meta($id, "crb_tv_programms"));
        $dir_tmp = get_template_directory() . '/tmp/*';
        $dir_output = get_template_directory() . '/output/*';
        delete_files($dir_tmp);
        delete_files($dir_output);

        if (strlen($zip_url)) {
            parse_tv_programm_file($zip_url);
        }
    }
}

add_action('post_updated', 'save_post_action', 10, 3);


add_shortcode('socials', 'social_shortcode');
function social_shortcode()
{
    $r = '<div class="social-icons">';
    foreach (carbon_get_the_post_meta('socials') as $item) :
        $r .= '<div class="social-icon__wparapper">';
        $r .= '<a href="' . $item['link'] . '"><img alt="' . get_post_meta($item['icon'], '_wp_attachment_image_alt', TRUE) . '" src="' . wp_get_attachment_url($item['icon']) . '" width="30"></a>';
        $r .= '</div>';
    endforeach;
    $r .= '</div>';
    return $r;
}

require_once(COMPONENTS_PATH . 'single-satm-slide.php');

function trim_excerpt($text)
{
    $text = str_replace('[&hellip;]', '...', $text);
    return $text;
}

add_filter('get_the_excerpt', 'trim_excerpt');

function custom_excerpt_length($length)
{
    return 15;
}

add_filter('excerpt_length', 'custom_excerpt_length', 999);

function iframe_scn($atts)
{
    $atts = shortcode_atts(array(
        'src' => 'https://www.youtube.com/watch?v=be6vDZj3-fs',
        'frameborder' => '0',
        'allowfullscreen' => 'allowfullscreen'
    ), $atts);

    return '<iframe title="YouTube video player" src="' . $atts['src'] . '" width="560" height="315" frameborder="' . $atts['frameborder'] . '" allowfullscreen="' . $atts['allowfullscreen'] . '"></iframe>';
}

add_shortcode("iframe", "iframe_scn");

function gt_get_post_view()
{
    $count = get_post_meta(get_the_ID(), 'post_views_count', true);
    return $count;
}

function gt_set_post_view()
{
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int)get_post_meta($post_id, $key, true);
    $count++;
    update_post_meta($post_id, $key, $count);
}

function gt_posts_column_views($columns)
{
    $columns['post_views'] = 'Views';
    return $columns;
}

function gt_posts_custom_column_views($column)
{
    if ($column === 'post_views') {
        echo gt_get_post_view();
    }
}

add_filter('manage_posts_columns', 'gt_posts_column_views');
add_action('manage_posts_custom_column', 'gt_posts_custom_column_views');

function get_attached_news($count, $term, $add_tax = NULL, $attached = false)
{
    $date_now = (new DateTime("now", new DateTimeZone('Europe/Minsk')))->format('Y-m-d H:i:s');

    $q_args = array(
        'post_type' => 'news',
        'posts_per_page' => $count,
        'no_found_rows' => true,
        'post_status' => 'publish',
        'orderby' => 'publish_date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'news-list',
                'field' => 'slug',
                'terms' => $term,
            ),
        ),
    );
    if ($attached) {
        $q_args['meta_query'] = array(
            array(
                'key' => 'news_is_attached',
                'value' => 'yes',
            ),
            array(
                'key' => '_news_is_attached_time_to',
                'value' => $date_now,
                'compare' => '>',
                'type' => 'DATETIME '
            ),
            array(
                'key' => '_news_is_attached_time_from',
                'value' => $date_now,
                'compare' => '<',
                'type' => 'DATETIME '
            ),
        );
        $q_args['date_query'] = array('after' => '1 months ago');
    }


    if ($add_tax != NULL) {
        $q_args['tax_query'] = array('relation' => 'AND', $add_tax, $q_args['tax_query'][0]);
    }

    $news_posts = new WP_Query($q_args);
    $exclude_list = array();

    foreach ($news_posts->posts as $post) {
        array_push($exclude_list, $post->ID);
    }

    $needs_posts_count = $count - count($news_posts->posts);

    if ($needs_posts_count > 0) {
        $adds_news_args = [
            'post_type' => 'news',
            'posts_per_page' => $needs_posts_count,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'news-list',
                    'terms' => $term,
                    'field' => 'slug',
                )
            ),
            'orderby' => 'date',
            'post__not_in' => $exclude_list,
        ];

        if ($add_tax != NULL) {
            $adds_news_args['tax_query'] = array(
                array(
                    'taxonomy' => 'news-list',
                    'terms' => $term,
                    'field' => 'slug',
                ),
                'relation' => 'AND',
                $add_tax
            );
        }

        $adds_news_quary = new WP_Query($adds_news_args);
        $news_posts->posts = array_merge($news_posts->posts, $adds_news_quary->posts);

        $add_posts_id_exclude = array();

        foreach ($adds_news_quary->posts as $post) {
            array_push($add_posts_id_exclude, $post->ID);
        }

        $exclude_list = array_merge($exclude_list, $add_posts_id_exclude);
    }

    return array(
        'posts' => $news_posts->posts,
        'ids' => $exclude_list
    );
}

function get_default_news($count, $term, $exclude_list, $add_tax = [])
{
    $q_args = array(
        'post_type' => 'news',
        'posts_per_page' => $count,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'news-list',
                'terms' => $term,
                'field' => 'slug',
            )
        ),
        'post__not_in' => $exclude_list,
    );
    if ($add_tax != NULL) {
        $q_args['tax_query'] = array('relation' => 'AND', $add_tax, $q_args['tax_query'][0]);
    }
    $news_posts = new WP_Query($q_args);

    return $news_posts->posts;
}

function get_my_taxonomies($post_ID)
{
    $post_type = get_post_type($post_ID);
    $taxonomies = get_object_taxonomies($post_type);
    if ($taxonomies) {
        if (in_array('news-list', $taxonomies)) $term = 'news-list';
        else $term = array_shift($taxonomies);
    }
    return $term;
}

function get_post_primary_category($post_id, $term = 'category', $return_all_categories = false)
{
    $return = array();

    if (class_exists('WPSEO_Primary_Term')) {
        // Show Primary category by Yoast if it is enabled & set
        $wpseo_primary_term = new WPSEO_Primary_Term($term, $post_id);
        $primary_term = get_term($wpseo_primary_term->get_primary_term());
        if (!is_wp_error($primary_term)) {
            $return['primary_category'] = $primary_term;
        }
    }
    if (empty($return['primary_category']) || $return_all_categories) {
        $categories_list = get_the_terms($post_id, $term);
        if (empty($return['primary_category']) && !empty($categories_list)) {
            $category = array('Общество', 'Городское хозяйство', 'Экономика', 'Спорт', 'Палитра дня', 'Культура', 'Происшествия', 'Новости мира', 'Наши проекты');
            foreach ($categories_list as $term) {
                if (in_array($term->name, $category)) $return['primary_category'] = $term;
            }
            if (empty($return['primary_category'])) $return['primary_category'] = $categories_list[0];  //get the first category
        }
        if ($return_all_categories) {
            $return['all_categories'] = array();

            if (!empty($categories_list)) {
                foreach ($categories_list as &$category) {
                    $return['all_categories'][] = $category->term_id;
                }
            }
        }
    }

    return $return;
}

add_action('admin_bar_menu', 'customize_my_wp_admin_bar', 80);
function customize_my_wp_admin_bar($wp_admin_bar)
{
    $new_content_node = $wp_admin_bar->get_node('new-content');
    $new_content_node->href = '/wp-admin/post-new.php?post_type=news';
    $wp_admin_bar->add_node($new_content_node);
}

function plus_and_zen_post($post_ID)
{
    $is_insert_code = carbon_get_post_meta($post_ID, 'rss_include_yandex_zen');

    if ($is_insert_code) {
        echo '<!-- Rating@Mail.ru counter -->
	<script type="text/javascript">
	var _tmr = window._tmr || (window._tmr = []);
	_tmr.push({id: "3077047", type: "pageView", start: (new Date()).getTime()});
	(function (d, w, id) {
		if (d.getElementById(id)) return;
		var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
		ts.src = "https://top-fwz1.mail.ru/js/code.js";
		var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
		if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
	})(document, window, "topmailru-code");
	</script><noscript><div>
	<img src="https://top-fwz1.mail.ru/counter?id=3077047;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
	</div></noscript>
	<!-- //Rating@Mail.ru counter -->';
    }
}

require_once(COMPONENTS_PATH . 'news-templates/main-news-template.php');
//add_action('save_post_news', 'update_front_news', 100, 2);
//function update_front_news($post_id)
//{
//
//    if (wp_is_post_revision($post_id) || get_post($post_id)->post_status != 'publish') return;
//
//    $terms = wp_get_post_terms($post_id, 'news-list', ['fields' => 'slugs']);
//
//    $users = carbon_get_post_meta(16, 'authors_column_sticked_authors');
//
//    $post_author = NULL;
//    $authorID = get_post_field('post_author');
//    foreach ($users as $user) {
//
//        if ($authorID == $user['id']) {
//            $post_author = $authorID;
//        }
//    }
//
//    $context = new ZMQC();
//    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
//    $socket->connect("tcp://127.0.0.1:5555");
//    $socket->send(json_encode([
//        'event' => 'news_block_update',
//        'post_id' => $post_id,
//        'update_blocks' => $terms,
//        'district_update_blocks' => wp_get_post_terms($post_id, 'news-district', ['fields' => 'slugs']),
//        'event_type' => get_post_type($post_id),
//        'author_id' => $post_author,
//    ]));
//}
//
//add_action('save_post_video', 'update_front_video', 100, 2);
//function update_front_video($post_id)
//{
//    if (wp_is_post_revision($post_id) || get_post($post_id)->post_status != 'publish') return;
//
//    $context = new ZMQC();
//    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
//    $socket->connect("tcp://127.0.0.1:5555");
//    $socket->send(json_encode([
//        'event' => 'video_block_update',
//        'post_id' => $post_id,
//        'event_type' => get_post($post_id)->post_type,
//        'carbon' => true
//    ]));
//
//}
//
//add_action('save_post_authors-column', 'update_front_authors_column', 100, 2);
//function update_front_authors_column($post_id)
//{
//    if (wp_is_post_revision($post_id) || get_post($post_id)->post_status != 'publish') return;
//
//    $users = carbon_get_post_meta(16, 'authors_column_sticked_authors');
//
//    $post_author = NULL;
//    foreach ($users as $user) {
//        if (get_post($post_id)->post_author == $user['id']) {
//            $post_author = $user['id'];
//        }
//    }
//
//    if ($post_author == NULL) return;
//
//    $context = new ZMQC();
//    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
//    $socket->connect("tcp://127.0.0.1:5555");
//    $socket->send(json_encode([
//        'event' => 'authors_column_update',
//        'author_id' => $post_author,
//        'post_id' => $post_id,
//        'carbon' => true
//    ]));
//
//}
//
//add_action('save_post_newspaper', 'update_front_newspaper', 100, 2);
//function update_front_newspaper($post_id)
//{
//    if (wp_is_post_revision($post_id) || get_post($post_id)->post_status != 'publish') return;
//
//    $context = new ZMQC();
//    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
//    $socket->connect("tcp://127.0.0.1:5555");
//    $socket->send(json_encode([
//        'event' => 'newspaper',
//        'post_id' => $post_id,
//        'event_type' => get_post($post_id)->post_type,
//        'carbon' => true
//    ]));
//}

/*
 * Виджет Активность
 */

function true_remove_activity_widget()
{
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
}

add_action('wp_dashboard_setup', 'true_remove_activity_widget');

/*
 * Регистрируем свой виджет
 */
function true_add_activity_widget()
{
    wp_add_dashboard_widget('dashboard_activity', 'Activity', 'true_site_activity'); // функция true_site_activity будет выводить содержимое виджета
}

add_action('wp_dashboard_setup', 'true_add_activity_widget');

function mn_dashboard_recent_posts($args)
{
    $query_args = array(
        'post_type' => $args['post_type'],
        'post_status' => $args['status'],
        'orderby' => 'date',
        'order' => $args['order'],
        'posts_per_page' => (int)$args['max'],
        'no_found_rows' => true,
        'cache_results' => false,
    );

    $posts = new WP_Query($query_args);

    if ($posts->have_posts()) {

        echo '<div id="' . $args['id'] . '" class="activity-block">';

        echo '<h3>' . $args['title'] . '</h3>';

        echo '<ul>';

        $today = current_time('Y-m-d');
        $tomorrow = current_datetime()->modify('+1 day')->format('Y-m-d');
        $year = current_time('Y');

        while ($posts->have_posts()) {
            $posts->the_post();

            $time = get_the_time('U');

            if (gmdate('Y-m-d', $time) === $today) {
                $relative = __('Today');
            } elseif (gmdate('Y-m-d', $time) === $tomorrow) {
                $relative = __('Tomorrow');
            } elseif (gmdate('Y', $time) !== $year) {
                /* translators: Date and time format for recent posts on the dashboard, from a different calendar year, see https://www.php.net/manual/datetime.format.php */
                $relative = date_i18n(__('M jS Y'), $time);
            } else {
                /* translators: Date and time format for recent posts on the dashboard, see https://www.php.net/manual/datetime.format.php */
                $relative = date_i18n(__('M jS'), $time);
            }

            // Use the post edit link for those who can edit, the permalink otherwise.
            $recent_post_link = current_user_can('edit_post', get_the_ID()) ? get_edit_post_link() : get_permalink();

            $draft_or_post_title = _draft_or_post_title();
            printf(
                '<li><span>%1$s</span> <a href="%2$s" aria-label="%3$s">%4$s</a></li>',
                /* translators: 1: Relative date, 2: Time. */
                sprintf(_x('%1$s, %2$s', 'dashboard'), $relative, get_the_time()),
                $recent_post_link,
                /* translators: %s: Post title. */
                esc_attr(sprintf(__('Edit &#8220;%s&#8221;'), $draft_or_post_title)),
                $draft_or_post_title
            );
        }

        echo '</ul>';
        echo '</div>';

    } else {
        return false;
    }

    wp_reset_postdata();

    return true;
}

/*
 * Содержимое нового виджета
 */

function true_site_activity()
{
    echo '<div id="activity-widget">';

    // посты, запланированные на публикацию (вы можете изменить их параметры отображения либо не отображать совсем)
    $query_args = array(
        'post_type' => 'any',
        'status' => 'future',
        'order' => 'ASC',
        'display' => 2,
        'max' => 10,
        'title' => __('Publishing Soon'),
        'id' => 'future-posts',
    );
    $future_posts = mn_dashboard_recent_posts($query_args);

    // недавно опубликованные посты
    $recent_posts = mn_dashboard_recent_posts(array(
        'display' => 2,
        'max' => 5,
        'post_type' => 'any',
        'status' => 'publish',
        'order' => 'DESC',
        'title' => __('Recently Published'),
        'id' => 'published-posts',
    ));

    // а вот и комментарии, в параметрах функции указываем количество выводимых комментов
    $recent_comments = wp_dashboard_recent_comments(3);

    // что следует отображать, если нет ни постов ни комментов
    if (!$future_posts && !$recent_posts && !$recent_comments) {
        echo '<div class="no-activity">';
        echo '<p class="smiley"></p>';
        echo '<p>' . __('No activity yet!') . '</p>';
        echo '</div>';
    }
    echo '</div>';
}


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