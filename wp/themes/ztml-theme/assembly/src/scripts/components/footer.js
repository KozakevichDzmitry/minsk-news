jQuery(document).ready(function ($) {
    $(".minimize-bar").on("click", () => {
        $("footer .timeline").removeClass("minimize");
    });

    new IntersectionObserver(([obj]) => {
        if ($("footer .timeline").hasClass("minimize")) {
            $("footer .timeline").css("position", "fixed");

            if (obj.isIntersecting) {
                $("footer .timeline").addClass("inverted");
            } else {
                $("footer .timeline").removeClass("inverted");
            }
        } else {
            if (obj.isIntersecting) {
                $("footer .timeline").addClass("inverted");
                $("footer .timeline").css("position", "static");
            } else {
                $("footer .timeline").removeClass("inverted");
                $("footer .timeline").css("position", "fixed");
            }
        }
    }).observe(document.querySelector("footer.footer"));
});