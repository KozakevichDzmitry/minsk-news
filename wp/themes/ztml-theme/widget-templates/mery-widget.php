<?php

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

require_once(COMPONENTS_PATH . 'news-templates.php');

class MeryWidget extends Widget
{
    function __construct()
    {
        $this->setup('wp_mery_widget', 'Mery Widget', 'Displays a block with primite mery', array(
            Field::make('text', 'wp_mery_widget_title', 'Заголовок'),
            Field::make('text', 'wp_mery_widget_link', 'Ссылка'),
            Field::make('association', 'wp_mery_widget_post', 'Посты')
                ->set_types(array(
                    array(
                        'type' => 'post',
                        'post_type' => 'meri',
                    )
                ))
        ));
    }

    function front_end($args, $instance)
    {
        $title = '';

        if ($instance['wp_mery_widget_link']) {
            $title .= '<a href="' . $instance['wp_mery_widget_link'] . '">';
            $title .= $instance['wp_mery_widget_title'] . '</a>';
        } else {
            $title = $instance['wp_mery_widget_link'];
        }
        echo $args['before_title'] . $title . $args['after_title'];
        echo '<div class="box box-list no-lines">';
        foreach ($instance['wp_mery_widget_post'] as $value) {
            render_news_template_line($value['id'], true, false, true);
        }
        echo '</div>';
    }
}

add_action('widgets_init', function () {
    register_widget('MeryWidget');
});
