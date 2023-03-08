jQuery(document).ready(function ($) {
	if($("#events .event_slider").length){
		$("#events .event_slider").slick({
			dots: true,
			infinite: true,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1360,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 1,
						infinite: true,
						dots: true,
					},
				},
				{
					breakpoint: 600,
					settings: {
						arrows: false,
						centerMode: true,
						centerPadding: '40px',
						infinite: true,
						slidesToShow: 1,
						slidesToScroll: 1,
					},
				},
			],
		});
	}
});