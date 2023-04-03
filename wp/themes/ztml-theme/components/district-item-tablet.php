<?php

function render_district_item_tablet($title, $id, $is_active = false, $slug, $district)
{
	$timeline_news_quary = new WP_Query([
		'post_type' => array('news', 'meri'),
		'post_status' => 'publish',
		'posts_per_page' => '2',
		'tax_query' => array(
			array(
				'taxonomy' => 'news-district',
				'field' => 'slug',
				'terms' => $slug
			)
		)
	]);

	$timeline_news_posts = $timeline_news_quary->posts;
?>
	<div class="district-item <?php echo $is_active == true ? 'active' : ''; ?>" data-id="<?php echo (int)$id; ?>">
        <div class="district-preview__title">
            <?php echo $title ?>
        </div>
        <div class="content">
            <?php echo get_the_post_thumbnail($district, [380, 245])?>
            <span class="district-preview__caption">Новости района</span>
            <div class="district-news">
                <?php render_news_template_line($timeline_news_posts[0]->ID); ?>
                <?php render_news_template_line($timeline_news_posts[1]->ID,false, false, false, false); ?>
            </div>
            <div class="district-preview__see-all">
                <a href=<?php echo get_permalink($district->ID); ?>>
                    <span>Смотреть всё</span>
                </a>
            </div>
        </div>
	</div>
<?php
}
