<?php

function render_facebook_share_icon()
{
    ob_start();
    $html = ob_start();
    ?>
    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/share-icons/facebook.svg';?>" alt="">
<?php
    $html = ob_get_clean();
    ob_end_flush();

    return $html;
}
