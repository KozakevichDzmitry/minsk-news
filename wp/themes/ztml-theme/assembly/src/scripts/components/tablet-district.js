jQuery(document).ready(function ($) {

	let currentSlideIndex = 0;

	let districtEls = $(
		".district-tablet-template .districts-list-container .district-item"
	);

	$(".districts-list ul").on("click", (e) => {
		let target = $(e.target);
		let caption = target.closest(".district-caption");

		if (caption.length > 0) {
			$(districtEls[currentSlideIndex]).removeClass("active");
			currentSlideIndex = caption.data("id");
			$(districtEls[currentSlideIndex]).addClass("active");
		}
	});
});
