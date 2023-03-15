jQuery(document).ready(function ($) {
    $(window).scroll(function () {
        var sticky = $("#header-stiky"),
            scroll = $(window).scrollTop();

        if (scroll >= 0) {
            sticky.addClass("is-sticky sticky");
        } else {
            sticky.removeClass("is-sticky sticky");
        }
    });
});

jQuery(document).ready(function ($) {
    $("#menu-burger-menyu .menu-item-has-children").on("click", (e) => {
        $(e.currentTarget).toggleClass("active");
        $(e.currentTarget).find(".sub-menu").toggle("slow");
        $(e.currentTarget).find("button").toggleClass("expand");
    });
});

jQuery(document).ready(function ($) {
    $("header.header .sub-nav #burger-nav").css({
        top: $("#header-stiky").height(),
    });
});