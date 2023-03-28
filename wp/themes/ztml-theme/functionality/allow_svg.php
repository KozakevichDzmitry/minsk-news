<?php
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