jQuery(document).ready(function ($) {
	$.datepicker.setDefaults($.datepicker.regional.ru);
	$("#datepicker").datepicker({
		showOn: "both",
		changeYear: true,
	});
});
