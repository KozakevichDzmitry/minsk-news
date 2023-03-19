<?php

require_once(COMPONENTS_PATH . "icons/advertising-icon.php");
require_once(COMPONENTS_PATH . "icons/marker-icon.php");
require_once(COMPONENTS_PATH . "icons/location-icon.php");
require_once(COMPONENTS_PATH . "icons/camera-icon.php");
require_once(COMPONENTS_PATH . "icons/video-content-icon.php");

require_once(COMPONENTS_PATH . 'content-exist-markers.php');

function render_line_regular_news($post_ID)
{
    $taxonomies = get_my_taxonomies($post_ID);
    if(!empty($taxonomies)){
        $primary_category = get_post_primary_category($post_ID, $taxonomies)['primary_category'];
        $cat_link = home_url();
        $cat_link .= '/';
        $cat_link .= $primary_category->taxonomy;
        $cat_link .= '/';
        $cat_link .= $primary_category->slug;
    }
    ?>
    <div class="line-regular-news">
        <?php $img_url = get_the_post_thumbnail_url($post_ID, 'full'); ?>

        <?php if (!empty($img_url)) : ?>
            <a class="image" href="<?php echo esc_url(get_permalink($post_ID)); ?>">
                <img src="<?php echo $img_url; ?>"
                     alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?>"/>
            </a>
        <?php endif; ?>
        <div class="content">
            <div class="content-header">
                <?php if(isset($cat_link)): ?>
                    <a href="<?php echo $cat_link; ?>" class="tags__link">
                        <?php $exist_markers = render_content_exist_markers($post_ID); ?>
                        <?php if ($exist_markers): ?>
                            <div class="content-exist">
                                <?php echo $exist_markers; ?>
                            </div>
                        <?php endif; ?>
                        <span class="news-cat">
                        <?php echo $primary_category->name; ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
            <div class="content-container">
                <a class="content__description" href="<?php echo esc_url(get_permalink($post_ID)); ?>">
                    <?php echo get_the_title($post_ID); ?>
                </a>
            </div>
            <div class="info">
                <div class="bottom-info">
                    <div class="info__time">
                        <span><?php echo get_the_time('H:i', $post_ID); ?></span>
                        <span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
                    </div>
                    <?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>
                    <?php if ($is_advertising) : ?>
                        <div class="advertising-marker">
                            <?php render_advertising_icon(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="share-block--fold">
                    <?php echo share_links($post_ID); ?>
                    <?php render_share_icon(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
