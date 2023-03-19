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
// jQuery(document).ready(function ($) {
// 	$(".district__slider").slickLightbox({
// 		itemSelector: ".slick-slide > a",
// 		background: "rgba(0, 0, 0, .7)",
// 	});
// 	$("#district .district__slider").slick({
// 		dots: true,
// 		infinite: true,
// 		speed: 300,
// 		slidesToShow: 4,
// 		slidesToScroll: 1,
// 		centerMode: true,
// 		centerPadding: "40px",
// 		responsive: [
// 			{
// 				breakpoint: 1100,
// 				settings: {
// 					dots: true,
// 					infinite: true,
// 					speed: 300,
// 					slidesToShow: 3,
// 					slidesToScroll: 1,
// 					centerMode: true,
// 					centerPadding: "30px",
// 				},
// 			},
// 			{
// 				breakpoint: 900,
// 				settings: {
// 					dots: true,
// 					infinite: true,
// 					speed: 300,
// 					slidesToShow: 2,
// 					slidesToScroll: 1,
// 					centerMode: true,
// 					centerPadding: "30px",
// 					arrows: false,
// 				},
// 			},
// 			{
// 				breakpoint: 767,
// 				settings: {
// 					dots: true,
// 					infinite: true,
// 					speed: 300,
// 					slidesToShow: 3,
// 					slidesToScroll: 1,
// 					centerMode: true,
// 					centerPadding: "30px",
// 					arrows: false,
// 				},
// 			},
// 			{
// 				breakpoint: 600,
// 				settings: {
// 					dots: true,
// 					infinite: true,
// 					speed: 300,
// 					slidesToShow: 2,
// 					slidesToScroll: 1,
// 					centerMode: true,
// 					centerPadding: "40px",
// 					arrows: false,
// 				},
// 			},
// 			{
// 				breakpoint: 450,
// 				settings: {
// 					dots: true,
// 					infinite: true,
// 					speed: 300,
// 					slidesToShow: 1,
// 					slidesToScroll: 1,
// 					centerMode: true,
// 					centerPadding: "40px",
// 					arrows: false,
// 				},
// 			},
// 		],
// 	});
// });
