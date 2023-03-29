document.addEventListener("DOMContentLoaded", () => {
	function share_popup(url, title, w, h) {
		var dualScreenLeft =
			window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop =
			window.screenTop != undefined ? window.screenTop : screen.top;
		var width = window.innerWidth
			? window.innerWidth
			: document.documentElement.clientWidth
				? document.documentElement.clientWidth
				: screen.width;
		var height = window.innerHeight
			? window.innerHeight
			: document.documentElement.clientHeight
				? document.documentElement.clientHeight
				: screen.height;
		var left = width / 2 - w / 2 + dualScreenLeft;
		var top = height / 2 - h / 2 + dualScreenTop;
		var newWindow = window.open(
			url,
			title,
			"scrollbars=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left"
		);
		if (window.focus) {
			newWindow.focus();
		}
	}

	document.addEventListener('click', (e)=> {
		const el = e.target.closest(".share_button")
		let url, title, w, h;
		if(el){
			const id = el.id
			switch (id) {
				case 'facebook':
					url = `https://www.facebook.com/share.php?u=${el.dataset.link}`
					title = 'Поделиться в Facebook'
					w = 650
					h = 500
					break;
				case 'telegram':
					url = `https://telegram.me/share/url?url=${el.dataset.link}&text=${el.dataset.title}`
					title = 'Поделиться в Телеграме'
					w = 580
					h = 415
					break
				case 'vk':
					url = `https://vk.com/share.php?url=${el.dataset.link}&title=${el.dataset.title}`
					title = 'Поделиться ВКонтакте'
					w = 650
					h = 600
					break
				case 'tw':
					url = `https://twitter.com/intent/tweet?text=${el.dataset.link} ${el.dataset.title}`
					title = 'Твитнуть'
					w = 580
					h = 415
					break
				case 'ok':
					url = `https://connect.ok.ru/offer?url=${el.dataset.link}`
					title = 'Поделиться в Одноклассниках'
					w = 580
					h = 415
					break
				case 'viber':
					url = `viber://forward?text=${encodeURIComponent(el.dataset.link)}`
					title = 'Поделиться в Вайбере'
					w = 580
					h = 415
					break
			}
			share_popup(url, title, w, h)
		}
	})
});
jQuery(document).ready(function ($) {
	let lastShareLinkEl = null;
	$(document).on("click", function (e) {
		let target = $(e.target);

		let parent = target.closest(".share-block--fold");

		if (parent) {
			if (lastShareLinkEl && !lastShareLinkEl.is($(parent))) {
				lastShareLinkEl.removeClass("active");
			}
			$(parent).toggleClass("active");
			lastShareLinkEl = $(parent);
		}
	});
});
