jQuery(document).ready(function ($) {

	new Swiper(".district-slider", {
		wrapperClass: 'district-slider__wrapper',
		slideClass: 'district-slider__item',
		loop: true,
		centeredSlides: true,
		speed: 300,
		slidesPerView: 2,
		spaceBetween: 10,
		pagination: {
			el: '.district-slider__pagination',
			type: 'bullets',
		},
		navigation: {
			nextEl: '.district-slider__arrow-next',
			prevEl: '.district-slider__arrow-prev',
		},
		breakpoints: {
			900: {
				centeredSlides: false,
				slidesPerView: 2,
				spaceBetween: 20,
			},
			1040: {
				centeredSlides: false,
				slidesPerView: 3,
				spaceBetween: 20,
			},
			1190: {
				centeredSlides: false,
				slidesPerView: 4,
				spaceBetween: 20,
			},
		},
	});
});
