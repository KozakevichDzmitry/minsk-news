jQuery(document).ready(function ($) {
	$.datepicker.setDefaults($.datepicker.regional.ru);

	let lastPost = document.querySelector(
		".long-news-list .timeline-main .news-template-line:last-child"
	);

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
		document
			.querySelector(".long-news-list .timeline-main")
			.scrollTo({ top: 0, behavior: "smooth" });

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
    const districtPreviewEl = $(".district-preview");
    const districtTabletEls = $(
        ".district-tablet-template .districts-list-container .district-item"
    );
    let currentSlideIndex = 0;
    if (districtPreviewEl.length && districtTabletEls.length) {

        const districtEls = districtPreviewEl.find(".district-item");

        districtPreviewEl.click((e) => {
			let target = $(e.target);
			let caption = target.closest(".district-item");

            if (caption.length > 0) {
                districtEls.removeClass("active");
                currentSlideIndex = caption.data("id");
                caption.addClass("active");

                districtTabletEls.removeClass("active");
                $(districtTabletEls[currentSlideIndex]).addClass("active");
            }
        });

        const sliderAdaptive = () => {
            if ($(window).width() < 768) {
                if ($(".district-preview").hasClass(".slick-initialized") == false) {
                    $(".district-preview").find(".district-item").addClass("active");
                    districtPreviewEl.not(".slick-initialized").slick({
                        slidesToShow: 1,
                        arrows: false,
                        dots: true,
                        arrows: true,
                        prevArrow: $("#js-features-arrows__prev"),
                        nextArrow: $("#js-features-arrows__next"),
                    });
                    districtPreviewEl.slick("slickGoTo", currentSlideIndex);
                    districtPreviewEl.on("afterChange", function (event, slick, nextSlide) {
                        $(districtTabletEls[currentSlideIndex]).removeClass("active");
                        currentSlideIndex = nextSlide;
                        $(districtTabletEls[currentSlideIndex]).addClass("active");
                    });
                }
            } else {
                if (districtPreviewEl.hasClass("slick-initialized")) {
                    districtPreviewEl.slick("unslick");
                }

                districtPreviewEl.find(".district-item").removeClass("active");
                $(districtPreviewEl.find(".district-item")[currentSlideIndex]).addClass(
                    "active"
                );
            }
        };

        $(".districts-list ul").on("click", (e) => {
            let target = $(e.target);
			let caption = target.closest(".district-caption");

            if (caption.length > 0) {
                $(districtTabletEls[currentSlideIndex]).removeClass("active");
                currentSlideIndex = caption.data("id");
                $(districtTabletEls[currentSlideIndex]).addClass("active");
            }
        });

        sliderAdaptive();
        $(window).on("resize", sliderAdaptive);
    }

});
