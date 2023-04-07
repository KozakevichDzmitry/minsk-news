<?php

require_once(COMPONENTS_PATH . 'calendar.php');
require_once(COMPONENTS_PATH . 'news-templates/main-template.php');

function render_main_news_template()
{
	$timeline_news_quary = new WP_Query([
		'post_type' => array( 'news', 'meri'),
		'posts_per_page' => '8',
		'post_status' => 'publish',
        'cache_results' => false,
		'tax_query' => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'news-list',
				'field' => 'slug',
				'terms' => 'main'
			),
			array(
				'taxonomy' => 'meri-list',
				'field' => 'slug',
				'terms' => 'main'
			)
		)
	]);

	$timeline_news_posts = $timeline_news_quary->posts;
?>
	<div class="main-news-cat box-line-gap" style="margin-bottom: 30px;">
		<div class="main-news-list" style="display: flex;flex-direction: column;">
			<?php render_topic_bar("Главное", false, array(
				'link' => get_site_url() . '/news-list/main/',
				'title' => '',
				'icon' => '
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M3.77778 10.5C3.50164 10.5 3.27778 10.7239 3.27778 11C3.27778 11.2761 3.50164 11.5 3.77778 11.5V10.5ZM10.6667 11V11.5V11ZM11 10.6667H11.5H11ZM11 1.33333H11.5H11ZM1.33333 1V1.5V1ZM1 1.33333H0.5H1ZM0.5 8.22222C0.5 8.49836 0.723858 8.72222 1 8.72222C1.27614 8.72222 1.5 8.49836 1.5 8.22222H0.5ZM0.924224 10.3687C0.728962 10.5639 0.728962 10.8805 0.924224 11.0758C1.11949 11.271 1.43607 11.271 1.63133 11.0758L0.924224 10.3687ZM6 6H6.5C6.5 5.72386 6.27614 5.5 6 5.5V6ZM5.5 8.22222C5.5 8.49836 5.72386 8.72222 6 8.72222C6.27614 8.72222 6.5 8.49836 6.5 8.22222H5.5ZM3.77778 5.5C3.50164 5.5 3.27778 5.72386 3.27778 6C3.27778 6.27614 3.50164 6.5 3.77778 6.5V5.5ZM3.77778 11.5H10.6667V10.5H3.77778V11.5ZM10.6667 11.5C10.8877 11.5 11.0996 11.4122 11.2559 11.2559L10.5488 10.5488C10.5801 10.5176 10.6225 10.5 10.6667 10.5V11.5ZM11.2559 11.2559C11.4122 11.0996 11.5 10.8877 11.5 10.6667H10.5C10.5 10.6225 10.5176 10.5801 10.5488 10.5488L11.2559 11.2559ZM11.5 10.6667V1.33333H10.5V10.6667H11.5ZM11.5 1.33333C11.5 1.11232 11.4122 0.900359 11.2559 0.744078L10.5488 1.45118C10.5176 1.41993 10.5 1.37754 10.5 1.33333H11.5ZM11.2559 0.744078C11.0996 0.587797 10.8877 0.5 10.6667 0.5V1.5C10.6225 1.5 10.5801 1.48244 10.5488 1.45118L11.2559 0.744078ZM10.6667 0.5H1.33333V1.5H10.6667V0.5ZM1.33333 0.5C1.11232 0.5 0.900358 0.587797 0.744078 0.744078L1.45118 1.45118C1.41993 1.48244 1.37754 1.5 1.33333 1.5V0.5ZM0.744078 0.744078C0.587797 0.900358 0.5 1.11232 0.5 1.33333H1.5C1.5 1.37754 1.48244 1.41993 1.45118 1.45118L0.744078 0.744078ZM0.5 1.33333V8.22222H1.5V1.33333H0.5ZM1.63133 11.0758L6.35355 6.35355L5.64645 5.64645L0.924224 10.3687L1.63133 11.0758ZM5.5 6V8.22222H6.5V6H5.5ZM6 5.5H3.77778V6.5H6V5.5Z" fill="#214972"/>
					</svg>'
			));
			?>
			<?php render_main_template(); ?>
		</div>

		<?php
		$first_post_id = get_posts(
			array(
				'numberposts' => 1,
				'post_type' => array( 'news', 'meri'),
				'post_status' => 'publish',
				'order' => 'DESC',
                'cache_results' => false,
                'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'news-list',
						'field' => 'slug',
						'terms' => 'main'
					),
					array(
						'taxonomy' => 'meri-list',
						'field' => 'slug',
						'terms' => 'main'
					)
				)
			)
		)[0]->ID;
		?>

		<?php
		$last_post_id = get_posts(
			array(
				'numberposts' => 1,
				'post_type' => array( 'news', 'meri'),
				'post_status' => 'publish',
				'order' => 'ASC',
                'cache_results' => false,
                'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'news-list',
						'field' => 'slug',
						'terms' => 'main'
					),
					array(
						'taxonomy' => 'meri-list',
						'field' => 'slug',
						'terms' => 'main'
					)
				)
			)
		)[0]->ID;
		?>

		<div class="long-news-list">
			<?php render_topic_bar("Новости", true, array(
				'link' => get_site_url() . '/vse-novosti/',
				'render' => 'render_calendar',
				'args' => array(
					'id' => 'datepicker-all-news',
					'min_date' => get_the_time('Y-m-d', $last_post_id),
					'max_date' => get_the_time('Y-m-d', $first_post_id),
				)
			));
			?>
			<div id="timeline-main-block" class="box box-list news-scrolled timeline-main no-lines" style="padding: 10px;">
				<?php foreach ($timeline_news_posts as $pst) : ?>
					<?php render_news_template_line($pst->ID); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php
}
