jQuery(document).ready(function ($) {
	let searchbarIsOpen = false;

	const openSearchbar = () => {
		$("html").css("overflow-y", "hidden");
		$("body").css("overflow-y", "hidden");
		$("#search-bar").addClass("active");
		$("body .spalshscreen").css("display", "block");
		searchbarIsOpen = true;
	};

	const closeSearchbar = () => {
		$("body").css("overflow-y", "auto");
		$("html").css("overflow-y", "auto");
		$("#search-bar").removeClass("active");
		$("body .spalshscreen").css("display", "none");
		searchbarIsOpen = false;
	};

	$(document).on("keyup", function (e) {
		if (e.key == "Escape" && searchbarIsOpen) closeSearchbar();
		return;
	});
	$(".orig").on("keyup", (e) => {
		if(e.keycode == 13) e.preventDefault()
	});

	$(document).on("click", (e) => {
		e.stopPropagation();
		const $tg = $(e.target);

		const isSearchbarOpenBtn = Boolean($tg.closest("#search-btn").length);
		const isSearchbarCloseBtn = Boolean($tg.closest("#searchBtnClose").length);
		const isSearchbarResults= Boolean($tg.closest(".results").length);
		const isSearchbar = Boolean(
			$tg.closest(".header__search-bar.active").length
		);

		if (isSearchbarOpenBtn && searchbarIsOpen === false) {
			openSearchbar();
		}

		if (isSearchbarCloseBtn && searchbarIsOpen === true) {
			closeSearchbar();
		}

		if (
			!isSearchbarOpenBtn &&
			!isSearchbarCloseBtn &&
			!isSearchbar &&
			!isSearchbarResults &&
			searchbarIsOpen === true
		) {
			closeSearchbar();
		}
	});
});
