<?php

function render_viber_icon()
{
	ob_start();
	$html = ob_start();
?>
    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/share-icons/viber.svg';?>" alt="">
<?php
	$html = ob_get_clean();
	ob_end_flush();

	return $html;
}
