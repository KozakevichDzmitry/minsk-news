<?php

function render_see_video_template($post_ID)
{
?>
	<div class="box">
		<div class="video-preview">
			<?php $eternal_video = carbon_get_post_meta($post_ID, 'video_post_type_eternal_video')[0]; ?>
			<?php $youtube_video = carbon_get_post_meta($post_ID, 'video_post_type_youtube-link'); ?>
			<?php if (!empty($eternal_video) && empty($youtube_video)) : ?>
				<?php do_shortcode('[eternal_video_scn attachment_id=' . $eternal_video . ']'); ?>
			<?php elseif (empty($eternal_video) && !empty($youtube_video)) : ?>
				<?php echo $youtube_video; ?>
			<?php elseif (!empty($eternal_video) && !empty($youtube_video)) : ?>
				<?php echo $youtube_video; ?>
			<?php endif; ?>
		</div>
        <a class="see__video-link" href="<?php echo get_post_permalink($post_ID); ?>">
		<?php echo get_post_field('post_title', $post_ID); ?>
        </a>
	</div>
<?php
}
