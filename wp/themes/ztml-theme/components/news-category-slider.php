<?php

function render_category_slider()
{
    $categories= get_terms( array(
        'taxonomy'    => 'news-list',
        'meta_query'    =>  array(
            array(
                'key' => '_crb_taxonomy_news-list_attachment',
                'value' => 'true',
                'compare' => '='
            )
        ),
    ) );
?>
	<div class="category-select-slider">
		<div class="slider-container">
			<?php
            foreach ($categories as $cat) : ?>
				<a class="category-select-btn" href="<?php echo get_category_link($cat->term_id); ?>">
					<?php echo $cat->name; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
<?php
}
