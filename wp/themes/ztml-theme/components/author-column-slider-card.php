<?php

require_once(COMPONENTS_PATH . 'author-column-post-slide.php');

function render_author_column_slider_card($post_data)
{
?>
	<div class="author-column-slider-card swiper-slide" data-id="<?php echo $post_data->post_author; ?>">
		<div class="author-column-slider-card__title">
			<span>
				<?php echo the_author_meta('display_name', $post_data->post_author); ?>
			</span>
		</div>
		<div class="author-column-slider-card__image">
            <a href="<?php echo get_author_posts_url($post_data->post_author); ?>">
                <?php echo get_avatar(get_post_field('post_author', $post_data->ID)); ?>
            </a>
		</div>
		<?php render_author_column_post_slide($post_data); ?>
	</div>
<?php
}
