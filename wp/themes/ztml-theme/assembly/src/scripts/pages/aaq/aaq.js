
window.onload=()=>{
	new Swiper('.aaq-questions', {
		speed: 400,
		spaceBetween: 30,
		wrapperClass: 'aaq-question-list',
		slideClass: 'aaq-question-list-item',
		navigation: {
			nextEl: '.slick-next',
			prevEl: '.slick-prev',
		},
		pagination: {
			el: '.slick-dots',
			type: 'bullets',
		},
		breakpoints: {
			// when window width is >= 950
			950: {
				slidesPerView: 2,
			},
			769: {
				slidesPerView: 1,
			},
			600: {
				slidesPerView: 2,
			},
			360: {
				slidesPerView: 1,
			},
		}
	});
};

jQuery(document).ready(function ($) {
	const loadBtnEl = $(".load-moree-btn");
	const ajaxRequest = (args, cb) =>
		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			data: { ...dataRequest, ...args },
			type: "POST",
			success: (data) => cb(data),
		});

	const dataRequest = {
		action: "ethers_posts_load",
		load: 10,
		offset: 10,
	};

	loadBtnEl.on("click", () => {
		loadBtnEl.find("button").text("Загрузка...");

		ajaxRequest({}, (data) => {
			if (data) {
				const { posts, count } = JSON.parse(data);

				if (count <= dataRequest.offset + dataRequest.load) {
					loadBtnEl.hide();
				} else {
					loadBtnEl.show();
				}

				$(".main-content .efirs-list").append(posts);
				dataRequest.offset += dataRequest.load;
				$(".load-moree-btn button").attr("data-all-posts", count);

				loadBtnEl.find("button").text("Показать еще");
			}
		});
	});
});
