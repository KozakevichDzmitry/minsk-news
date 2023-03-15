<?php

require_once(COMPONENTS_PATH . 'content-exist-markers.php');
require_once(COMPONENTS_PATH . "icons/video-content-icon.php");
require_once(SHORTCODES_PATH . "share-links.php");
const POSITION_LINE_LEFT = 'position-left';
const POSITION_LINE_RIGHT = 'position-right';
const TYPE_IMAGE_ONLY = 'image-only';
const TYPE_WITHOUT_IMAGE = 'without_images';
const TYPE_LINE = 'line';

function render_news_template_line($post_ID, $withImages = false, $reversed = false, $vertical = false, $withPermalink=true)
{
?>
	<?php
    $cat_link = home_url();
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->taxonomy;
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->slug;
    ?>

	<div class="news-template-line <?php echo $vertical ? 'vertical' : ''; ?>" data-postid="<?php echo $post_ID ?>" style="flex-direction: <?php echo $reversed ? 'row-reverse;' : 'row'; ?>">
		<?php if ($withImages) { ?><?php
            if ($withPermalink){ ?>
                <a href="<?php echo get_post_permalink($post_ID); ?>">
                    <?php echo get_the_post_thumbnail( $post_ID, 'post-thumbnails' );?>
                </a>
            <?php } else{ ?>
                <?php echo get_the_post_thumbnail( $post_ID, 'post-thumbnails' );?>
            <?php } ?>
        <?php } ?>
		<div class="post-container">
			<div class="post-info-container">
                <?php $exist_markers = render_content_exist_markers($post_ID); ?>
                <?php if($exist_markers): ?>
                    <div class="content-exist">
                        <?php  echo $exist_markers; ?>
                    </div>
                <?php endif;?>
				<div class="post-category">
                    <a href="<?php echo $cat_link; ?>" class="tags__link">
                        <span><?php echo get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->name;?></span>
                    </a>
                </div>
			</div>
			<div class="post-title">
                <?php if ($withPermalink){ ?>
				<a href="<?php echo get_post_permalink($post_ID); ?>">
					<?php echo get_the_title($post_ID); ?>
                </a>
                <?php }else {?>
                    <span><?php echo get_the_title($post_ID); ?></span>
                <?php }?>
			</div>
			<div class="bottom-info">
				<div class="bottom-info-container">
					<div class="time-info">
						<span><?php echo get_the_time('H:i', $post_ID); ?></span>
						<span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
					</div>
                    <?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>
                    <?php if ($is_advertising) : ?>
                    <div>
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

function render_new_template_image($post_ID)
{
?>
	<?php
    $cat_link = home_url();
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->taxonomy;
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->slug;
    ?>

	<div class="news-template-image">
        <?php echo get_the_post_thumbnail( $post_ID, 'post-thumbnails', array('class' => 'skip-lazy'));?>
		<div class="post-container">
			<div class="post-title">
				<a href="<?php echo get_post_permalink($post_ID); ?>">
					<span><?php echo get_the_title($post_ID); ?></span>
				</a>
			</div>
			<div class="post-info">
				<div class="post-info-container">
                    <?php $exist_markers = render_content_exist_markers($post_ID); ?>
                    <?php if($exist_markers): ?>
                        <div class="content-exist">
                            <?php  echo $exist_markers; ?>
                        </div>
                    <?php endif;?>
					<div class="post-category">
                        <a href="<?php echo $cat_link; ?>" class="tags__link">
							<span><?php echo get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->name;?></span>
                        </a>
                    </div>
				</div>
				<div class="post-info-bottom">
                <?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>
                <?php if ($is_advertising) : ?>
                    <div>
                        <?php render_advertising_icon('white', 1); ?>
                    </div>
                <?php endif; ?>
					<div class="time-info">
						<span><?php echo get_the_time('H:i', $post_ID); ?></span>
						<span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}

function render_new_template_video($post_ID, $is_future = false, $is_wrapper_class=true)
{
	$url = get_the_post_thumbnail_url($post_ID);
    $cat_link = home_url();
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->taxonomy;
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->slug;

?>
   <div class="<?php echo $is_wrapper_class? 'box': '' ?>" data-postid="<?php echo $post_ID ?>">
	    <div class="news-template-line vertical video">
		<?php $eternal_video = carbon_get_post_meta($post_ID, 'video_post_type_eternal_video'); ?>
		<?php $youtube_video = carbon_get_post_meta($post_ID, 'video_post_type_youtube-link'); ?>
		<?php if ($is_future == true || (empty($eternal_video[0]) && empty($youtube_video))) : ?>
			<div class="video-preview">
                <?php echo get_the_post_thumbnail( $post_ID, 'post-thumbnails' );?>
			</div>
		<?php else : ?>
			<div class="video-preview">
				<?php if (!empty($eternal_video[0]) && empty($youtube_video)) : ?>
					<?php do_shortcode('[eternal_video_scn attachment_id=' . $eternal_video[0] . ' poster=' .  $url . ']'); ?>
				<?php elseif (empty($eternal_video[0]) && !empty($youtube_video)) : ?>
					<?php echo $youtube_video; ?>
				<?php elseif (!empty($eternal_video[0]) && !empty($youtube_video)) : ?>
					<?php echo $youtube_video; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="post-container" style="width: <?php echo empty($img_url) ? '100%;' : 'auto'; ?> ">
            <div class="post-containe-inner">
                <div class="post-info-container">
                    <div class="content-exist">
                        <?php echo render_video_content_icon();?>
                    </div>
                    <div class="post-category">
                        <a href="<?php echo $cat_link; ?>" class="tags__link">
                        <span><?php echo get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->name;?></span>
                        </a>
                    </div>
                </div>
                <div class="post-excerpt">
                    <a href="<?php echo get_post_permalink($post_ID); ?>">
                        <?php echo wp_strip_all_tags(get_post_field('post_title', $post_ID)); ?>
                    </a>
                </div>
            </div>
            <div class="post-bottom-inner">
                    <a href="<?php echo get_post_permalink($post_ID); ?>" class="read-all-link">
                        <span class="read-more">Читать все</span>
                    </a>
                <div class="bottom-info">
                    <div class="bottom-info-container">
                        <div class="time-info">
                            <span><?php echo get_the_time('H:i', $post_ID); ?></span>
                            <span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
                        </div>
                        <?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>
                        <?php if ($is_advertising) : ?>
                        <div>
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
	</div>
    </div>
<?php
}
