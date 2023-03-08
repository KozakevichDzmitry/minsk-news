jQuery(document).ready(function ($) {
    const erp = $(".erp-scn");
    if (erp.length > 0) {
        const playerState = {
            isPaused: true,
            isLoaded: false,
            audioSrc: erp.find("#ext_radio_minsk")[0],
        };

        erp.find(".erp-scn__player-btn").click(() => {
            if (playerState.isPaused) {
                erp.find(".play_icon").css("display", "none");
                erp.find(".pause_icon").css("display", "inline-block");
                $(playerState.audioSrc).trigger("play");
                playerState.isPaused = false;
            } else {
                erp.find(".play_icon").css("display", "inline-block");
                erp.find(".pause_icon").css("display", "none");
                $(playerState.audioSrc).trigger("pause");
                playerState.isPaused = true;
            }
        });

    }
});

function imgsrc(img) {
    if ($(img).attr("src") == "img/plus.gif") $(img).attr("src", "img/minus.gif");
    else $(img).attr("src", "img/plus.gif");
}
