<?php

/* ----------------------------------------------------------------------------
 * TagDiv gallery - tinyMCE hooks
 */


add_filter('post_gallery', 'td_gallery_shortcode', 10, 4);
/**
 * @param string $output - is empty !!!
 * @param $atts
 * @param bool $content
 * @return mixed
 */

function gallery_enqueue_scripts()
{
    wp_deregister_script ('swiper');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper.css');
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assembly/src/libs/swiper/swiper.js', array('jquery'), '8.4.6', true);
    wp_enqueue_style('lightbox', get_template_directory_uri() . '/assembly/src/libs/lightbox/css/lightbox.min.css');
    wp_enqueue_script('lightbox', get_template_directory_uri() . '/assembly/src/libs/lightbox/js/lightbox.min.js', array('jquery'), null, true);
    wp_enqueue_style('mn-gallery', get_template_directory_uri() . '/gallery/gallery.css');
}

function get_srcset_sizes($thumb_id, $thumb_type, $thumb_width, $thumb_url)
{
    $return_buffer = '';
    //backwards compatibility - check if wp_get_attachment_image_srcset is defined, it was introduced only in WP 4.4
    if (function_exists('wp_get_attachment_image_srcset')) {
        //retina srcset and sizes
        if (!empty($thumb_width)) {
            $thumb_w = ' ' . $thumb_width . 'w';
            $retina_thumb_width = $thumb_width * 2;
            $retina_thumb_w = ' ' . $retina_thumb_width . 'w';
            //retrieve retina thumb url
            $retina_url = wp_get_attachment_image_src($thumb_id, $thumb_type . '_retina');
            //srcset and sizes
            if ($retina_url !== false) {
                $return_buffer .= ' srcset="' . esc_url($thumb_url) . $thumb_w . ', ' . esc_url($retina_url[0]) . $retina_thumb_w . '" sizes="(-webkit-min-device-pixel-ratio: 2) ' . $retina_thumb_width . 'px, (min-resolution: 192dpi) ' . $retina_thumb_width . 'px, ' . $thumb_width . 'px"';
            }

            //responsive srcset and sizes
        } else {
            $thumb_srcset = wp_get_attachment_image_srcset($thumb_id, $thumb_type);
            $thumb_sizes = wp_get_attachment_image_sizes($thumb_id, $thumb_type);
            if ($thumb_srcset !== false && $thumb_sizes !== false) {
                $return_buffer .= ' srcset="' . $thumb_srcset . '" sizes="' . $thumb_sizes . '"';
            }
        }
    }

    return $return_buffer;
}

function attachment_get_src($attachment_id, $thumbType = 'full')
{
    $image_src_array = wp_get_attachment_image_src($attachment_id, $thumbType);
    $buffy = array();

    //init the variable returned from wp_get_attachment_image_src
    if (empty($image_src_array[0])) {
        $buffy['src'] = '';
    } else {
        $buffy['src'] = $image_src_array[0];
    }

    if (empty($image_src_array[1])) {
        $buffy['width'] = '';
    } else {
        $buffy['width'] = $image_src_array[1];
    }


    if (empty($image_src_array[2])) {
        $buffy['height'] = '';
    } else {
        $buffy['height'] = $image_src_array[2];
    }

    return $buffy;
}

function attachment_get_full_info($attachment_id, $thumbType = 'full')
{
    $attachment = get_post($attachment_id);

    // make sure that we get a post
    if (is_null($attachment)) {
        return array(
            'alt' => '',
            'caption' => '',
            'description' => '',
            'href' => '',
            'src' => '',
            'title' => '',
            'width' => '',
            'height' => ''
        );
    }

    $image_src_array = attachment_get_src($attachment_id, $thumbType);

    return array(
        'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => esc_url(get_permalink($attachment->ID)),
        'src' => $image_src_array['src'],
        'title' => $attachment->post_title,
        'width' => $image_src_array['width'],
        'height' => $image_src_array['height']
    );
}

