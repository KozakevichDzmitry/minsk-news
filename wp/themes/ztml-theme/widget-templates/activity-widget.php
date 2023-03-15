<?php
/*
 * Виджет Активность
 */

function true_remove_activity_widget()
{
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
}

add_action('wp_dashboard_setup', 'true_remove_activity_widget');

/*
 * Регистрируем свой виджет
 */
function true_add_activity_widget()
{
    wp_add_dashboard_widget('dashboard_activity', 'Activity', 'true_site_activity'); // функция true_site_activity будет выводить содержимое виджета
}

add_action('wp_dashboard_setup', 'true_add_activity_widget');

function mn_dashboard_recent_posts($args)
{
    $query_args = array(
        'post_type' => $args['post_type'],
        'post_status' => $args['status'],
        'orderby' => 'date',
        'order' => $args['order'],
        'posts_per_page' => (int)$args['max'],
        'no_found_rows' => true,
        'cache_results' => false,
    );

    $posts = new WP_Query($query_args);

    if ($posts->have_posts()) {

        echo '<div id="' . $args['id'] . '" class="activity-block">';

        echo '<h3>' . $args['title'] . '</h3>';

        echo '<ul>';

        $today = current_time('Y-m-d');
        $tomorrow = current_datetime()->modify('+1 day')->format('Y-m-d');
        $year = current_time('Y');

        while ($posts->have_posts()) {
            $posts->the_post();

            $time = get_the_time('U');

            if (gmdate('Y-m-d', $time) === $today) {
                $relative = __('Today');
            } elseif (gmdate('Y-m-d', $time) === $tomorrow) {
                $relative = __('Tomorrow');
            } elseif (gmdate('Y', $time) !== $year) {
                /* translators: Date and time format for recent posts on the dashboard, from a different calendar year, see https://www.php.net/manual/datetime.format.php */
                $relative = date_i18n(__('M jS Y'), $time);
            } else {
                /* translators: Date and time format for recent posts on the dashboard, see https://www.php.net/manual/datetime.format.php */
                $relative = date_i18n(__('M jS'), $time);
            }

            // Use the post edit link for those who can edit, the permalink otherwise.
            $recent_post_link = current_user_can('edit_post', get_the_ID()) ? get_edit_post_link() : get_permalink();

            $draft_or_post_title = _draft_or_post_title();
            printf(
                '<li><span>%1$s</span> <a href="%2$s" aria-label="%3$s">%4$s</a></li>',
                /* translators: 1: Relative date, 2: Time. */
                sprintf(_x('%1$s, %2$s', 'dashboard'), $relative, get_the_time()),
                $recent_post_link,
                /* translators: %s: Post title. */
                esc_attr(sprintf(__('Edit &#8220;%s&#8221;'), $draft_or_post_title)),
                $draft_or_post_title
            );
        }

        echo '</ul>';
        echo '</div>';

    } else {
        return false;
    }

    wp_reset_postdata();

    return true;
}

/*
 * Содержимое нового виджета
 */

function true_site_activity()
{
    echo '<div id="activity-widget">';

    // посты, запланированные на публикацию (вы можете изменить их параметры отображения либо не отображать совсем)
    $query_args = array(
        'post_type' => 'any',
        'status' => 'future',
        'order' => 'ASC',
        'display' => 2,
        'max' => 10,
        'title' => __('Publishing Soon'),
        'id' => 'future-posts',
    );
    $future_posts = mn_dashboard_recent_posts($query_args);

    // недавно опубликованные посты
    $recent_posts = mn_dashboard_recent_posts(array(
        'display' => 2,
        'max' => 5,
        'post_type' => 'any',
        'status' => 'publish',
        'order' => 'DESC',
        'title' => __('Recently Published'),
        'id' => 'published-posts',
    ));

    // а вот и комментарии, в параметрах функции указываем количество выводимых комментов
    $recent_comments = wp_dashboard_recent_comments(3);

    // что следует отображать, если нет ни постов ни комментов
    if (!$future_posts && !$recent_posts && !$recent_comments) {
        echo '<div class="no-activity">';
        echo '<p class="smiley"></p>';
        echo '<p>' . __('No activity yet!') . '</p>';
        echo '</div>';
    }
    echo '</div>';
}
