jQuery(document).ready(function ($) {
    const districtPreviewEl = $(".district-preview");
    const $districtTabletEls = $(
        ".district-tablet-template .districts-list-container .district-item"
    );
    let currentSlideIndex = 0;
    if (districtPreviewEl.length && $districtTabletEls.length) {
        const alignHeightDistricts = () => {
            let maxH = 0;
            $(".district-preview>.district-item > div").each(function () {
                if ($(this).height() > maxH) {
                    maxH = $(this).height();
                }
            });

            $(".district-preview>.district-item").each(function () {
                $(this).height(maxH < 100 ? 550 : maxH);
            });
        };

        const districtEls = districtPreviewEl.find(".district-item");

        districtPreviewEl.click((e) => {
            alignHeightDistricts();
            $target = $(e.target);
            $caption = $target.closest(".district-item");

            if ($caption.length > 0) {
                districtEls.removeClass("active");
                currentSlideIndex = $caption.data("id");
                $caption.addClass("active");

                $districtTabletEls.removeClass("active");
                $($districtTabletEls[currentSlideIndex]).addClass("active");
            }
            alignHeightDistricts();
        });

        const sliderAdaptive = () => {
            if ($(window).width() < 768) {
                if ($(".district-preview").hasClass(".slick-initialized") == false) {
                    $(".district-preview").find(".district-item").addClass("active");
                    districtPreviewEl.not(".slick-initialized").slick({
                        slidesToShow: 1,
                        arrows: false,
                        dots: true,
                        arrows: true,
                        prevArrow: $("#js-features-arrows__prev"),
                        nextArrow: $("#js-features-arrows__next"),
                    });
                    districtPreviewEl.slick("slickGoTo", currentSlideIndex);
                    districtPreviewEl.on("afterChange", function (event, slick, nextSlide) {
                        $($districtTabletEls[currentSlideIndex]).removeClass("active");
                        currentSlideIndex = nextSlide;
                        $($districtTabletEls[currentSlideIndex]).addClass("active");
                    });
                }
            } else {
                if (districtPreviewEl.hasClass("slick-initialized")) {
                    districtPreviewEl.slick("unslick");
                }

                districtPreviewEl.find(".district-item").removeClass("active");
                $(districtPreviewEl.find(".district-item")[currentSlideIndex]).addClass(
                    "active"
                );
            }
            alignHeightDistricts();
        };

        $(".districts-list ul").on("click", (e) => {
            $target = $(e.target);
            $caption = $target.closest(".district-caption");

            if ($caption.length > 0) {
                $($districtTabletEls[currentSlideIndex]).removeClass("active");
                currentSlideIndex = $caption.data("id");
                $($districtTabletEls[currentSlideIndex]).addClass("active");
            }
            alignHeightDistricts();
        });

        sliderAdaptive();
        $(window).on("resize", sliderAdaptive);
    }

});