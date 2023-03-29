jQuery(document).ready(function ($) {
    const scrollPost = $('.whole-post-scroll');
    $(scrollPost).scroll(function () {
        if ($(this).height() + $(this).scrollTop() >= this.scrollHeight) {
            // $(this).css('');
        }
    })
});
