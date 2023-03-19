<?php

require_once(COMPONENTS_PATH . "icons/location-icon.php");
require_once(COMPONENTS_PATH . "icons/camera-icon.php");
require_once(COMPONENTS_PATH . "icons/video-content-icon.php");
require_once(COMPONENTS_PATH . 'line-news-list-item.php');
require_once(COMPONENTS_PATH . 'content-exist-markers.php');

function render_half_post($id, $cat = NULL)
{
    $taxonomies = get_my_taxonomies($id);
    if (!empty($taxonomies)) {
        $primary_category = get_post_primary_category($id, $taxonomies);
        if(!empty($primary_category['primary_category'])){
            $primary_category = $primary_category['primary_category'];
            $cat_link = home_url();
            $cat_link .= '/';
            $cat_link .= $primary_category->taxonomy;
            $cat_link .= '/';
            $cat_link .= $primary_category->slug;
        }
    }
?>
	<?php $single_post = get_post($id); ?>
	<?php $author_id = $single_post->post_author; ?>
	<div class="post">
		<div class="post-header">
			<div class="content-exists">
                <?php $exist_markers = render_content_exist_markers($id); ?>
                <?php if($exist_markers): ?>
                    <div class="content-exist">
                        <?php  echo $exist_markers; ?>
                    </div>
                <?php endif;?>
                <?php if(isset($cat_link)): ?>
                    <div class="tags">
                        <a href="<?php echo $cat_link; ?>" class="tags__link">
                        <span>
                            <?php echo $primary_category->name;?>
                        </span>
                        </a>
                    </div>
                <?php endif;?>
			</div>
			<div class="title">
				<span>
					<?php echo get_the_title($id); ?>
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
		$content = apply_filters('the_content', $single_post->post_content);
		?>

		<div class="page-content">
			<?php echo $content; ?>
		</div>

		<div class="footer-content">
			<div class="author-info">
				<div class="author-image">
					<?php echo get_avatar($author_id); ?>
				</div>
				<div class="author-details">
					<span class="label">Автор материалов</span>
					<span class="name"><?php echo the_author_meta('display_name', $author_id); ?></span>
					<a href="<?php echo get_author_posts_url(get_post_field('post_author', $id)) . '?type=news'; ?>" class="other-posts">Все новости автора</a>
				</div>
			</div>
            <?php echo share_links($id); ?>
		</div>
	</div>
<?php
}
