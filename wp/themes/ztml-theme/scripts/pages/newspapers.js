jQuery(document).ready(function ($) {
	const loadMoreeBtn = $(".btn-loadmore");

	if (!loadMoreeBtn) return;

	loadMoreeBtn.click(function () {
		let _this = $(this);
		let htmlBtn = _this.html();
		let listElem = _this.prev();
		_this.html("Загрузка...");

		let data = {
			action: "loadmore",
			query: _this.attr("data-param-posts"),
			tpl: _this.attr("data-tpl"),
			load: _this.attr("data-load-posts"),
			show: _this.attr("data-show-posts"),
			type: _this.attr("data-ptype"),
			taxonomy: _this.attr("taxonomy_id"),
		};

		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			data: data,
			type: "POST",
			success: function (data) {
				if (data) {
					_this.html(htmlBtn);
					listElem.append(data);
					_this.attr("data-show-posts", listElem.children().length);
					if (+_this.attr("data-show-posts") >= +_this.attr("data-all-posts")) {
						_this.remove();
					}
				} else {
					_this.remove();
				}
			},
		});
	});
});
