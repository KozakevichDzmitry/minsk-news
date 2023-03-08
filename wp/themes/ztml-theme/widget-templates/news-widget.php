<?php

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

require_once(COMPONENTS_PATH . 'news-templates.php');

class NewsWidget extends Widget
{
	function __construct()
	{
		$this->setup('wp_news_widget', 'News Widget', 'Displays a block with news', array(
			Field::make('text', 'wp_news_widget_title', 'Заголовок'),
			Field::make('text', 'wp_news_widget_link', 'Ссылка'),
			Field::make('text', 'wp_news_widget_post_count', 'Количество постов')
				->set_attribute('min', '1')
				->set_attribute('type', 'number'),
			Field::make('association', 'wp_news_widget_cats', 'Категории')
				->set_types(array(
					array(
						'type' => 'term',
						'taxonomy' => 'news-list',
					)
				))
		));
	}

	function front_end($args, $instance)
	{
        $title= '';

        if($instance['wp_news_widget_link']){
            $title .= '<a href="' . $instance['wp_news_widget_link'] . '">';
            $title .= $instance['wp_news_widget_title'] . '</a>';
        }else{
            $title = $instance['wp_news_widget_link'];
        }

		echo $args['before_title'] . $title . $args['after_title'];

		echo '<div class="box box-list no-lines">';

		foreach ($instance['wp_news_widget_cats'] as $cat) {
			$quary_args = [
				'post_type' => 'news',
				'post_status' => 'publish',
				'posts_per_page' => $instance['wp_news_widget_post_count'],
				'tax_query' => [
					[
						'taxonomy' => $cat['subtype'],
						'terms' => $cat['id'],
						'field' => 'term_id',
						'operator' => 'IN'
					]
				],
			];

			$news_posts_quary = new WP_Query($quary_args);

			$news_posts = $news_posts_quary->posts;

			foreach ($news_posts as $pst) {
				render_news_template_line($pst->ID, true, false, true);
			}
		}

		echo '</div>';
	}
}

add_action('widgets_init', function () {
	register_widget('NewsWidget');
});
