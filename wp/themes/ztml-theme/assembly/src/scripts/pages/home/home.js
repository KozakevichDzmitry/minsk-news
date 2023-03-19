jQuery(document).ready(function ($) {
	$.datepicker.setDefaults($.datepicker.regional.ru);

	let lastPost = document.querySelector(".long-news-list .timeline-main .news-template-line:last-child");

	$(lastPost).addClass("eof");

	let last_date = null;

	const resetCalendar = $(".datepicker-toggle .datepicker-reset-button");

	const dataRequest = {
		action: "main_timline_tape_load",
		load: 10,
		offset: 10,
		taxonomy: "news-list",
		field: "slug",
		terms: "feed",
	};

	const observer = new IntersectionObserver(
		([entry]) => {
			if (entry.isIntersecting) {
				ajaxRequest(last_date ? { date: last_date } : {}, (data) => {
					$(
						".long-news-list .timeline-main .news-template-line:last-child"
					).removeClass("eof");

					if (data) {
						updatePosts(observer, data);
					}
				});
			}
		},
		{
			root: null,
			rootMargin: "10px",
			threshold: 0.1,
		}
	);

	resetCalendar.on("click", () => {
		last_date = null;

		dataRequest.offset = 0;
		document.querySelector(".long-news-list .timeline-main").scrollTo({ top: 0, behavior: "smooth" });

		ajaxRequest({ date: null }, (data) => {
			resetCalendar.hide();
			$(".long-news-list .timeline-main").empty();

			if (data) {
				updatePosts(observer, data);
			}
		});
	});

	const ajaxRequest = (args, cb) =>
		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			data: { ...dataRequest, ...args },
			type: "POST",
			success: (data) => cb(data),
		});

	$("#datepicker-all-news").datepicker({
		showOn: "both",
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: $("#datepicker-all-news").data("min-date"),
		maxDate: $("#datepicker-all-news").data("max-date"),

		onSelect: (date) => {
			last_date = date;
			dataRequest.offset = 0;
			document
				.querySelector(".long-news-list .timeline-main")
				.scrollTo({ top: 0, behavior: "smooth" });

			ajaxRequest(
				{
					date,
				},
				(data) => {
					resetCalendar.show();

					$(".long-news-list .timeline-main").empty();

					if (data) {
						updatePosts(observer, data);
					}
				}
			);
		},
	});

	const updatePosts = (observer, posts) => {
		const dataEls = $(posts);

		$(dataEls[dataEls.length - 1]).addClass("eof");

		$(".long-news-list .timeline-main").append(dataEls);

		observer.unobserve(lastPost);

		lastPost = document.querySelector(
			".long-news-list .timeline-main .news-template-line.eof"
		);

		observer.observe(lastPost);

		dataRequest.offset += dataRequest.load;
	};

	observer.observe(lastPost);
});
jQuery(document).ready(function ($) {

	if ($('.swiper-container.two').length) new Swiper(".swiper-container.two", {
		clickable: true,
		effect: "coverflow",
		autoHeight: false,
		loop: false,
		centeredSlides: true,
		slidesPerView: 1,
		spaceBetween: 22,
		initialSlide: 3,
		pagination: {
			el: '.author_column__pagination',
			type: 'bullets',
		},
		coverflowEffect: {
			rotate: 0,
			stretch: 0,
			depth: 0,
			modifier: 1,
			slideShadows : true,
		},

		breakpoints: {
			576: {
				spaceBetween: 0,
				coverflowEffect: {
					rotate: 0, // Slide rotate in degrees
					stretch: 150, // Stretch space between slides (in px)
					depth: 50, // Depth offset in px (slides translate in Z axis)
					modifier: 1, // Effect multipler
					slideShadows : true, // Enables slides shadows
				},
				slidesPerView: 'auto',
			},
		},
	});
});
