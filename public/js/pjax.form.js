$(function (){
	$(document).on('submit', 'form[data-pjax]', function (event) {
		event.preventDefault();
		var self = $(this);
		var button = $('button[type=submit]', self);
		button.ladda({ timeout: 2000 });
		button.ladda('start');
	})
});
