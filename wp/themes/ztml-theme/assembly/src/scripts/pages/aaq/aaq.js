
window.onload=()=>{
	new Swiper('.aaq-questions', {
		speed: 400,
		spaceBetween: 30,
		wrapperClass: 'aaq-question-list',
		slideClass: 'aaq-question-list-item',
		navigation: {
			nextEl: '.slick-next',
			prevEl: '.slick-prev',
		},
		pagination: {
			el: '.slick-dots',
			type: 'bullets',
		},
		breakpoints: {
			// when window width is >= 950
			950: {
				slidesPerView: 2,
			},
			769: {
				slidesPerView: 1,
			},
			600: {
				slidesPerView: 2,
			},
			360: {
				slidesPerView: 1,
			},
		}
	});
};

// jQuery(document).ready(function ($) {
// 	$(".aaq .aaq-question-list").slick({
// 		dots: true,
// 		infinite: false,
// 		speed: 300,
// 		slidesToShow: 2,
// 		slidesToScroll: 1,
// 		responsive: [
// 			{
// 				breakpoint: 1024,
// 				settings: {
// 					slidesToShow: 1,
// 					slidesToScroll: 1,
// 					infinite: true,
// 					dots: true,
// 				},
// 			},
// 			{
// 				breakpoint: 768,
// 				settings: {
// 					slidesToShow: 2,
// 					arrows: false,
// 				},
// 			},
// 			{
// 				breakpoint: 600,
// 				settings: {
// 					slidesToShow: 1,
// 					slidesToScroll: 1,
// 					arrows: false,
// 				},
// 			},
// 			{
// 				breakpoint: 480,
// 				settings: {
// 					slidesToShow: 1,
// 					slidesToScroll: 1,
// 					arrows: false,
// 				},
// 			},
// 		],
// 	});
// });
