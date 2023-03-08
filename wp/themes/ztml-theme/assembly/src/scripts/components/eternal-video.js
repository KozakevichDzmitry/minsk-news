jQuery(document).ready(function ($) {
	let lastVideoPlayed = null;

	$(".video-preview .controls .play").on("click", function () {
		const videoContainer = $(this).closest(".video-preview");
		const videoEl = videoContainer.find("video")[0];

		if (videoEl.paused) {
			if (lastVideoPlayed) {
				lastVideoPlayed.find("video")[0].controls = false;
				lastVideoPlayed.find("video")[0].pause();
				lastVideoPlayed.find(".controls").show();
			}
			videoEl.addEventListener(
				"pause",
				() => {
					videoEl.controls = false;
					videoContainer.find(".controls").show();
				},
				{
					once: true,
				}
			);
			videoEl.controls = true;
			videoEl.play();
			videoContainer.find(".controls").hide();
			lastVideoPlayed = videoContainer;
		} else {
			videoEl.pause();
		}
	});
});
