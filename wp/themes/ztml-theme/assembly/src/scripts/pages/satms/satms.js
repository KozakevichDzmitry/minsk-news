jQuery(document).ready(function ($) {
	const loadMoreeBtn = $(".satms .satms__moree-btn button");

	if (!loadMoreeBtn) return;
	let dataRequest = {
		action: "satms_load",
		type: "post",
		offset: 3,
		load: 9,
	}
	loadMoreeBtn.click(function () {
		$.ajax({
			url: ajaxpagination.ajaxurl,
			type: "post",
			data: dataRequest,
			beforeSend: function(){
				$(loadMoreeBtn).html('Загрузка...')
			},
			success: function (html) {
				dataRequest.offset +=dataRequest.load
				$(".satms .cards-list").append(html);
				$(loadMoreeBtn).html('Показать еще')
			},
		});
	});
});
