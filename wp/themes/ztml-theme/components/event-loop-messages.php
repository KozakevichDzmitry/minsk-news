<?php

function render_event_loop_messages($post_ID)
{
	$data = carbon_get_post_meta($post_ID, 'crb_event');
?>
	<div class="events-content">
		<?php foreach ($data as $data_item) : ?>
			<div class="events-header">
				<div class="text_container">
					<p class="events-time"><?php echo $data_item["event_time"]; ?></p>
					<p class="events-title"><?php echo $data_item["title"]; ?></p>
				</div>
			</div>
			<div class="img-container">
				<?php foreach ($data_item["crb_media_gallery"] as $image) : ?>
					<img class="event-img zoom-img" src="<?php echo wp_get_attachment_url($image); ?>" alt="<?php echo get_post_meta($image, '_wp_attachment_image_alt', TRUE); ?>" />
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php
}
