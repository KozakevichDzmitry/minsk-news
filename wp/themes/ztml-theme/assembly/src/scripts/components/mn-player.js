// document.addEventListener("DOMContentLoaded", function (event) {
// 	const getTime = (duration) => {
// 		const minutes = Math.floor(duration / 60);
// 		const seconds = parseInt(duration - minutes * 60);
//
// 		return {
// 			minutes: minutes < 10 ? "0" + minutes : minutes,
// 			seconds: seconds < 10 ? "0" + seconds : seconds,
// 		};
// 	};
//
// 	// const audio = document.getElementById("audio");
// 	const time = document.getElementById("time");
// 	const t0 = getTime(audio.duration);
// 	time.textContent = `00:00 \u2014 ${t0.minutes || "00"}:${t0.seconds || "00"}`;
// 	const trackBar = document.getElementById("trackBar");
// 	const volume = document.getElementById("volume");
// 	document.getElementById("playBtn").addEventListener("click", () => {
// 		audio.play();
// 		audio.volume = 0
// 		setInterval(() => {
// 			const t1 = getTime(audio.currentTime);
// 			time.textContent = `${t1.minutes}:${t1.seconds} - ${t0.minutes || "00"}:${
// 				t0.seconds || "00"
// 			}`;
// 			trackBar.value = Math.floor((audio.currentTime / audio.duration) * 100);
// 			handleInputChangeEl(trackBar);
// 		}, 1000);
// 	});
// 	volume.addEventListener("input", (e) => {
// 		audio.volume = e.currentTarget.value / 100;
// 	});
// 	trackBar.addEventListener("input", (e) => {
// 		audio.currentTime = (trackBar.value * audio.duration) / 100;
// 	});
// 	const rangeInputs = document.querySelectorAll('input[type="range"]');
// 	function handleInputChange(e) {
// 		let target = e.target;
// 		if (e.target.type !== "range") {
// 			target = document.getElementById("range");
// 		}
// 		const min = target.min;
// 		const max = target.max;
// 		const val = target.value;
// 		target.style.backgroundSize = ((val - min) * 100) / (max - min) + "% 100%";
// 	}
// 	function handleInputChangeEl(el) {
// 		const min = el.min;
// 		const max = el.max;
// 		const val = el.value;
// 		el.style.backgroundSize = ((val - min) * 100) / (max - min) + "% 100%";
// 	}
// 	rangeInputs.forEach((input) => {
// 		input.addEventListener("input", handleInputChange);
// 		handleInputChangeEl(input);
// 	});
// });
