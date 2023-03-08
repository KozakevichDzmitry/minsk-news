// jQuery(document).ready(function ($) {
// 	$(".diff-image").each(function () {
// 		const input = $(this).find(".diff-image-control");
// 		input.on("input", () => {
// 			$(this).find(".compare").css("width", input.val());
// 		});
// 		input.on("change", () => {
// 			$(this).find(".compare").css("width", input.val());
// 		});
// 	});
// });

// Code By Webdevtrick ( https://webdevtrick.com )
function beforeAfter() {
	document.getElementById("compare").style.width =
		document.getElementById("slider").value + "%";
}
