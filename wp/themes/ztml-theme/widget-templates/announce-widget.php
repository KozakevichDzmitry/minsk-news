<?php

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class AnnounceWidget extends Widget
{
    function __construct()
    {
        $this->setup('wp_news_announce_widget', 'Announce Widget', 'Displays a block with news', array(
            Field::make('text', 'wp_news_announce_widget_title', 'Заголовок'),
            Field::make('text', 'wp_news_announce_widget_post_id', 'ID поста через запятую')
        ));
    }

    function front_end($args, $instance)
    {
        $strIDS = preg_replace('/\s+/', '', $instance['wp_news_announce_widget_post_id']);
        echo $args['before_title'] . $instance['wp_news_announce_widget_title'] . $args['after_title'];
        echo '<div class="box box-list no-lines">';
        $ids = explode(',', $strIDS);
        foreach ($ids as $id) {
            $status = get_post_status($id);
            $img_url = get_the_post_thumbnail_url($id, array(270, 180));
            $taxonomies = get_my_taxonomies($id);
            if (!empty($taxonomies)) {
                $primary_category = get_post_primary_category($id, $taxonomies);
                if(!empty($primary_category['primary_category'])){
                    $primary_category = $primary_category['primary_category'];
                    $cat_link = home_url();
                    $cat_link .= '/';
                    $cat_link .= $primary_category->taxonomy;
                    $cat_link .= '/';
                    $cat_link .= $primary_category->slug;
                }
            }
            if ('publish' === $status) render_new_template_video($id, false, false);
            else if ('future' === $status) { ?>

                <div class="news-template-line vertical announce" data-postid="<?php echo $id; ?>"
                     data-publication="<?php echo get_the_time('c', $id); ?>">
                    <img src="<?php echo $img_url; ?>"
                         alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?>"/>
                    <div class="post-container">
                        <div class="post-info-container">
                            <?php $exist_markers = render_content_exist_markers($id); ?>
                            <?php if ($exist_markers): ?>
                                <div class="content-exist">
                                    <?php echo $exist_markers; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($cat_link)): ?>
                                <div class="post-category">
                                    <a href="<?php echo $cat_link; ?>" class="tags__link">
                                        <span><?php echo $primary_category->name; ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="post-title"><?php echo carbon_get_post_meta($id, 'video_post_type_announce_label'); ?></div>
                        <div class="bottom-info">
                            <div class="bottom-info-container">
                                <div class="time-info">
                                    <span><?php echo get_the_time('H:i', $id); ?></span>
                                    <span><?php echo get_the_time('d.m.Y', $id); ?></span>
                                </div>
                                <?php $is_advertising = carbon_get_post_meta($id, 'news_is_advertising'); ?>
                                <?php if ($is_advertising) : ?>
                                    <div>
                                        <?php render_advertising_icon(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="post-bottom-inner">
                                <a href="<?php echo get_home_url(); ?>/smotrite/" class="read-all-link">
                                    <span class="read-more">Читать все</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        }
        echo '</div>';
    }
}

add_action('widgets_init', function () {
    register_widget('AnnounceWidget');
});

