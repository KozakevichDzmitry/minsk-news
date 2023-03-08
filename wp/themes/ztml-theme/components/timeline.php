<?php

require_once(COMPONENTS_PATH . 'news-templates/timeline-news-template.php');

function render_timeline()
{
?>
	<div class="timeline minimize">
		<div class="container">
			<div class="minimize-bar">
				<span>Лента новостей</span>
				<span id="added_news_counter"></span>
			</div>
		</div>
		<div class="container news collapsed">
			<div class="timeline__news-list-collapsed">
				<?php
				$timeline_posts_quary = new WP_Query([
					'post_type' => 'any',
					'posts_per_page' => '3',
					'post_status' => 'publish',
					'tax_query' => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'news-list',
							'field' => 'slug',
							'terms' => 'glavnoe'
						),
						array(
							'taxonomy' => 'meri-list',
							'field' => 'slug',
							'terms' => 'glavnoe'
						)
					)
				]);

				$timeline_posts = $timeline_posts_quary->posts;
				?>
				<?php render_timline_news_template($timeline_posts[0]->ID); ?>
				<?php render_timline_news_template($timeline_posts[1]->ID); ?>
				<?php render_timline_news_template($timeline_posts[2]->ID); ?>
			</div>
			<div class="timeline__news-list-expanded">
				<div class="timeline__title">
					<span>Лента новостей</span>
				</div>
				<div id="close_timeline">
					<div class="timeline__buttons">
						<button class="timeline__btn-expand collapse">
							<?php render_expand_btn_icon(); ?>
						</button>
						<button class="timeline__btn-collapse">
							<?php render_collapse_btn_icon(); ?>
						</button>
					</div>
				</div>
				<?php
				$timeline_posts_quary = new WP_Query([
					'post_type' => 'any',
					'posts_per_page' => '10',
					'post_status' => 'publish',
					'tax_query' => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'news-list',
							'field' => 'slug',
							'terms' => 'feed'
						),
						array(
							'taxonomy' => 'meri-list',
							'field' => 'slug',
							'terms' => 'feed'
						)
					)
				]);

				$timeline_posts = $timeline_posts_quary->posts;
				?>

				<?php foreach ($timeline_posts as $id => $pst) : ?>
					<?php if ($id === count($timeline_posts) - 1) : ?>
						<?php render_timeline_line_news($pst->ID, true); ?>
					<?php else : ?>
						<?php render_timeline_line_news($pst->ID); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div id="open_timeline">
				<div class="timeline__buttons">
					<button class="timeline__btn-expand collapse">
						<?php render_expand_btn_icon(); ?>
					</button>
					<button class="timeline__btn-collapse">
						<?php render_collapse_btn_icon(); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
<?php
}
