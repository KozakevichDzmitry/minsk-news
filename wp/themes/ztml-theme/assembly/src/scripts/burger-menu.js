jQuery(document).ready(function ($) {
    const hamburgerMenuEl = $("#burger-nav");
    let hamburgerIsOpen = false;
    const getHeightHeaderMenu = () => {
        const headerMenu = document.querySelector('#header-stiky')
        const heightHeaderMenu = headerMenu.offsetTop + headerMenu.offsetHeight
        const heightWpadminbar = document.querySelector('#wpadminbar') ? document.querySelector('#wpadminbar').offsetHeight : 0;
        document.documentElement.style.setProperty('--heightHeaderMenu', `${heightHeaderMenu}px`)
        document.documentElement.style.setProperty('--heightWpadminbar', `${heightWpadminbar}px`)
    }
    $(window).resize(getHeightHeaderMenu);
    getHeightHeaderMenu()

    const closeHamburgerMenu = () => {
        hamburgerMenuEl.css("transform", "translateX(-1000%)");
        hamburgerMenuEl.css("visibility", "hidden");
        hamburgerIsOpen = false;
        $("body").css("overflow-y", "auto");
        $("html").css("overflow-y", "auto");
        $("body .spalshscreen").css("display", "none");
    };

    const openHamburgerMenu = () => {
        $("header.header .sub-nav #burger-nav").css({
            top: $("#header-stiky").height(),
        });
        hamburgerMenuEl.css("transform", "translateX(0)");
        hamburgerMenuEl.css("visibility", "visible");
        $("body").css("overflow-y", "hidden");
        $("html").css("overflow-y", "hidden");
        $("body .spalshscreen").css("display", "block");
        hamburgerIsOpen = true;
    };

    const closeSidebar = () => {
        $("#secondary").removeClass("active");
        $(".secondary-mobile .secondary-mobile-btn").removeClass("active");
        $("body").css("overflow-y", "auto");
        $("html").css("overflow-y", "auto");
        $(".footer .timeline").css('display', 'block')
        $("#spalshscreen").remove();
    };

    const openSidebar = () => {
        closeHamburgerMenu();
        $("#secondary").before("<div id='spalshscreen'></div>");
        $("#secondary").addClass("active");
        $(".secondary-mobile .secondary-mobile-btn").addClass("active");
        $("html").css("overflow-y", "hidden");
        $("body").css("overflow-y", "hidden");
        $(".footer .timeline").css('display', 'none')
    };

    const wpbarHeight =
        $("#wpadminbar").height() > 0 ? $("#wpadminbar").height() : 0;

    $("#secondary").stickySidebar({
        topSpacing: $("header").height() + wpbarHeight + 32,
        bottomSpacing: 80,
        containerSelector: ".main-container",
    });

    $(".secondary-mobile-btn").on("click", function (e) {
        e.stopPropagation();
        if ($("#secondary").hasClass("active")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    $(document).on("click", function (e) {
        e.stopPropagation();
        const $tg = $(e.target);

        const isHamburgerMenuBtn = Boolean($tg.closest("#burger-btn").length);
        const isHamburgerMenu = Boolean($tg.closest("#burger-nav").length);

        if (isHamburgerMenuBtn && !isHamburgerMenu) {
            if (hamburgerIsOpen) {
                closeHamburgerMenu();
            } else {
                closeSidebar();
                openHamburgerMenu();
            }
        } else if (
            !(isHamburgerMenuBtn || isHamburgerMenu) &&
            hamburgerIsOpen == true
        ) {
            closeHamburgerMenu();
        }
    });
});
