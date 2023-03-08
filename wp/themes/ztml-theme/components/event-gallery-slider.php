<?php

function render_event_gallery_slider($post_ID)
{
	$images_gallery = carbon_get_post_meta($post_ID, 'slider_gallery');
?>
	<div class="event_slider">
		<?php foreach ($images_gallery as $image) : ?>
			<?php $file_type = wp_attachment_is('image', $image); ?>
			<?php if ($file_type) : ?>
				<div>
					<img class="fill zoom-img" src="<?php echo wp_get_attachment_image_url($image); ?>" alt="<?php echo get_post_meta($image, '_wp_attachment_image_alt', TRUE); ?>" />
				</div>
			<?php else : ?>
				<video controls>
					<source src="<?php echo wp_get_attachment_url($image); ?>" type="video/mp4">
				</video>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php
}
