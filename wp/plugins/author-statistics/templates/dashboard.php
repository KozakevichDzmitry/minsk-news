<div class="wrap">
	<h1>Статистика по журналистам</h1>
	<div>
		<label for="fromDate">C:</label>
		<input name="fromDate" id="fromDate" type="date" value="<?php echo date('Y-m-d'); ?>">
		<label for="toDate">По:</label>
		<input name="toDate" id="toDate" type="date" value="<?php echo date('Y-m-d'); ?>">
		<input type="submit" id="getStatistic" value="Получить">
	</div>
	<div id="output_wrapper"></div>
</div>
<div class="clear"></div>
<style>
	#output_wrapper table {
		max-width: 450px;
		min-width: 350px;
		text-align: left;
		border: 1px solid #c1c1c1;
		margin-top: 10px;
		padding: 5px;
	}

	table td {
		padding: 5px;
		border: 1px solid #b9b9b99c;
	}
</style>