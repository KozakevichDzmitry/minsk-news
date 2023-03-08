<?php get_header(); ?>

<?php
require_once(COMPONENTS_PATH . 'pdf-attachments.php');
require_once(COMPONENTS_PATH . 'topic-bar.php');
require_once(COMPONENTS_PATH . 'topic-minibar.php');
require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php');
require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php');
require_once(COMPONENTS_PATH . 'sidebar.php');
require_once(COMPONENTS_PATH . 'adv.php');
?>

<?php
$term = get_queried_object();
$taxonomy_id = $term ->term_id;
$show_count = carbon_get_term_meta($taxonomy_id, 'crb_newspapers_taxonomy_show_count');
$load_count = carbon_get_term_meta($taxonomy_id, 'crb_newspapers_taxonomy_load_count');
$the_query = new WP_Query(
	array(
		'post_count' => $show_count,
		'post_type' => 'newspaper',
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'newspapers',
				'field' => 'id',
				'terms' => $taxonomy_id,
			)
		)
	)
);
?>

<?php $topic_title = single_term_title('', false); ?>

<div class="adfox-banner-background">
	<?php render_adv('page', $taxonomy_id, 'background'); ?>
</div>
<main id="newspapers" class="newspapers">
	<div class="container container_adv"><?php render_adv('page', $taxonomy_id, 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar($topic_title); ?>

				<div class="mob-container">
                    <?php echo get_term_field('description', $taxonomy_id); ?>
					<?php
					$args = array(
						'post_type' => 'newspaper',
						'post_status' => 'publish',
						'posts_per_page' => intval($show_count),
						'order' => 'DESC',
						'tax_query' => array(
							array(
								'taxonomy' => 'newspapers',
								'field'    => 'id',
								'terms'    => $taxonomy_id
							)
						)
					);
					$posts = get_posts($args);

					if (!empty($posts)) {
					?>
						<div class="pdf-attachments">
							<?php
							foreach ($posts as $pst) {
								get_template_part('./components/tpl-pdf-attacments', null, ['ID' => $pst->ID]);
							}
							?>
						</div>
					<?php
					}
					?>
					<?php if (intval($show_count) < $term->count) { ?>
						<button class="newspaper__moree-btn btn-loadmore" data-param-posts='<?php echo serialize($args); ?>' data-tpl='pdf-attacments' data-load-posts="<?php echo $load_count ?>" data-show-posts="<?php echo $show_count ?>" data-all-posts="<?php echo $term->count;?>">
							Показать еще
						</button>
					<?php } ?>
				</div>
			</div>
			<div class="second-content">
				<?php render_most_read_news_template(true, 'page', $taxonomy_id); ?>
				<?php render_top_three_news_template('page', $taxonomy_id); ?>

				<?php if (!($topic_title === 'Качели')) : ?>
					<?php render_newspapers_template('page', $taxonomy_id); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php render_sidebar(function () {
			$newspapers_taxes = get_terms(
				array(
					'taxonomy' => get_taxonomies(['object_type' => ['newspaper']]),
					'hide_empty' => false
				)
			);
		?>
			<div>
				<?php foreach ($newspapers_taxes as $tax) : ?>
					<?php render_topic_minibar($tax->name, get_term_link($tax->term_id)); ?>
				<?php endforeach; ?>
			</div>
		<?php
		}); ?>
	</div>
</main>

<?php get_footer(); ?>