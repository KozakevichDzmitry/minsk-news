jQuery(document).ready(function ($) {
    $(".managment-list .mob-get-more").on("click", function functionName() {
        more_block = $(this).prev();
        if (more_block.hasClass("active")) {
            more_block.removeClass("active");
            $(this).text("Читать все");
        } else {
            more_block.addClass("active");
            $(this).text("Скрыть");
        }
    });
});