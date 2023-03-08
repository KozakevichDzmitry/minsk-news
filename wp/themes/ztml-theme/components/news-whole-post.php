<?php

require_once(COMPONENTS_PATH . "icons/camera-icon.php");
require_once(COMPONENTS_PATH . "icons/video-content-icon.php");
require_once(COMPONENTS_PATH . 'line-news-list-item.php');

require_once(COMPONENTS_PATH . 'content-exist-markers.php');

function render_news_whole_post($id, $cat = NULL)
{
?>
	<?php $single_post = get_post($id); ?>
	<?php $author_id = $single_post->post_author; ?>
    <?php
    $cat_link = home_url();
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($id, get_my_taxonomies($id))['primary_category']->taxonomy;
    $cat_link .= '/';
    $cat_link .= get_post_primary_category($id, get_my_taxonomies($id))['primary_category']->slug;
    ?>
	<div class="post">
		<div class="post-header">
			<div class="content-exists">
				<div class="content">
					<?php render_content_exist_markers($single_post->ID); ?>
				</div>
				<div class="tags">
                    <a href="<?php echo $cat_link; ?>" class="tags__link">
                        <span>
                            <?php echo get_post_primary_category($id, get_my_taxonomies($id))['primary_category']->name;?>
                        </span>
                    </a>
				</div>
			</div>

			<div class="title">
				<span>
					<?php echo get_the_title($single_post->ID); ?>
				</span>
			</div>

			<div class="share">
				<div class="date">
					<span>
						<?php echo date("H:i", strtotime($single_post->post_date)); ?>
					</span>
					<span>
						<?php echo date("d.m.Y", strtotime($single_post->post_date)); ?>
					</span>
				</div>
			</div>
		</div>
		<?php
		$content = apply_filters('the_content', $single_post->post_content, $single_post->ID);
		?>

		<div class="page-content">
			<?php echo $content; ?>
			<div class="adv__info">
				<?php $is_advertising = carbon_get_post_meta($single_post->ID, 'news_is_advertising'); ?>
				<?php if ($is_advertising) : ?>
					<span class="adv_icon__box"><?php render_advertising_icon(); ?></span>
					<span class="adv_text__box"><?php echo carbon_get_post_meta($single_post->ID, 'news_text_advertising'); ?></span>
				<?php endif; ?>
			</div>
		</div>

		<div class="footer-content">
			<div class="author-info">
				<div class="author-image">
                    <?php echo get_avatar($author_id); ?>
                </div>
				<div class="author-details">
					<span class="label">Автор материалов</span>
					<span class="name"><?php echo the_author_meta('display_name', $author_id); ?></span>
					<a href="<?php echo get_author_posts_url($author_id); ?>" class="other-posts">Все новости автора</a>
				</div>
			</div>
			<?php echo do_shortcode('[share_links]'); ?>
		</div>
	</div>
<?php
}
