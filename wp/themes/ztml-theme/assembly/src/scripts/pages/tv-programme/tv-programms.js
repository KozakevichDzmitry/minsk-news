jQuery(document).ready(function ($) {
    const daySelectList = $(".day-select-list");
    let indexActiveSlide = [].findIndex.call(daySelectList.find('.day-select-item'), item=> item.querySelector('button').classList.contains('selected'));
    const selectDayProgramme = (index) => {
        const list = $(".tv-day-programme");

        list.each(function (idx, item) {
            if (idx === index) {
                $(item).show();
            } else {
                $(item).hide();
            }
        });
    };

    selectDayProgramme(indexActiveSlide);

    daySelectList.click(function (e) {
        if ($(e.target).is("button")) {
            daySelectList.find("button").each(function (idx, btn) {
                if (btn === e.target) {
                    $(btn).addClass("selected");
                    $(btn).removeClass("no-selected");
                    indexActiveSlide = idx;
                    selectDayProgramme(idx);
                } else {
                    $(btn).addClass("no-selected");
                    $(btn).removeClass("selected");
                }
            });
        }
    });

    var slider,
        sliderBool = false,
        sliderSettings = {
            wrapperClass: 'day-select-list',
            slideClass: 'day-select-item',
            spaceBetween: 10,
            centeredSlides: true,
            slidesPerView: 'auto',
            initialSlide: indexActiveSlide||0,
            pagination: {
                el: '.day-select-list__pagination',
                type: 'bullets',
            },
        };

    function sliderInit() {
        if ($(window).width() <= 1000) {
            if (sliderBool === false) {
                slider = new Swiper('.tv-controls__day-select', sliderSettings);
                sliderBool = true;
            }
        } else {
            if (sliderBool) {
                slider.destroy();
                sliderBool = false;
            }

        }
    }

    // resize
    sliderInit();

    $(window).resize(function () {
        sliderInit();
    });

    const selectChannelMenu = $(".select-channel .channels-list");

    selectChannelMenu.click(function (e) {
        if ($(e.target)[0].tagName == "LI") {
            const selected = $(e.target).text().trim().toLowerCase();

            const progs = $(".tv-day-programme:visible .tv-programm-item.acc-item");

            progs.each(function (_, item) {
                const pg = $(item)
                    .find(".channel__title span")
                    .text()
                    .trim()
                    .toLowerCase();
                if (pg === selected) {
                    $(this).find(".acc-btn").click();
                }
            });
        }
    });
});
