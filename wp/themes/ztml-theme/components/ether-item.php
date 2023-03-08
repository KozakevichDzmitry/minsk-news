<?php

function render_ether_item($post_ID)
{
?>
	<div class="efirs-list-item">
		<div class="efirs-list-item__decription">
			<?php echo apply_filters('the_content', get_post_field('post_content', $post_ID)); ?>
		</div>
		<div class="efirs-list-item__efir-part">
			<div class="efirs-list-item__thumb">
				<?php echo get_the_post_thumbnail($post_ID); ?>
			</div>
			<div>
				<?php
				$eternal_video = carbon_get_post_meta($post_ID, 'crb_aqq_video')[0];
				$youtube_video = carbon_get_post_meta($post_ID, 'crb_youtube_code_aqq');
				?>
				<div class="video-preview">
					<?php if (!empty($eternal_video) && empty($youtube_video)) : ?>
						<?php do_shortcode('[eternal_video_scn attachment_id=' . $eternal_video . ']'); ?>
					<?php elseif (empty($eternal_video) && !empty($youtube_video)) : ?>
						<?php echo $youtube_video; ?>
					<?php elseif (!empty($eternal_video) && !empty($youtube_video)) : ?>
						<?php echo $youtube_video; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php
}