function td_gallery_shortcode($output = '', $atts, $content = false)
{
    $buffy = '';
    //check for gallery  = slide
    if (!empty($atts) and !empty($atts['td_select_gallery_slide']) and $atts['td_select_gallery_slide'] == 'slide') {

        $nr_title_chars = 95;

        $title_slide = '';
        //check for the title
        if (!empty($atts['td_gallery_title_input'])) {
            $title_slide = $atts['td_gallery_title_input'];
            //check how many chars the tile have, if more then 84 then that cut it and add ... after
            if (mb_strlen($title_slide, 'UTF-8') > $nr_title_chars) {
                $title_slide = mb_substr($title_slide, 0, $nr_title_chars, 'UTF-8') . '...';
            }
        }

        $slide_display_html = '';
        $slide_thumb_html = '';

        $image_ids = explode(',', $atts['ids']);

        //check to make sure we have images
        if (count($image_ids) == 1 and !is_numeric($image_ids[0])) return;

        $image_ids = array_map('trim', $image_ids);

        $gallery_slider_unique_id = uniqid();

        $cur_item_nr = 1;
        foreach ($image_ids as $image_id) {
            $image_attachment = attachment_get_full_info($image_id);
            $td_temp_image_url_full = $image_attachment['src'];
            $image_type = 'td_0x420';
            $image_width = '420';
            $td_temp_image_url = wp_get_attachment_image_src($image_id, $image_type);       //0x420 image sizes - for big slide

            if (!empty($td_temp_image_url[0]) and !empty($td_temp_image_url_full)) {

                //retina image
                $srcset_sizes = 'data-' . trim(get_srcset_sizes($image_id, $image_type, $image_width, $td_temp_image_url[0]));

                $class_post_content = '';

                if (!empty($image_attachment['description']) or !empty($image_attachment['caption'])) {
                    $class_post_content = 'gl-slide-content';
                }

                //if picture has caption & description
                $figcaption = '';

                if (!empty($image_attachment['caption']) or !empty($image_attachment['description'])) {
                    $figcaption = '<figcaption class = "gl-slide-caption ' . $class_post_content . '">';
                    if (!empty($image_attachment['caption'])) {
                        $figcaption .= '<div class = "gl-slide-copywrite">' . $image_attachment['caption'] . '</div>';
                    }
                    if (!empty($image_attachment['description'])) {
                        $description = mb_substr($image_attachment['description'], 0, 95, 'UTF-8') . '...';
                        $figcaption .= '<span class = "gl-slide-description">' . $description . '</span>';
                    }
                    $figcaption .= '</figcaption>';
                }
                $img_alt = htmlentities($image_attachment['alt'], ENT_QUOTES);
                $img_description = htmlentities($image_attachment['description'], ENT_QUOTES);
                $default_img_src = get_template_directory_uri() . '/gallery/lazy-load.jpg';
                $slide_display_html .= "
                        <div class='gl-swiper-slide gl-swiper-slide-$gallery_slider_unique_id'>
                            <div class='gl-slider__image'>
                              <figure>
                                    <a class='gl-slider__link' 
                                    data-lightbox='$gallery_slider_unique_id' 
                                    href='$td_temp_image_url_full'
                                    title={$image_attachment['title']}
                                    data-title='$img_description'
                                    >
                                       <img class='swiper-lazy' src='$default_img_src' data-src='$td_temp_image_url[0]' $srcset_sizes alt='$img_alt'>
                                       <div class='swiper-lazy-preloader'></div>
                                      $figcaption
                                    </a>
                                </figure>
                            </div>
                        </div>";

                $slide_thumb_html .= "
                        <div class='thumb-swiper-slide thumb-swiper-slide-$gallery_slider_unique_id'>
                            <div class='thumb-slider__image'>
                               <img class='swiper-lazy' src='$default_img_src' data-src='$td_temp_image_url[0]' $srcset_sizes alt='$img_alt'>
                               <div class='swiper-lazy-preloader'></div>
                            </div>
                        </div>";
                $cur_item_nr++;
            }
        }
        $script = "document.addEventListener('DOMContentLoaded', () => {
                                const sliderThumbs = new Swiper('#thumb_$gallery_slider_unique_id', {
                                    speed: 400,
                                    slidesPerView: 2,
                                    spaceBetween: 20,
                                    wrapperClass: 'thumb-swiper-wrapper-$gallery_slider_unique_id',
                                    slideClass: 'thumb-swiper-slide-$gallery_slider_unique_id',
                                    grabCursor: true,
                                    preloadImages: false,
                                    lazy: {
                                        loadPrevNext: true,
                                    },
                                    navigation: {
                                        nextEl: '.button-next-$gallery_slider_unique_id',
                                        prevEl: '.button-prev-$gallery_slider_unique_id',
                                    },
                                     breakpoints: {
                                        580: {
                                          slidesPerView: 4,
                                          spaceBetween: 10
                                        },
                                    }, 
                                    breakpoints: {
                                        420: {
                                          slidesPerView: 3,
                                          spaceBetween: 10
                                        },
                                    },
                                   
                                    freeMode: true, // при перетаскивании превью ведет себя как при скролле
                                });
                                const swiper = new Swiper('#gl_$gallery_slider_unique_id', {
                                    speed: 800,
                                    spaceBetween: 24,
                                    slidesPerView: 1,
                                    wrapperClass: 'gl-swiper-wrapper-$gallery_slider_unique_id',
                                    slideClass: 'gl-swiper-slide-$gallery_slider_unique_id',
                                    grabCursor: true,
                                    preloadImages: false,
                                    lazy: {
                                        loadPrevNext: true,
                                    },
                                    mousewheel: {
                                        sensitivity: 3,
                                        eventsTarget: '.gl-swiper-slide-$gallery_slider_unique_id'
                                    },
                                    thumbs: {
                                        swiper: sliderThumbs
                                    },
                                });
                                swiper.updateAutoHeight(800)
                    })";
        if (!empty($title_slide)) {
            $buffy .= "<h3>$title_slide</h3>";
        }

        if (!empty($slide_display_html)) {
            $buffy .= "<div class='gl-slider' id='$gallery_slider_unique_id'>
                        <div class='gl-swiper'  id='gl_$gallery_slider_unique_id'>
                            <div class='gl-swiper-wrapper gl-swiper-wrapper-$gallery_slider_unique_id'>
                                $slide_display_html
                            </div>
                        </div>
                        <div class='thumb-swiper' id='thumb_$gallery_slider_unique_id'>
                            <div class='thumb-swiper-wrapper thumb-swiper-wrapper-$gallery_slider_unique_id'>
                                $slide_thumb_html
                            </div>
                            <div class='thumb-swiper-button-prev button-prev-$gallery_slider_unique_id'></div>
                            <div class='thumb-swiper-button-next button-next-$gallery_slider_unique_id'></div>
                        </div>
                      </div>";

            gallery_enqueue_scripts();
            add_action( 'wp_footer',function () use ($script) {
                echo '<script>'.$script.'</script>';
            }, 999 );

        }//end check if we have html code for the slider
    }//end if slide

    //!!!!!! WARNING  : $return has to be != empty to overwride the default output
    return $buffy;
}


