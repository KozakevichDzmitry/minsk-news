jQuery(document).ready(function ($) {
	const lastPost = $(".timeline-main .news-template-line:last-child");

	lastPost.addClass("eof");

	let offset = 10;

	const observer = new IntersectionObserver(
		([entry]) => {
			if (entry.isIntersecting) {
				const data = {
					action: "timeline_main_news_load",
					load: 10,
					show: offset,
				};

				$.ajax({
					url: "/wp-admin/admin-ajax.php",
					data: data,
					type: "POST",
					success: function (data) {
						if (data) {
							$(".timeline-main .news-template-line.eof").removeClass("eof");
							$(".timeline-main").append(data);

							const lastItem = document.querySelector(
								".timeline-main .news-template-line:last-child"
							);

							lastItem.classList.add("eof");

							offset += 10;

							observer.unobserve(lastPost);

							observer.observe(lastItem);
						}
					},
				});
			}
		},
		{
			root: null,
			rootMargin: "0px",
			threshold: 0.01,
		}
	);

	observer.observe(lastPost[0]);
});
