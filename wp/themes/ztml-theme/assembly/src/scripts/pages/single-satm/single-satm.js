jQuery(document).ready(function ($) {
	if ($(window).width() <= 767) {
		$(".single-satm .satm-related").hide();
		$(".single-satm .main-single-satm").hide();

		const slider = $(".single-satm-slider");
		const initSlider = slider.slick({
			arrows: false,
			dots: true,
			infinite: false,
			adaptiveHeight: true,
			layzyLoad: true,
		});

		initSlider.on("edge", function (event, slick, direction) {
			if (direction === "right") {
				$.ajax({
					url: ajax.ajaxurl,
					type: "post",
					data: {
						action: "satmsingleload",
						type: "post",
						query_vars: "satm",
					},
					success: function (html) {
						initSlider.slick("removeSlide", null, null, true);
						initSlider.slick("slickAdd", html);
						initSlider.slick("slickGoTo", slick.slideCount - 1);
					},
				});
			} else {
				$.ajax({
					url: ajax.ajaxurl,
					type: "post",
					data: {
						action: "satmsingleload",
						type: "post",
						query_vars: "satm",
					},
					success: function (html) {
						initSlider.slick("removeSlide", null, null, true);
						initSlider.slick("slickAdd", html);
					},
				});
			}
		});

		$(".single-satm .single-satm-slider").show();
	}
});
