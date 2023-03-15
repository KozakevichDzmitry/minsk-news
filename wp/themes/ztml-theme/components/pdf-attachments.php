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
	<div class="pdf-attachments-item" data-postid="<?php echo $post_id?>">
		<a class="pdf-attachments-item__view-link" href="<?php echo $pdf_attachment_url; ?>" target="_blank">
			<div class="pdf-attachments-item__image-container">
                <?php echo get_the_post_thumbnail( $post_id, 'newspaper-thumbnails' );?>
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
