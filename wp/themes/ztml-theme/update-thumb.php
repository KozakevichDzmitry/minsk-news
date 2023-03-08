<?php

wp_reset_postdata(); // сбрасываем переменную $post
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

add_action('wp_ajax_upTmbn', 'upTmbn');
add_action('wp_ajax_nopriv_upTmbn', 'upTmbn');

function catch_that_image()
{
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];
    return $first_img;
}

function upTmbn($fn_args = array('load' => 10, 'offset' => 0,)){
    $arg = [
        'post_type' => 'news',
        'offset' => $_POST['offset'],
        'date_query' => [
            [
                'after' => 'October 1st, 2022',
                'before' => [
                    'year' => 2022,
                    'month' => 10,
                    'day' => 31,
                ],
                'inclusive' => true,
            ],
        ],
        'posts_per_page' => $_POST['load'],
    ];
    $query = new WP_Query($arg);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $desc = "image description";
            if(catch_that_image()) {
                $image = media_sideload_image(catch_that_image(), $post_id, $desc, 'id');
                set_post_thumbnail($post_id, $image);
                echo $image;
            }
        }

        wp_reset_postdata(); // сбрасываем переменную $post
    } else echo 'END';
    die;

}

//<button id="qwe" style="margin: 200px">click</button>
//
//
//<script>
//jQuery(document).ready(function ($) {
//    document.querySelector('#qwe').onclick = go
//        let data = {
//        action: "upTmbn",
//            date: null,
//            load: 5,
//            offset: 0,
//        }
//
//        function
//        go() {
//            $.ajax({
//                url: "/wp-admin/admin-ajax.php",
//                data: data,
//                type: "POST",
//                success: function (res) {
//                if (res == 'END') {
//                    console.log('END')
//                    }else {
//                    data.offset += data.load
//                        console.log(data.offset)
//                        console.log(res)
//                        go()
//                    }
//            },
//                error: function( req, status, err ) {
//                console.log( 'что-то пошло не так', status, err );
//                go()
//                }
//            });
//
//        }
//    })
//
//
//</script>


