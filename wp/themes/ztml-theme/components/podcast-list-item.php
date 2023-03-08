<?php

require_once(COMPONENTS_PATH . "/icons/video-content-icon.php");
require_once(COMPONENTS_PATH . "/icons/go-to-icon.php");
require_once(COMPONENTS_PATH . "/icons/share-icon.php");

function render_satms_list_items($post)
{
?>
	<div class="card-item">
		<div class="card-item__title">
			<span>Программа от 25 ноября 2021</span>
		</div>
		<div class="card-item__player"></div>
		<div class="card-item__description">
			<p>
				<?php echo $post->post_content; ?>
			</p>
		</div>
		<div class="card-item__footer">
			<a href="<?php echo '/cae/' . $post->post_name ?>" class="read-more-link">
				<span class="read-more">Читать все</span>
				<span>
					<?php render_go_to_icon(); ?>
				</span>
			</a>
		</div>
	</div>
<?php
}
