import '../../components/category-slider.js'
jQuery(document).ready(function ($) {
	const loadBtnEl = $(".load-moree-btn");

	const ajaxRequest = (args, cb) =>
		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			data: { ...dataRequest, ...args },
			type: "POST",
			success: (data) => cb(data),
		});

	$.datepicker.setDefaults($.datepicker.regional.ru);

	const resetCalendar = $(".datepicker-toggle .datepicker-reset-button");

	let last_date = null;

	const dataRequest = {
		action: "news_posts_load",
		load: 27,
		offset: 27,
	};

	resetCalendar.on("click", () => {
		last_date = null;

		dataRequest.offset = 0;
		ajaxRequest({ date: null }, (data) => {
			resetCalendar.hide();

			if (data) {
				const { posts, count } = JSON.parse(data);
				if (count <= dataRequest.offset + dataRequest.load) {
					loadBtnEl.hide();
				} else {
					loadBtnEl.show();
				}

				$(".main-content .ta-list").empty();
				$(".main-content .ta-list").append(posts);

				dataRequest.offset += dataRequest.load;
				$(".load-moree-btn button").attr("data-all-posts", count);
			}
		});
	});

	loadBtnEl.on("click", () => {
		loadBtnEl.find("button").text("Загрузка...");

		ajaxRequest(last_date ? { date: last_date } : {}, (data) => {
			if (data) {
				const { posts, count } = JSON.parse(data);

				if (count <= dataRequest.offset + dataRequest.load) {
					loadBtnEl.hide();
				} else {
					loadBtnEl.show();
				}

				$(".main-content .ta-list").append(posts);
				dataRequest.offset += dataRequest.load;
				$(".load-moree-btn button").attr("data-all-posts", count);

				loadBtnEl.find("button").text("Показать еще");
			}
		});
	});

	$("#datepicker-all-news-template").datepicker({
		showOn: "both",
		changeYear: true,
		changeMonth: true,
		dateFormat: "yy-mm-dd",
		minDate: $("#datepicker-all-news-template").data("min-date"),
		maxDate: $("#datepicker-all-news-template").data("max-date"),

		onSelect: (date) => {
			last_date = date;
			dataRequest.offset = 0;
			ajaxRequest(
				{
					date,
				},
				(data) => {
					const { posts, count } = JSON.parse(data);
					resetCalendar.show();

					if (count <= dataRequest.offset + dataRequest.load) {
						$(".load-moree-btn").hide();
					} else {
						$(".load-moree-btn").show();
					}

					$(".main-content .ta-list").empty();
					$(".main-content .ta-list").append(posts);

					dataRequest.offset += dataRequest.load;
					$(".load-moree-btn button").attr("data-all-posts", count);
				}
			);
		},
	});
});
