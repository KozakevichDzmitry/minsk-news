jQuery(document).ready(function ($) {
	$("#events .district__slider").slick({
		dots: true,
		infinite: false,
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
	$(function(){
		$('.zoom-img').click(function(event) {
		  var i_path = $(this).attr('src');
		  $('body').append('<div id="overlay"></div><div id="magnify"><img src="'+i_path+'"><div id="close-popup"><i></i></div></div>');
		  $('#magnify').css({
		   left: ($(document).width() - $('#magnify').outerWidth())/2,
		   // top: ($(document).height() - $('#magnify').outerHeight())/2 upd: 24.10.2016
				  top: ($(window).height() - $('#magnify').outerHeight())/2
		 });
		  $('#overlay, #magnify').fadeIn('fast');
		});
		
		$('body').on('click', '#close-popup, #overlay', function(event) {
		  event.preventDefault();
		  $('#overlay, #magnify').fadeOut('fast', function() {
			$('#close-popup, #magnify, #overlay').remove();
		  });
		});
	  });
});
