jQuery(document).ready(function ($) {
	const countUpRoot = document.querySelector(".metrics");
	const options = {
		separator: ' ',
	};
	const callback = (entries, observer) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				$(".metrics .card .card__title b").each((_, item) => {
					let demo = new CountUp(item, item.textContent, options);
					if (!demo.error) {
						demo.start();
					} else {
						console.error(demo.error);
					}
					});
				observer.disconnect();
			}
		});
	};

	const myObserver = new IntersectionObserver(callback, options);
	myObserver.observe(countUpRoot, {
		threshold: 0.5,
	});
});
