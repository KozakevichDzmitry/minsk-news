<?php

require_once(COMPONENTS_PATH . 'icons/collapse-btn-icon.php');
require_once(COMPONENTS_PATH . 'icons/expand-btn-icon.php');

require_once(COMPONENTS_PATH . 'content-exist-markers.php');

function render_timline_news_template($post_ID)
{
    $cat_link = home_url();
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->taxonomy;
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->slug;
?>
	<div class="timeline-news-template" data-postid="<?php echo $post_ID ?>">
		<div class="post-container">
			<div class="post-info-container">
				<div class="post-header">
					<div class="post-header-info">
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
					<div class="bottom-info-container">
						<div class="time-info">
							<span><?php echo get_the_time('H:i', $post_ID); ?></span>
							<span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
						</div>
                        <?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>
                        <?php if ($is_advertising) : ?>
                        <div class="adv__info">
                            <span class="adv_icon__box"><?php render_advertising_icon(); ?></span>
                        </div>
                        <?php endif; ?>
					</div>
				</div>
				<div class="content-container">
					<a class="content__description" href="<?php echo esc_url(get_permalink($post_ID)); ?>">
                        <?php echo wp_strip_all_tags(get_the_title($post_ID), true); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php
}

function render_timeline_line_news($post_ID, $is_eof = false)
{
?>
	<div class="post-line <?php echo $is_eof ? 'eof' : ''; ?>" data-postid="<?php echo $post_ID ?>">
		<div class="time-info">
			<span><?php echo get_the_time('H:i', $post_ID); ?></span>
			<span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
		</div>
		<div class="post-content">
			<a class="post-title" href="<?php echo esc_url(get_permalink($post_ID)); ?>">
				<?php echo wp_strip_all_tags(get_the_title($post_ID), true); ?>
			</a>
		</div>
	</div>
<?php
}
