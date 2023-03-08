<?php

function render_pdf_attachments($posts, $class = '', $slug = '')
{
?>
	<div class="pdf-attachments <?php echo $class; ?> <?php echo $slug; ?>">
		<?php foreach ($posts as $post) : ?>
			<?php render_pdf_attachments_item($post->ID); ?>
		<?php endforeach; ?>
	</div>
<?php
}

function render_pdf_attachments_item($post_id)
{
?>
	<?php $pdf_attachment_url = wp_get_attachment_url(carbon_get_post_meta($post_id, 'crb_pdf_attachment')); ?>
	<?php $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full'); ?>
	<div class="pdf-attachments-item" data-postid="<?php echo $post_id?>">
		<a class="pdf-attachments-item__view-link" href="<?php echo $pdf_attachment_url; ?>" target="_blank">
			<div class="pdf-attachments-item__image-container">
				<img class="pdf-attachments-item__image" src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_post_meta($post_id, '_wp_attachment_image_alt', TRUE); ?>" />
			</div>
			<div class="pdf_title">
				<h3><?php echo get_the_title($post_id); ?></h3>
			</div>
		</a>
		<a class="pdf-attachments-item__download-link" href="<?php echo $pdf_attachment_url; ?>" download="">
			<div>Скачать PDF</div>
		</a>
	</div>
<?php
}
