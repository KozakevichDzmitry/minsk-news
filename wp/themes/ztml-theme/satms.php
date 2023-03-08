<?php

/*
 * Template Name: Говорит и показывает Минск
*/

?>

<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'satms-list-tem.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . "adv.php"); ?>

<?php
$satms = new WP_Query(
	array(
		'posts_per_page' => 3,
        'post_type' => 'video',
		'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'videos',
                'field'    => 'slug',
                'terms'    => 'govorit-i-pokazyivaet-minsk'
            )
        )
	)
);
?>

    <div class="adfox-banner-background">
        <?php render_adv('page', get_the_ID(), 'background'); ?>
    </div>
<main class="satms">
	<div class="container container_adv"><?php render_adv('page', get_the_ID(), 'before_main'); ?></div>
	<div class="container main-container">
		<div class="content-wrapper">
			<div class="main-content">
				<?php render_topic_bar(get_the_title(), false); ?>
				<div class="cards-list">
					<?php foreach ($satms->posts as $post) : ?>
						<?php render_satms_list_items($post); ?>
					<?php endforeach; ?>
				</div>
				<div class="satms__moree-btn">
					<button>Показать еще</button>
				</div>
			</div>
			<div class="second-content">
				<?php render_newspapers_template('page', get_the_ID()); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>