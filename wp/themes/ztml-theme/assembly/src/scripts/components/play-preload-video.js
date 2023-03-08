window.onload = function () {
	let contentBox = document.querySelector(".main-content");
	if (contentBox) contentBox.addEventListener("click", playVideo);

	function playVideo(e) {
		let card = e.target.closest(".card-item__preview");
		if (card) {
			let video = card.querySelector("video");
			if (video) {
				card.classList.toggle("video-active");
				if (card.classList.contains("video-active")) video.play();
				else video.pause();
			}
		}
	}
};
