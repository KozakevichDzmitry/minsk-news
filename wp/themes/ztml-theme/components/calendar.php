<?php

function render_calendar($args)
{
?>
	<div class="datepicker-toggle">
		<label for="<?php echo $args['id']; ?>">
			<span>Выбрать дату</span>
			<input type="text" id="<?php echo $args['id']; ?>" class="datepicker-input" value="<?php echo date('Y-m-d'); ?>" data-min-date="<?php echo $args['min_date']; ?>" data-max-date="<?php echo $args['max_date']; ?>" placeholder="">
		</label>
		<button class="datepicker-reset-button">x</button>
	</div>
<?php
}
