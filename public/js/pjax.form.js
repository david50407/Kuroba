$(function (){
	$(document).on('submit', 'form[data-pjax]', function (event) {
		event.preventDefault();
		var self = $(this);
		var button = $('button[type=submit]', self);
		button.ladda('start');
		$(".form-notice[data-notice]", self).removeClass('show');
		$.ajax({
			url:  self.attr('action') + '.json',
			type: self.attr('method') || 'get',
			data: self.serialize(),
			dataType: 'json',
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-PJAX', 'true');
			}
		}).done(function (data) {
			button.ladda('stop');
			if (data.status == 0) // success
				History.pushState(null, null, data.referral);
			if (data.status == -1) { // missing parameter / wrong input
				console.log(data);
				$.each(data.error, function (target, msg) {
					if (target != '#')
						$(".form-notice[data-notice=" + target + "]", self).addClass('show');
						$(".form-notice[data-notice=" + target + "] .form-notice-tip", self).html(msg);
				});
			}
		});
	})
});
