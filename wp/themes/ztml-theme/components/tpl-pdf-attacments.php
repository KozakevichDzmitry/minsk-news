<?php $pdf_attachment_url = wp_get_attachment_url(carbon_get_post_meta($args['ID'], 'crb_pdf_attachment')); ?>
<?php $thumbnail_url = get_the_post_thumbnail_url($args['ID'], 'full'); ?>
<div class="pdf-attachments-item" id="<?php echo $args['ID'] ?>">
	<a class="pdf-attachments-item__view-link" href="<?php echo $pdf_attachment_url; ?>" target="_blank">
		<div class="pdf-attachments-item__image-container">
			<img class="pdf-attachments-item__image" src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_post_meta($args['ID'], '_wp_attachment_image_alt', TRUE); ?>" />
		</div>
		<div class="pdf_title">
			<h3><?php echo get_the_title($args['ID']); ?></h3>
		</div>
	</a>
	<a class="pdf-attachments-item__download-link" href="<?php echo $pdf_attachment_url; ?>" download="">
		<div>Скачать PDF</div>
	</a>
</div>