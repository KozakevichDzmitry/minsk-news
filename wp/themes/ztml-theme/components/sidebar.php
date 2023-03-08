<?php

function render_sidebar($cb = NULL)
{
?>
	<?php if (is_active_sidebar('main-sidebar')) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<div class="secondary-mobile">
				<div class="secondary-mobile-btn">
					<svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M4.33333 13L1 7L4.33333 1M9 13L5.66667 7L9 1" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
			</div>
			<?php if ($cb != NULL) : ?>
				<?php $cb(); ?>
			<?php endif; ?>
			<?php dynamic_sidebar('main-sidebar'); ?>
		</div>
	<?php endif; ?>
<?php
}
