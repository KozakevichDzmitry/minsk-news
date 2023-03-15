<?php

require_once(COMPONENTS_PATH . "icons/video-content-icon.php");
require_once(COMPONENTS_PATH . "icons/share-icon.php");

require_once(COMPONENTS_PATH . 'content-exist-markers.php');

function single_satm_slide($post)
{
?>
	<div>
		<div class="satm-header">
			<div class="content-exists">
                <?php $exist_markers = render_content_exist_markers($post_ID); ?>
                <?php if($exist_markers): ?>
                    <div class="content">
                        <?php  echo $exist_markers; ?>
                    </div>
                <?php endif;?>
				<div class="tags">
					<span>Экономика</span>
				</div>
			</div>

			<div class="title">
				<span>
					Гoвoрим с Нагорной Еленой
				</span>
			</div>

			<div class="share">
				<div class="date">
					<span>
						<?php echo date("H:i", strtotime($post->post_date)); ?>
					</span>
					<span>
						<?php echo date("d.m.Y", strtotime($post->post_date)); ?>
					</span>
				</div>
				<div>
					<a href="#">
						<?php render_share_icon(); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="satm-content">
			<?php echo get_post_field('post_content', $post->ID); ?>
		</div>

		<div class="satm-video">
			<?php $youtube_sufix = carbon_get_post_meta($post->ID, 'crb_youtube_code'); ?>
			<?php $simple_video_id = carbon_get_post_meta($post->ID, 'crb_simple_video'); ?>

			<?php if (!empty($youtube_sufix)) : ?>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $youtube_sufix; ?>" title="YouTube video player" style="border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<?php elseif (!empty($simple_video_id)) : ?>
				<video controls>
					<source src="<?php echo wp_get_attachment_url($simple_video_id[0]); ?>" type="video/mp4">
				</video>
			<?php endif; ?>
		</div>
	</div>
<?php
}