add_action('print_media_templates', 'td_custom_gallery_settings_hook');
add_action('print_media_templates', 'td_change_backbone_js_hook');
/**
 * custom gallery setting
 */
function td_custom_gallery_settings_hook()
{
    // define your backbone template;
    // the "tmpl-" prefix is required,
    // and your input field should have a data-setting attribute
    // matching the shortcode name
    ?>
    <script type="text/html" id="tmpl-td-custom-gallery-setting">
        <label class="setting">
            <span>Gallery Type</span>
            <select data-setting="td_select_gallery_slide">
                <option value="">Default</option>
                <option value="slide">TagDiv Slide Gallery</option>
            </select>
        </label>

        <label class="setting">
            <span>Gallery Title</span>
            <input type="text" value="" data-setting="td_gallery_title_input"/>
        </label>
    </script>

    <script>

        jQuery(document).ready(function () {

            // add your shortcode attribute and its default value to the
            // gallery settings list; $.extend should work as well...
            _.extend(wp.media.gallery.defaults, {
                td_select_gallery_slide: '', td_gallery_title_input: ''
            });
            // merge default gallery settings template with yours
            wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
                template: function (view) {
                    return wp.media.template('gallery-settings')(view)
                        + wp.media.template('td-custom-gallery-setting')(view);
                }
//	            ,initialize: function() {
//		            if (typeof this.model.get('td_select_gallery_slide') == 'undefined') {
//			            this.model.set({td_select_gallery_slide: 'slide'});
//		            }
//	            }
            });
            // wp.media.model.Attachments.trigger('change')
        });

    </script>
    <?php
}

/**
 * td-modal-image support in tinymce
 */
