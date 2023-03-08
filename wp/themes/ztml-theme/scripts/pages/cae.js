jQuery(document).ready(function ($) {
	const cardWrapperEl = $(".cae .cards-list");
	const getTime = (duration) => {
		const minutes = Math.floor(duration / 60);
		const seconds = parseInt(duration - minutes * 60);
		return {
			minutes: minutes < 10 ? "0" + minutes : minutes,
			seconds: seconds < 10 ? "0" + seconds : seconds,
		};
	};
	const activePlayers = [];

	function handleInputChangeEl(el) {
		const min = el.min;
		const max = el.max;
		const val = el.value;
		el.style.backgroundSize = ((val - min) * 100) / (max - min) + "% 100%";
	}

	$(".cae .cards-list .mn-player").each(function (_, item) {
		$(item)
			.find("input[type='range']")
			.each(function (idx, input) {
				handleInputChangeEl(input);
			});
		const audio = $(item).find("audio")[0];
		const timer = $(item).find("#time")[0];

		audio.addEventListener(
			"canplaythrough",
			() => {
				const t0 = getTime(audio.duration);
				timer.textContent = `00:00 \u2014 ${t0.minutes || "00"}:${
					t0.seconds || "00"
				}`;
			},
			{ once: true }
		);
	});

	const initNewPlayer = (args) => {
		const newPlayer = args;
		activePlayers.push(newPlayer);
		return newPlayer;
	};

	const findActivePlayer = (el) => activePlayers.find((item) => el === item.el);

	const stopOthersAudioPlayers = (player) => {
		activePlayers.forEach((item) => {
			if (item.el != player.el) {
				$(item.el).find(".cae_play_icon").css("display", "inline-block");
				$(item.el).find(".cae_pause_icon").css("display", "none");
				item.isPlay = false;
				item.audio.pause();
				clearInterval(item.audioTrackInterval);
			}
		});
	};

	const PLAY_TYPE_EVENT = "PLAY_TYPE_EVENT";
	const VOLUME_TYPE_EVENT = "VOLUME_TYPE_EVENT";
	const TRACK_TYPE_EVENT = "TRACK_TYPE_EVENT";
	const INIT_TYPE_EVENT = "INIT_TYPE_EVENT";

	const getEventType = (targetEl) => {
		const isPlayButton = $(
			targetEl.closest(".player-controls__play-btn")[0]
		).hasClass("player-controls__play-btn");
		const isVolumeEl = $(
			targetEl.closest(".player-controls__volume")[0]
		).hasClass("player-controls__volume");

		const isTrackBarEl = $(
			targetEl.closest(".mn-player__track-bar")[0]
		).hasClass("mn-player__track-bar");

		if (isPlayButton) return PLAY_TYPE_EVENT;
		if (isVolumeEl) return VOLUME_TYPE_EVENT;
		if (isTrackBarEl) return TRACK_TYPE_EVENT;
		return INIT_TYPE_EVENT;
	};



	const tickPlayerTime = (pl, t0, intervalId) => {
		const { audio, trackBar, timer } = pl;
		const t1 = getTime(audio.currentTime);

		if (audio.currentTime >= audio.duration) {
			clearInterval(intervalId);
			audio.currentTime = 0;
			audio.pause();
		} else {
			trackBar.value = Math.floor((audio.currentTime / audio.duration) * 100);
			timer.textContent = `${t1.minutes}:${t1.seconds} - ${
				t0.minutes || "00"
			}:${t0.seconds || "00"}`;
		}

		handleInputChangeEl(trackBar);
		handleInputChangeEl(audio);
	};

	cardWrapperEl.click((e) => {
		const targetEl = $(e.target);

		if (targetEl.closest(".card-item__footer").length) {
			const description = targetEl
				.closest(".card-item")
				.find(".card-item__description");

			description.hasClass("nowrap")
				? description.removeClass("nowrap")
				: description.addClass("nowrap");
		}

		const tempPlayer = targetEl.closest(".mn-player");

		if (!tempPlayer.length) return;

		let player = findActivePlayer(tempPlayer[0]);

		if (!player) {
			const playButtonEl = tempPlayer.find(".player-controls__play-btn");

			const volumeRangeEl = tempPlayer.find(
				".player-controls__volume input[type='range']"
			);

			const timeTrackRangeEl = tempPlayer.find(
				".mn-player__track-bar input[type='range']"
			);

			const timerEl = tempPlayer.find("#time");

			const audioSrcEl = tempPlayer.find("audio");

			player = initNewPlayer({
				el: tempPlayer[0],
				audio: audioSrcEl[0],
				time: timeTrackRangeEl[0],
				timer: timerEl[0],
				playBtn: playButtonEl[0],
				trackBar: timeTrackRangeEl[0],
				volume: volumeRangeEl[0],
				audioTrackInterval: null,
				isPlay: false,
			});
		}

		handleInputChangeEl(player.volume);
		handleInputChangeEl(player.trackBar);

		const eventType = getEventType(targetEl);

		if (eventType === PLAY_TYPE_EVENT) {
			stopOthersAudioPlayers(player);
			player.isPlay = !player.isPlay;

			if (player.isPlay) {
				const t0 = getTime(player.audio.duration);
				player.audio.play();
				$(player.playBtn).find(".cae_play_icon").css("display", "none");
				$(player.playBtn)
					.find(".cae_pause_icon")
					.css("display", "inline-block");
				player.audioTrackInterval = setInterval(
					() => tickPlayerTime(player, t0, player.audioTrackInterval),
					1000
				);
			}

			if (!player.isPlay) {
				player.audio.pause();
				$(player.playBtn).find(".cae_play_icon").css("display", "inline-block");
				$(player.playBtn).find(".cae_pause_icon").css("display", "none");
				clearInterval(player.audioTrackInterval);
			}
		}

		if (eventType === VOLUME_TYPE_EVENT) {
			player.audio.volume = player.volume.value / 100;
			handleInputChangeEl(player.volume);
		}

		if (eventType === TRACK_TYPE_EVENT) {
			player.audio.play();
			player.audio.currentTime =
				(player.trackBar.value * player.audio.duration) / 100;
			player.audio.pause();
			handleInputChangeEl(player.trackBar);
		}
	});
});

