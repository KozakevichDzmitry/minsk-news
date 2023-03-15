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

jQuery(document).ready(function ($) {
    if ($('.swiper-container.two').length) new Swiper(".swiper-container.two", {
        pagination: ".swiper-pagination",
        paginationClickable: true,
        clickable: true,
        paginationBulletRender: function (index, className) {
            return '<span class="swiper-pagination-bullet"></span>';
        },
        effect: "coverflow",
        autoHeight: false,
        loop: false,
        centeredSlides: true,
        slidesPerView: 'auto',
        spaceBetween: 0,
        initialSlide: 2,
        coverflow: {
            rotate: 0,
            stretch: 100,
            depth: 0,
            modifier: 1.5,
            slideShadows: false,
        },
        breakpoints: {
            576: {
                spaceBetween: 700,
            },
            768: {
                initialSlide: 1,
                spaceBetween: 0,
            },
        },
    });
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

jQuery(document).ready(function ($) {
    let inputFile = $('.input-file input[type=file]')
    if (inputFile.length) {
        $(inputFile).on('change', function () {
            let file = this.files[0];
            $(this).closest('.input-file').find('.input-file-text').html(file.name);
        });
    }
})
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
