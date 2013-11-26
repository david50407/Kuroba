$(function () {
	$(window).resize(function (e) {
		$('.autosize-textarea').each(function () {
			$(this).height($(window).height() - $(this).position().top - 30)
		});
	});
	$(window).trigger('resize');
});
