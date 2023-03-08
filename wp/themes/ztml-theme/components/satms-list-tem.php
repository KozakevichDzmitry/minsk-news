<?php

require_once(COMPONENTS_PATH . "/icons/video-content-icon.php");
require_once(COMPONENTS_PATH . "/icons/go-to-icon.php");
require_once(COMPONENTS_PATH . "/icons/share-icon.php");

function render_satms_list_items($post)
{
?>
	<div class="card-item">
		<div class="card-item__preview">
			<?php $youtube_sufix = carbon_get_post_meta($post->ID, 'crb_youtube_code'); ?>
			<?php $simple_video_id = carbon_get_post_meta($post->ID, 'crb_simple_video'); ?>

			<?php if (!empty($youtube_sufix)) : ?>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $youtube_sufix; ?>" title="YouTube video player" style="border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<?php elseif (!empty($simple_video_id)) : ?>
				<div class="card-item__preview-icon">
					<?php include(IMAGES_PATH . 'play-icon.svg'); ?>
					<span>19:50</span>
				</div>
				<video>
					<source src="<?php echo wp_get_attachment_url($simple_video_id[0]); ?>" type="video/mp4">
				</video>
			<?php endif; ?>
		</div>
		<div class="card-item__header">
			<div class="content-exists">
				<?php render_video_content_icon(); ?>
			</div>
			<div class="tags">
				<span>Общество</span>
			</div>
		</div>
		<div class="card-item__description">
			<p>
				<?php echo $post->post_content; ?>
			</p>
		</div>
		<div class="card-item__footer">
			<a href="<?php echo '/satm/' . $post->post_name ?>" class="read-more-link">
				<span class="read-more">Читать все</span>
				<span>
					<?php render_go_to_icon(); ?>
				</span>
			</a>
			<div class="share">
				<div class="date">
					<span>
						<?php echo date("H:i", strtotime($post->post_date)); ?>
					</span>
					<span>
						<?php echo date("d.m.Y", strtotime($post->post_date)); ?>
					</span>
				</div>
				<div class="share-block--fold">
					<?php echo do_shortcode('[share_links]'); ?>
					<?php render_share_icon(); ?>
				</div>
			</div>
		</div>
	</div>
<?php
}
