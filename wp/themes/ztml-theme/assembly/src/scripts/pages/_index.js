jQuery(document).ready(function ($) {
	const swiper = new Swiper(".swiper-container.two", {
		pagination: false,
		paginationClickable: true,
		effect: "coverflow",
		autoHeight: false,
		loop: true,
		centeredSlides: true,
		slidesPerView: "auto",
		coverflow: {
			rotate: 0,
			stretch: 100,
			depth: 0,
			modifier: 1.5,
			slideShadows: false,
		},
	});
});

function districtSliderAdaptive($) {
	let init = false;

	$(".district-preview").on("init reinit", function () {
		init = true;
	});

	$(".district-item").each(function () {
		$(this).addClass("active");
	});
	if ($(window).width() < 1190) {
		$(".district-preview").slick({
			slidesToShow: 5,
			arrows: false,
			// variableWidth: true,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						arrows: false,
						dots: true
					},
				},
			],
		});
	} else {
		$(".district-item").each(function () {
			$(this).removeClass("active");
		});
		if (init === true) {
			$(".district-preview").slick("unslick");
		}
	}
}

function alignHeightDistricts($) {
	let maxH = 0;
	$(".district-preview>.district-item").each(function () {
		if ($(this).height() > maxH) {
			maxH = $(this).height();
		}
	});

	$(".district-preview>.district-item").each(function () {
		$(this).height(maxH);
	});
}

jQuery(document).ready(function ($) {
	const districtPreviewEl = $(".district-preview");
	const districtEls = districtPreviewEl.find(".district-item");

	districtPreviewEl.click((e) => {
		if ($(e.target).hasClass("district-item")) {
			districtEls.each((idx, item) => $(item).removeClass("active"));
			$(e.target).addClass("active");
		}
	});

	alignHeightDistricts($);
	districtSliderAdaptive($);

	$(window).on('resize',function () {
		districtSliderAdaptive($);
	});
});
