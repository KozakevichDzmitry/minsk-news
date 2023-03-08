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
    $img_url = get_the_post_thumbnail_url($post_ID, 'full');
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
                <img src="<?php echo $img_url; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?>" />
                </a>
            <?php } else{ ?>
                <img src="<?php echo $img_url; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?>" />
            <?php } ?>
        <?php } ?>
		<div class="post-container">
			<div class="post-info-container">
				<div class="content-exist">
					<?php render_content_exist_markers($post_ID); ?>
				</div>
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
					<div>
						<?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>

						<?php if ($is_advertising) : ?>
							<?php render_advertising_icon(); ?>
						<?php endif; ?>
					</div>
				</div>
				<div>
					<div class="share-block--fold">
						<?php echo share_links($post_ID); ?>
						<?php render_share_icon(); ?>
					</div>
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
    $img_url = get_the_post_thumbnail_url($post_ID, 'full');
    $cat_link = home_url();
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->taxonomy;
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->slug;
    ?>

	<div class="news-template-image">
		<img src="<?php echo $img_url; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?>" />
		<div class="post-container">
			<div class="post-title">
				<a href="<?php echo get_post_permalink($post_ID); ?>">
					<span><?php echo get_the_title($post_ID); ?></span>
				</a>
			</div>
			<div class="post-info">
				<div class="post-info-container">
					<div class="content-exist">
						<?php render_content_exist_markers($post_ID, true); ?>
					</div>
					<div class="post-category">
                        <a href="<?php echo $cat_link; ?>" class="tags__link">
							<span><?php echo get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->name;?></span>
                        </a>
                    </div>
				</div>
				<div class="post-info-bottom">
					<div>
						<?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>

						<?php if ($is_advertising) : ?>
							<?php render_advertising_icon('white', 1); ?>
						<?php endif; ?>
					</div>
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
		<?php $eternal_video = carbon_get_post_meta($post_ID, 'video_post_type_eternal_video')[0]; ?>
		<?php $youtube_video = carbon_get_post_meta($post_ID, 'video_post_type_youtube-link'); ?>
		<?php if ($is_future == true || (empty($eternal_video) && empty($youtube_video))) : ?>
			<div class="video-preview">
				<img src="<?php echo $url; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?>" />
			</div>
		<?php else : ?>
			<div class="video-preview">
				<?php if (!empty($eternal_video) && empty($youtube_video)) : ?>
					<?php do_shortcode('[eternal_video_scn attachment_id=' . $eternal_video . ' poster=' .  $url . ']'); ?>
				<?php elseif (empty($eternal_video) && !empty($youtube_video)) : ?>
					<?php echo $youtube_video; ?>
				<?php elseif (!empty($eternal_video) && !empty($youtube_video)) : ?>
					<?php echo $youtube_video; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="post-container" style="width: <?php echo empty($img_url) ? '100%;' : 'auto'; ?> ">
            <div class="post-containe-inner">
                <div class="post-info-container">
                    <div class="content-exist">
                        <?php render_video_content_icon();?>
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
                        <span>
						<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M3.77778 10.5C3.50164 10.5 3.27778 10.7239 3.27778 11C3.27778 11.2761 3.50164 11.5 3.77778 11.5V10.5ZM10.6667 11V11.5V11ZM11 10.6667H11.5H11ZM11 1.33333H11.5H11ZM1.33333 1V1.5V1ZM1 1.33333H0.5H1ZM0.5 8.22222C0.5 8.49836 0.723858 8.72222 1 8.72222C1.27614 8.72222 1.5 8.49836 1.5 8.22222H0.5ZM0.924224 10.3687C0.728962 10.5639 0.728962 10.8805 0.924224 11.0758C1.11949 11.271 1.43607 11.271 1.63133 11.0758L0.924224 10.3687ZM6 6H6.5C6.5 5.72386 6.27614 5.5 6 5.5V6ZM5.5 8.22222C5.5 8.49836 5.72386 8.72222 6 8.72222C6.27614 8.72222 6.5 8.49836 6.5 8.22222H5.5ZM3.77778 5.5C3.50164 5.5 3.27778 5.72386 3.27778 6C3.27778 6.27614 3.50164 6.5 3.77778 6.5V5.5ZM3.77778 11.5H10.6667V10.5H3.77778V11.5ZM10.6667 11.5C10.8877 11.5 11.0996 11.4122 11.2559 11.2559L10.5488 10.5488C10.5801 10.5176 10.6225 10.5 10.6667 10.5V11.5ZM11.2559 11.2559C11.4122 11.0996 11.5 10.8877 11.5 10.6667H10.5C10.5 10.6225 10.5176 10.5801 10.5488 10.5488L11.2559 11.2559ZM11.5 10.6667V1.33333H10.5V10.6667H11.5ZM11.5 1.33333C11.5 1.11232 11.4122 0.900359 11.2559 0.744078L10.5488 1.45118C10.5176 1.41993 10.5 1.37754 10.5 1.33333H11.5ZM11.2559 0.744078C11.0996 0.587797 10.8877 0.5 10.6667 0.5V1.5C10.6225 1.5 10.5801 1.48244 10.5488 1.45118L11.2559 0.744078ZM10.6667 0.5H1.33333V1.5H10.6667V0.5ZM1.33333 0.5C1.11232 0.5 0.900358 0.587797 0.744078 0.744078L1.45118 1.45118C1.41993 1.48244 1.37754 1.5 1.33333 1.5V0.5ZM0.744078 0.744078C0.587797 0.900358 0.5 1.11232 0.5 1.33333H1.5C1.5 1.37754 1.48244 1.41993 1.45118 1.45118L0.744078 0.744078ZM0.5 1.33333V8.22222H1.5V1.33333H0.5ZM1.63133 11.0758L6.35355 6.35355L5.64645 5.64645L0.924224 10.3687L1.63133 11.0758ZM5.5 6V8.22222H6.5V6H5.5ZM6 5.5H3.77778V6.5H6V5.5Z" fill="#101010" fill-opacity="0.6" />
						</svg>
					</span>
                    </a>
                <div class="bottom-info">
                    <div class="bottom-info-container">
                        <div class="time-info">
                            <span><?php echo get_the_time('H:i', $post_ID); ?></span>
                            <span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
                        </div>
                        <div>
                            <?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>

                            <?php if ($is_advertising) : ?>
                                <?php render_advertising_icon(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                        <div>
                            <div class="share-block--fold">
                                <?php echo share_links($post_ID); ?>
                                <?php render_share_icon(); ?>
                            </div>
                        </div>
                </div>
            </div>
		</div>
	</div>
    </div>
<?php
}
