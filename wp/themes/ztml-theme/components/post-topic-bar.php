<?php

require_once(COMPONENTS_PATH . 'content-exist-markers.php');

function render_post_topic_bar($post_ID)
{
    $taxonomies = get_my_taxonomies($post_ID);
    if (!empty($taxonomies)) {
        $primary_category = get_post_primary_category($post_ID, $taxonomies);
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
	<div class="post-topic-bar">
		<div class="content-exists">
            <?php $exist_markers = render_content_exist_markers($post_ID); ?>
            <?php if($exist_markers): ?>
                <div class="content-exist">
                    <?php  echo $exist_markers; ?>
                </div>
            <?php endif;?>
            <?php if (isset($cat_link)): ?>
                <div class="tags">
                    <a href="<?php echo $cat_link; ?>" class="tags__link">
                        <span>
                            <?php echo $primary_category->name; ?>
                        </span>
                    </a>
                </div>
            <?php endif; ?>
		</div>

		<div class="title">
			<span>
				<?php echo get_the_title($post_ID); ?>
			</span>
		</div>

		<div class="date">
			<span>
				<?php echo get_the_date('h:i', $post_ID); ?>
			</span>
			<span>
				<?php echo get_the_date('d.m.Y', $post_ID); ?>
			</span>
		</div>
	</div>
<?php
}
