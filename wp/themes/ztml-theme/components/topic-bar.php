<?php

require_once(COMPONENTS_PATH . 'icons/header-mask.php');

function render_topic_bar($title = '', $show_action = true, $action = array())
{
?>
	<div class="topic-bar">
		<div class="topic-bar__container">
			<a href="<?php echo $action['link']; ?>">
				<h4 class="topic-bar__title">
					<?php echo $title ?>
				</h4>
			</a>
			<?php render_header_mask(); ?>
		</div>
		<?php if ($show_action == true) : ?>
			<?php if (!empty($action['render'])) : ?>
				<?php $action['render']($action['args']); ?>
			<?php else : ?>
				<?php if (strcmp($show_action, 'no') != 0) : ?>
					<div class="action">
						<a href="<?php echo $action['link']; ?>" class="to-archive">
							<?php echo $action['title']; ?>
							<?php echo $action['icon']; ?>
						</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php
}
