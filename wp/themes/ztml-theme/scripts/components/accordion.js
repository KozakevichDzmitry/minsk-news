jQuery(document).ready(function ($) {

    // Responsive Table
    if ($('.page-content') !== false) {
        $('.page-content table').each(function(){
            $(this).wrap('<div class="responsive-table-wrap">'); 
        });
    }

    // Accordion
    const handle=function (e) {
        e.preventDefault();
        if ($(this).parent().hasClass('active') == false) {
            $('.acc-item').each(function () {
                $(this).find('.acc-content').slideUp();
                $(this).removeClass('active');
            });
            $(this).parent().find('.acc-content').slideDown();
            $(this).parent().addClass('active');
            $('html, body').animate({
                scrollTop: $(this).parent().offset().top - ($(window).height() * 0.25),
            }, 400);
        } else {
            $(this).parent().find('.acc-content').slideUp();
            $(this).parent().removeClass('active');
        }
    }
    $('.acc-btn').click(handle);
});