<?php

function render_line_news_list_item($post_ID, $reversClass = false)
{
?>
	<div class="line-news <?php echo $reversClass ? ' column-revers' : ''; ?>">
		<?php $img_url = get_the_post_thumbnail_url($post_ID, 'full'); ?>

		<?php if (!empty($img_url)) : ?>
			<a class="image" href="<?php echo esc_url(get_permalink($post_ID)); ?>">
				<img src="<?php echo $img_url; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?>" />
			</a>
		<?php endif; ?>
		<div class="content">
			<div class="content-container">
				<a href="<?php echo esc_url(get_permalink($post_ID)); ?>">
					<span class="content__title"><?php echo get_the_title($post_ID); ?></span>
				</a>
				<a class="content__description" href="<?php echo esc_url(get_permalink($post_ID)); ?>">
					<?php echo wp_strip_all_tags(get_the_excerpt($post_ID), true); ?>
				</a>
			</div>
			<div class="info">
				<div class="info__time">
					<span><?php echo get_the_time('H:i', $post_ID); ?></span>
					<span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
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
