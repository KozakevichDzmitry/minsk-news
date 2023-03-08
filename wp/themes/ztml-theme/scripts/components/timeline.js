jQuery(document).ready(function ($) {
	let timelineIsCollapsed = true;

	$(".timeline .timeline__buttons .timeline__btn-expand").on(
		"click",
		function () {
			if (timelineIsCollapsed) {
				$('#open_timeline').css({'display': 'none'});
				$(".timeline .container.news").addClass("expanded");
				$(".timeline .container.news").removeClass("collapsed");
				timelineIsCollapsed = false;
			} else {
				$('#open_timeline').css({'display': 'block'});
				$(".timeline .container.news").addClass("collapsed");
				$(".timeline .container.news").removeClass("expanded");
				timelineIsCollapsed = true;
			}
		}
	);

	$(".timeline .timeline__buttons .timeline__btn-collapse").on("click", () => {
		$("footer .timeline").addClass("minimize");
	});
});

jQuery(document).ready(function ($) {
	let lastPost = document.querySelector(
		".timeline .timeline__news-list-expanded .post-line:last-child"
	);

	const dataRequest = {
		action: "timeline_news_load",
		load: 10,
		offset: 10,
	};

	const ajaxRequest = (args, cb) =>
		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			data: { ...dataRequest, ...args },
			type: "POST",
			beforeSend: function( xhr){
				$('body').addClass('loading');
			},
			success: (data) => cb(data),
		});

	const updatePosts = (observer, posts) => {
		const dataEls = $(posts);

		$(dataEls[dataEls.length - 1]).addClass("eof");

		$(".timeline .timeline__news-list-expanded").append(dataEls);

		observer.unobserve(lastPost);

		lastPost = document.querySelector(
			".timeline .timeline__news-list-expanded .post-line:last-child"
		);

		observer.observe(lastPost);

		dataRequest.offset += dataRequest.load;
	};

	const observer = new IntersectionObserver(
		([entry]) => {
			if (entry.isIntersecting) {
				ajaxRequest({}, (data) => {
					$(
						".timeline .timeline__news-list-expanded .post-line:last-child"
					).removeClass("eof");

					if (data) {
						updatePosts(observer, data);
					}
				});
			}
		},
		{
			root: null,
			rootMargin: "10px",
			threshold: 0.1,
		}
	);

	observer.observe(lastPost);
});