function td_change_backbone_js_hook()
{
    //change the backbone js template


    // make the buffer for the dropdown
    $image_styles_buffer_for_select = '';
    $image_styles_buffer_for_switch = '';


//    foreach (td_global::$tiny_mce_image_style_list as $tiny_mce_image_style_id => $tiny_mce_image_style_params) {
//        $image_styles_buffer_for_select .= "'<option value=\"" . $tiny_mce_image_style_id . "\">" . $tiny_mce_image_style_params['text'] . "</option>' + ";
//        $image_styles_buffer_for_switch .= "
//        case '$tiny_mce_image_style_id':
//            td_clear_all_classes(); //except the modal one
//            td_add_image_css_class('" . $tiny_mce_image_style_params['class'] . "');
//            break;
//        ";
//    }


    ?>
    <script type="text/javascript">

        (function () {

            var td_template_content = jQuery('#tmpl-image-details').text();

            var td_our_content = '' +
                '<div class="setting">' +
                '<span>Modal image</span>' +
                '<div class="button-large button-group" >' +
                '<button class="button active td-modal-image-off" value="left">Off</button>' +
                '<button class="button td-modal-image-on" value="left">On</button>' +
                '</div><!-- /setting -->' +
                '<div class="setting">' +
                '<span>tagDiv image style</span>' +
                '<select class="size td-wp-image-style">' +
                '<option value="">Default</option>' +
                <?php echo $image_styles_buffer_for_select ?>
                '</select>' +
                '</div>' +
                '</div>';

            //inject our settings in the template - before <div class="setting align">
            td_template_content = td_template_content.replace('<div class="setting align">', td_our_content + '<div class="setting align">');

            //save the template
            jQuery('#tmpl-image-details').html(td_template_content);
            if(jQuery(".td-modal-image-on").length){
                //modal off - click event
                jQuery(".td-modal-image-on").live("click", function () {
                    if (jQuery(this).hasClass('active')) {
                        return;
                    }
                    td_add_image_css_class('td-modal-image');

                    jQuery(".td-modal-image-off").removeClass('active');
                    jQuery(".td-modal-image-on").addClass('active');
                });

                //modal on - click event
                jQuery(".td-modal-image-off").live("click", function () {
                    if (jQuery(this).hasClass('active')) {
                        return;
                    }

                    td_remove_image_css_class('td-modal-image');

                    jQuery(".td-modal-image-off").addClass('active');
                    jQuery(".td-modal-image-on").removeClass('active');
                });

                // select change event
                jQuery(".td-wp-image-style").live("change", function () {
                    switch (jQuery(".td-wp-image-style").val()) {

                    <?php echo $image_styles_buffer_for_switch; ?>

                        default:
                            td_clear_all_classes(); //except the modal one
                            jQuery('*[data-setting="extraClasses"]').change(); //trigger the change event for backbonejs
                    }
                });

                //util functions to edit the image details in wp-admin
                function td_add_image_css_class(new_class) {
                    var td_extra_classes_value = jQuery('*[data-setting="extraClasses"]').val();
                    jQuery('*[data-setting="extraClasses"]').val(td_extra_classes_value + ' ' + new_class);
                    jQuery('*[data-setting="extraClasses"]').change(); //trigger the change event for backbonejs
                }

                function td_remove_image_css_class(new_class) {
                    var td_extra_classes_value = jQuery('*[data-setting="extraClasses"]').val();

                    //try first with a space before the class
                    var td_regex = new RegExp(" " + new_class, "g");
                    td_extra_classes_value = td_extra_classes_value.replace(td_regex, '');

                    var td_regex = new RegExp(new_class, "g");
                    td_extra_classes_value = td_extra_classes_value.replace(td_regex, '');

                    jQuery('*[data-setting="extraClasses"]').val(td_extra_classes_value);
                    jQuery('*[data-setting="extraClasses"]').change(); //trigger the change event for backbonejs
                }

                //clears all classes except the modal image one
                function td_clear_all_classes() {
                    var td_extra_classes_value = jQuery('*[data-setting="extraClasses"]').val();
                    if (td_extra_classes_value.indexOf('td-modal-image') > -1) {
                        //we have the modal image one - keep it, remove the others
                        jQuery('*[data-setting="extraClasses"]').val('td-modal-image');
                    } else {
                        jQuery('*[data-setting="extraClasses"]').val('');
                    }
                }

                //monitor the backbone template for the current status of the picture
                setInterval(function () {
                    var td_extra_classes_value = jQuery('*[data-setting="extraClasses"]').val();
                    if (typeof td_extra_classes_value !== 'undefined' && td_extra_classes_value != '') {
                        // if we have modal on, switch the toggle
                        if (td_extra_classes_value.indexOf('td-modal-image') > -1) {
                            jQuery(".td-modal-image-off").removeClass('active');
                            jQuery(".td-modal-image-on").addClass('active');
                        }

                        <?php

                        //                    foreach (td_global::$tiny_mce_image_style_list as $tiny_mce_image_style_id => $tiny_mce_image_style_params) {
                        //                    ?>
//                    //change the select
//                    if (td_extra_classes_value.indexOf('<?php //echo $tiny_mce_image_style_params['class'] ?>//') > -1) {
//                        jQuery(".td-wp-image-style").val('<?php //echo $tiny_mce_image_style_id ?>//');
//                    }
//                    <?php
                        //                    }

                        ?>

                    }
                }, 1000);
            }

        })(); //end anon function
    </script>
    <?php
}

/* ----------------------------------------------------------------------------
 * TagDiv gallery - front end hooks
 */