jQuery(document).ready(function ($) {
	const loadBtnEl = $(".load-moree-btn");

	const ajaxRequest = (args, cb) =>
		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			data: { ...dataRequest, ...args },
			type: "POST",
			success: (data) => cb(data),
		});

	$.datepicker.setDefaults($.datepicker.regional.ru);

	const resetCalendar = $(".datepicker-toggle .datepicker-reset-button");

	let last_date = null;

	const dataRequest = {
		action: "taxonomy_cae_load",
		load: 27,
		offset: 27,
		post_type: "cae",
	};

	resetCalendar.on("click", () => {
		last_date = null;

		dataRequest.offset = 0;
		ajaxRequest({ date: null }, (data) => {
			resetCalendar.hide();

			if (data) {
				const { posts, count } = JSON.parse(data);
				if (count <= dataRequest.offset + dataRequest.load) {
					loadBtnEl.hide();
				} else {
					loadBtnEl.show();
				}

				$(".main-content .cards-list").empty();
				$(".main-content .cards-list").append(posts);

				dataRequest.offset += dataRequest.load;
				$(".load-moree-btn button").attr("data-all-posts", count);
			}
		});
	});

	loadBtnEl.on("click", () => {
		loadBtnEl.find("button").text("Загрузка...");

		ajaxRequest(last_date ? { date: last_date } : {}, (data) => {
			if (data) {
				const { posts, count } = JSON.parse(data);

				if (count <= dataRequest.offset + dataRequest.load) {
					loadBtnEl.hide();
				} else {
					loadBtnEl.show();
				}

				$(".main-content .cards-list").append(posts);
				dataRequest.offset += dataRequest.load;
				$(".load-moree-btn button").attr("data-all-posts", count);

				loadBtnEl.find("button").text("Показать еще");
			}
		});
	});

	$("#datepicker-take-actions-template").datepicker({
		showOn: "both",
		changeYear: true,
		changeMonth: true,
		dateFormat: "yy-mm-dd",
		minDate: $("#datepicker-take-actions-template").data("min-date"),
		maxDate: $("#datepicker-take-actions-template").data("max-date"),

		onSelect: (date) => {
			last_date = date;
			dataRequest.offset = 0;
			ajaxRequest(
				{
					date,
				},
				(data) => {
					const { posts, count } = JSON.parse(data);
					resetCalendar.show();

					if (count <= dataRequest.offset + dataRequest.load) {
						$(".load-moree-btn").hide();
					} else {
						$(".load-moree-btn").show();
					}

					$(".main-content .cards-list").empty();
					$(".main-content .cards-list").append(posts);

					dataRequest.offset += dataRequest.load;
					$(".load-moree-btn button").attr("data-all-posts", count);
				}
			);
		},
	});
});
