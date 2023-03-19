<?php

require_once(COMPONENTS_PATH . 'district-item-tablet.php');

function render_district_news_template()
{
	$districts_quary = new WP_Query([
		'post_type' => 'district',
		'posts_per_page' => -1,
		'post_status' => 'publish',
	]);

	$districts = $districts_quary->posts;
?>
	<?php render_topic_bar('Ваш район', false, array('link' => get_site_url() . '/vash-rajon/',)); ?>
	<div class="district-tablet-template">
		<div class="districts-list-container">
			<?php foreach ($districts as $id => $district) : ?>
				<?php render_district_item_tablet(
					$district->post_title,
                    $id,
					(int)($id == 0),
					$district->post_name,
                    $district
				); ?>
			<?php endforeach; ?>
		</div>
        <div class="swiper-pagination district-tablet__pagination"></div>
        <div class="districts-list">
			<ul>
				<?php foreach ($districts as $id => $district) : ?>
					<li data-id="<?php echo (int)$id; ?>" class="district-caption <?php echo (int)($id == 0) == true ? 'active' : '';?>">
						<p><?php echo $district->post_title; ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php
}
