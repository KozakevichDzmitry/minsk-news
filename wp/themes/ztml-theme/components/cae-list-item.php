<?php

require_once(COMPONENTS_PATH . 'mn-player.php');

function render_cae_item_list($post_ID)
{
?>
	<div class="card-item">
		<div class="card-item__title">
			<span><?php echo get_the_title($post_ID); ?></span>
		</div>
		<div class="card-item__player">
			<?php render_mn_player($post_ID); ?>
		</div>
		<div class="card-item__description">
			<div class="overlay"></div>
			<div>
				<?php echo apply_filters('the_content', get_post_field('post_content', $post_ID)); ?>
			</div>
		</div>
		<div class="card-item__footer">
			<button class="read-more-link">
				<span class="read-more">Читать все</span>
				<span>
					<?php render_go_to_icon(); ?>
				</span>
			</button>
		</div>
	</div>
<?php
}
