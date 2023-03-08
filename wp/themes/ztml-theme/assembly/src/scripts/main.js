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
    const sidebarLabel = $("#sidebar-label");
    const sidebar = $("#sidebar-wrapper");

    let sidebarOn = false;

    sidebarLabel.on("click", function (e) {
        sidebarOn = !sidebarOn;
        sidebarOn ? sidebar.addClass("active") : sidebar.removeClass("active");
        sidebar.css("right", sidebarOn ? "0px" : "-320px");
    });
});

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

jQuery(document).ready(function ($) {
    $("#menu-burger-menyu .menu-item-has-children").on("click", (e) => {
        $(e.currentTarget).find(".sub-menu").toggle("slow");
        $(e.currentTarget).find("button").toggleClass("expand");
    });
});

jQuery(document).ready(function ($) {
    $("header.header .sub-nav #burger-nav").css({
        top: $("#header-stiky").height(),
    });

});

window.addEventListener('DOMContentLoaded', function (e) {
    function resizaIframe() {
        let frame = document.querySelectorAll(".page-content iframe:not(.instagram-media)");
        frame.forEach(elem => {
            let width = Math.max(elem.scrollWidth, elem.offsetWidth, elem.clientWidth);
            elem.style.height = (width / 16) * 9 + 'px';
        })

    }
    window.addEventListener("resize", resizaIframe);
    resizaIframe()
})
