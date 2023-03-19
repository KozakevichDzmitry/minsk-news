window.onload = () => {
    new Swiper('.programs-list', {
        wrapperClass: 'programs-wrapper',
        slideClass: 'program-card',
        speed: 300,
        slidesPerView: 1,
        centeredSlides: true,
        grabCursor: true,
        pagination: {
            el: '.programs-list__pagination',
            type: 'bullets',
        },
        navigation: {
            nextEl: '.programs-arrow-next',
            prevEl: '.programs-arrow-prev',
        },
        breakpoints: {
            680: {
                slidesPerView: 2,
                spaceBetween: 30,
                centeredSlides: false,

            },
            768: {
                slidesPerView: 1,
                centeredSlides: true,

            },
            959: {
                slidesPerView: 2,
                spaceBetween: 30,
                centeredSlides: false,
            },
        }
    });
    new Swiper('.team-list', {
        wrapperClass: 'team-wrapper',
        slideClass: 'team-card',
        speed: 300,
        slidesPerView: 1,
        spaceBetween: 20,
        centeredSlides: true,
        grabCursor: true,
        pagination: {
            el: '.team-list__pagination',
            type: 'bullets',
        },
        navigation: {
            nextEl: '.team-arrow-next',
            prevEl: '.team-arrow-prev',
        },
        breakpoints: {
            681: {
                slidesPerView: 2,
                centeredSlides: false,
            },
            769: {
                slidesPerView: 1,
                centeredSlides: true,
            },
            980: {
                slidesPerView: 2,
                centeredSlides: false,
            },
            1100: {
                slidesPerView: 3,
                centeredSlides: true,
                initialSlide: 1,
            },
        }
    });
}

jQuery(document).ready(function ($) {
    const erp = $("#radio-min-player");
    const mobileRadio = $("#mobile-radio-min-player");
    const onPlayer = (playerState, elem) => {
        elem.click(() => {
            const img = elem[0].querySelector('img')
            const src = img.dataset.src
            if (playerState.isPaused) {
                $(playerState.audioSrc).trigger("play");
                img.dataset.src = img.src
                img.src = src
                playerState.isPaused = false;
            } else {
                $(playerState.audioSrc).trigger("pause");
                img.dataset.src = img.src
                img.src = src
                playerState.isPaused = true;
            }
        });
    }

    if (erp) {
        const playerState = {
            isPaused: true,
            isLoaded: false,
            audioSrc: $("#radio_minsk")[0],
        };
        onPlayer(playerState, erp)
    }
    if (mobileRadio) {
        const mobPlayerState = {
            isPaused: true,
            isLoaded: false,
            audioSrc: $("#mobile_radio_minsk")[0],
        };
        onPlayer(mobPlayerState, mobileRadio)
    }
});
jQuery(document).ready(function ($) {
    $(function () {
        var style = getComputedStyle(document.body)
        var marginTop = (parseInt(style.getPropertyValue('--heightHeaderMenu')) || 0) + (parseInt(style.getPropertyValue('--heightWpadminbar') || 0))
        if ($('.topic-minibar__title').length) {
            $('.topic-minibar__title').on('click', function (e) {
                e.preventDefault();
                var id = $(this).attr('href');
                id = id.split("#");
                id = '#' + id[id.length - 1]

                $('html,body').stop().animate({scrollTop: $(id).offset().top - marginTop}, 500);
            });
        }
    });
});