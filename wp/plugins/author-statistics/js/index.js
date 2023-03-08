jQuery(document).ready(function ($) {
	const comparator = (a, b) => {
		if (+a.count < +b.count) {
			return 1;
		}
		if (+a.count > +b.count) {
			return -1;
		}
		return 0;
	};

	$("#getStatistic").click(function (e) {
		e.preventDefault();

		const reqData = {
			action: "get_statistics_handler",
			fromDate: $("#fromDate").val(),
			toDate: $("#toDate").val(),
		};

		$("#getStatistic").val("Загрузка...");

		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			data: reqData,
			type: "POST",
			success: (res) => {
				const sortedList = JSON.parse(res).sort(comparator);

				const table = document.createElement("table");

				const fragment = document.createDocumentFragment();

				sortedList.forEach((item) => {
					const row = document.createElement("tr");

					const valueDisplayName = document.createElement("td");
					valueDisplayName.textContent = item.display_name;

					const valueCount = document.createElement("td");
					valueCount.textContent = item.count;

					row.appendChild(valueDisplayName);
					row.appendChild(valueCount);

					fragment.appendChild(row);
				});

				table.appendChild(fragment);

				document.getElementById("output_wrapper").appendChild(table);
				$("#getStatistic").val("Получить");
			},
		});
	});
});
