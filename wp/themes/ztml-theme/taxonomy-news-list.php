<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'satms-list-tem.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>

<?php require_once(COMPONENTS_PATH . 'line-news-list-item.php'); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>

<?php require_once(COMPONENTS_PATH . 'calendar.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>

<?php
$districts=[
    'zavodskoj-rajon',
    'leninskij-rajon',
    'moskovskij-rajon',
    'oktyabrskij-rajon',
    'partizanskij-rajon',
    'pervomajskij-rajon',
    'sovetskij-rajon',
    'frunzenskij-rajon',
    'czentralnyj-rajon'
];
$url = parse_url(wp_get_raw_referer());
$slag = str_replace('/','', $url['path']);
$isDistrict = in_array($slag, $districts);

$show_count = 27;
$load_count = 27;

$term = get_queried_object();

$tax_query =  array(
    'relation' => 'AND',
    array(
        'taxonomy' => 'news-list',
        'field' => 'slug',
        'terms' => $term,
    ),

);
if($isDistrict){
    $tax_query[]= array(
        'taxonomy' => 'news-district',
        'field' => 'slug',
        'terms' => $slag,
    );
}

$news_args = array(
	'post_status' => 'publish',
	'posts_per_page' => $show_count,
	'post_type' => 'news',
	'tax_query' => $tax_query
);

$news_posts = get_posts($news_args);
?>

<?php
$first_post_id = get_posts(array(
	'numberposts' => 1,
	'post_type' => 'news',
	'post_status' => 'publish',
	'order' => 'DESC',
	'tax_query' => $tax_query
))[0]->ID;

$last_post_id = get_posts(array(
	'numberposts' => 1,
	'post_type' => 'news',
	'post_status' => 'publish',
	'order' => 'ASC',
	'tax_query' => $tax_query
))[0]->ID;
$taxonomy_id = get_queried_object()->term_id;
?>

<div class="adfox-banner-background">
	<?php render_adv('page', $taxonomy_id, 'background'); ?>
</div>
<main class="ta">
	<div class="container container_adv"><?php render_adv('page', $taxonomy_id, 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar($term->name, true, array(
					'render' => 'render_calendar',
					'args' => array(
						'id' => 'datepicker-tax-news-template',
						'min_date' => get_the_time('Y-m-d', $last_post_id),
						'max_date' => get_the_time('Y-m-d', $first_post_id),
					)
				));
				?>

				<div class="page-description">
					<?php echo $term->description; ?>
				</div>
				<div class="ta-list">

					<?php if (!empty($news_posts)) : ?>
						<?php foreach ($news_posts as $post) : ?>
							<?php render_line_regular_news($post->ID); ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<?php if (intval($show_count) < $term->count) : ?>
					<div class="load-moree-btn">
						<button data-tax-name="<?php echo $term->taxonomy; ?>" data-tax-id="<?php echo $term->term_id; ?>" data-all-posts="<?php echo $term->count; ?>">Показать еще</button>
					</div>
				<?php endif ?>
			</div>
			<div class="second-content">
				<?php render_most_read_news_template(true, 'page', $taxonomy_id); ?>
				<?php render_top_three_news_template('page', $taxonomy_id); ?>
				<?php render_newspapers_template('page', $taxonomy_id); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>