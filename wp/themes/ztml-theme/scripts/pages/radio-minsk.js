jQuery(document).ready(function ($) {
    $("#programs .programs-list .card-list").slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                },
            },
        ],
    });

    $("#team .team-list .card-list").slick({
        arrows: true,
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: "60px",
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                },
            },
        ],
    });
});

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