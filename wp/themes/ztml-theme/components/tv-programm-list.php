<?php

require_once(COMPONENTS_PATH . "icons/arrow-up-icon.php");

function render_tv_programm_list($tv_programms)
{
	$slice = floor(count($tv_programms) / 2);
	$left = array_slice($tv_programms, 0, $slice);
	$right = array_slice($tv_programms, $slice);
?>
	<div class="tv-programm-list-wrap">
		<div class="tv-programm-list">
			<?php foreach ($left as $tv) : ?>
				<?php render_tv_programm_list_item($tv); ?>
			<?php endforeach; ?>
		</div>
		<div class="tv-programm-list">
			<?php foreach ($right as $tv) : ?>
				<?php render_tv_programm_list_item($tv); ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php
}

function render_tv_programm_info_item($title, $times_string)
{
?>
	<div class="tv-programm-info">
		<div class="tv-programm-info__time-list">
			<span><?php echo $times_string; ?></span>
		</div>
		<div class="tv-programm-info__title">
			<span>
				<?php echo $title; ?>
			</span>
		</div>
	</div>
<?php
}

function render_tv_programm_list_item($tv)
{
?>
	<div class="tv-programm-item acc-item">
		<div class="tv-programm-item__header acc-btn">
			<div class="channel">
				<div class="channel__icon">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/tv-icons/' . $tv->img; ?>" alt="<?php echo $tv->title; ?>" />
				</div>
				<div class="channel__title">
					<span><?php echo $tv->title; ?></span>
				</div>
			</div>
			<button class="tv-programm-item__close-icon">
				<?php render_arrow_up_icon(); ?>
			</button>
		</div>
		<div class="tv-programm-item__content acc-content">
			<?php foreach ($tv->programms as $item) : ?>
				<?php render_tv_programm_info_item($item->title, $item->times_string); ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php
}
