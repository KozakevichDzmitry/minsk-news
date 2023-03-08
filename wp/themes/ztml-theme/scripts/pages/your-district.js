jQuery(document).ready(function ($) {
	const districtPreviewEl = $(".district-preview");

	const alignHeightDistricts = () => {
		let maxH = 0;
		$(".district-preview>.district-item").each(function () {
			if ($(this).height() > maxH) {
				maxH = $(this).height();
			}
		});

		$(".district-preview>.district-item").each(function () {
			$(this).height(maxH);
		});
	};

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
			}
		} else {
			if (districtPreviewEl.hasClass("slick-initialized")) {
				districtPreviewEl.slick("unslick");
			}

			const districtEls = districtPreviewEl.find(".district-item");

			districtPreviewEl.click((e) => {
				if ($(e.target).hasClass("district-item")) {
					districtEls.each((idx, item) => $(item).removeClass("active"));
					$(e.target).addClass("active");
				} else if ($(e.target).hasClass("district-preview__title")) {
					districtEls.each((idx, item) => $(item).removeClass("active"));
					const el = e.target.parentNode.parentNode;
					$(el).addClass("active");
				}
			});

			alignHeightDistricts();

			districtPreviewEl.find(".district-item").removeClass("active");
			$(districtPreviewEl.find(".district-item")[0]).addClass("active");
		}
	};

	sliderAdaptive();
	$(window).on("resize", sliderAdaptive);
});
