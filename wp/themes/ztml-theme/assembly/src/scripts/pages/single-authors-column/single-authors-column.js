jQuery(document).ready(function ($) {
	const onObserve = (entries) => {
		for (const entry of entries) {
			if (entry.isIntersecting) {
				entry.target.classList.add("loaded");
				$.ajax({
					url: "/wp-admin/admin-ajax.php",
					data: {
						action: "load_posts_by_date",
						post_type: "authors-column",
						date: null,
						tpl: "single-authors-column",
						load: 3,
						show: 6,
					},
					type: "POST",
					success: function (data) {
						if (data) {
							$(".main-content").append(data);
						}
					},
				});
			}
		}
	};

	const observer = new IntersectionObserver(onObserve, {
		root: null,
		rootMargin: "20px",
		threshold: 0.1,
	});

	const posts = document.querySelectorAll(".post");
	for (const post of posts) {
		observer.observe(post);
	}
});
