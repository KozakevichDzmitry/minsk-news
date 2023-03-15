<?php
require_once(COMPONENTS_PATH . 'content-exist-markers.php');
require_once(COMPONENTS_PATH . "icons/video-content-icon.php");
require_once(SHORTCODES_PATH . "share-links.php");

function top_three_minsk()
{
    $top_three_posts = [
        ['id' => url_to_postid(get_option('top1_url')), 'title' => get_option('top1_title')],
        ['id' => url_to_postid(get_option('top2_url')), 'title' => get_option('top2_title')],
        ['id' => url_to_postid(get_option('top3_url')), 'title' => get_option('top3_title')]
    ];

	echo '<h3 class="widget-title">Топ-3 о Минске</h3>';

	echo '<div class="box box-list no-lines">';
	foreach ($top_three_posts as $top_three_post) {
        $post_ID = $top_three_post['id'];
        $post_permalink = get_post_permalink($post_ID);
        $cat_link = home_url();
        $cat_link .= '/';
        $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->taxonomy;
        $cat_link .= '/';
        $cat_link .= get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->slug;
        ?>

	<div class="news-template-line vertical" data-postid="<?php echo $post_ID ?>" style="flex-direction: row">
        <a href="<?php echo $post_permalink; ?>">
            <?php echo get_the_post_thumbnail( $post_ID, 'post-thumbnails' );?>
        </a>
		<div class="post-container">
			<div class="post-info-container">
                <?php $exist_markers = render_content_exist_markers($post_ID); ?>
                <?php if($exist_markers): ?>
                    <div class="content-exist">
                        <?php  echo $exist_markers; ?>
                    </div>
                <?php endif;?>
				<div class="post-category">
                    <a href="<?php echo $cat_link; ?>" class="tags__link">
                    <span><?php echo get_post_primary_category($post_ID, get_my_taxonomies($post_ID))['primary_category']->name;?></span>
                    </a>
                </div>
			</div>
			<div class="post-title">
				<a href="<?php echo $post_permalink; ?>">
					<?php echo $top_three_post['title']; ?>
                </a>
			</div>
			<div class="bottom-info">
				<div class="bottom-info-container">
					<div class="time-info">
						<span><?php echo get_the_time('H:i', $post_ID); ?></span>
						<span><?php echo get_the_time('d.m.Y', $post_ID); ?></span>
					</div>
                    <?php $is_advertising = carbon_get_post_meta($post_ID, 'news_is_advertising'); ?>
                    <?php if ($is_advertising) : ?>
                    <div>
                        <?php render_advertising_icon(); ?>
                    </div>
                    <?php endif; ?>
				</div>
                <div class="share-block--fold">
                    <?php echo share_links($post_ID); ?>
                    <?php render_share_icon(); ?>
                </div>
			</div>
		</div>
	</div>
        <?php }
	echo '</div>';
}

add_shortcode('top_three_minsk_scn', 'top_three_minsk');
