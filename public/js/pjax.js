$(function () {
	$(document).on('click', 'a[data-twice]', function(event) {
		event.preventDefault();
		var self = $(this);
		self.removeClass(self.attr('data-twice').split('|')[0]);
		self.addClass(self.attr('data-twice').split('|')[1]);
		self.removeAttr('data-twice');
		self.attr('data-pjax', 'true');
	});

	$(document).on('click', 'a[data-pjax]', function(event) {
		event.preventDefault();
		var self = $(this);
		History.pushState(null, null, self.attr('href'));
	});

	var boardRegex = /board-(\w+)/;
	var messageRegex = /message-(\w+)/;
	History.Adapter.bind(window, 'statechange', function() {
		var state = History.getState();
		var board = boardRegex.exec(state.url);
		if (board) {
			$('#nav .pure-menu-selected').removeClass('pure-menu-selected');
			$('#nav li[data-board=' + board[1] + ']').addClass('pure-menu-selected');
			var message = messageRegex.exec(state.url);
			if (message) {
				$('.msg-item.msg-item-selected').removeClass('msg-item-selected');
				$('.msg-item[data-message=' + message[1] + ']').addClass('msg-item-selected');
			}
		}
		$.ajax({
			url: state.url + "?_seed=" + Math.random(),
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-PJAX', 'true');
			}
		}).done(function (data, text, jsXHR) {
			if (jsXHR.getResponseHeader("Pjax-Session-Changed") == "true") {
				$.ajax({
					url: $BASE + "account/status",
					beforeSend: function (xhr) {
						xhr.setRequestHeader('X-PJAX', 'true');
					}
				}).done(function (data) {
					var html = $(data);
					$('#' + html.attr('id')).replaceWith(html);
				})
				$.ajax({
					url: $BASE + "board/sidebar",
					beforeSend: function (xhr) {
						xhr.setRequestHeader('X-PJAX', 'true');
					}
				}).done(function (data) {
					var html = $(data);
					$('#' + html.attr('id')).replaceWith(html);
				})
			}
			if (jsXHR.getResponseHeader("Pjax-Location")) {
				History.replaceState(null, null, jsXHR.getResponseHeader("Pjax-Location"));
				return;
			}
			var container = $('#' + (jsXHR.getResponseHeader("Pjax-Container") || "main"));

			var html = $(data);
			container.stop().hide({
				effect: 'fade',
				easing: 'easeInExpo',
				duration: 200,
				complete: function () {
					container.children().hide();
					$("#" + html.attr("id"), container).remove();
					container.append(html);
					container.show({
						effect: 'fade',
						easing: 'easeOutExpo',
						duration: 200,
						complete: function () {
							$(window).trigger('resize');
							$('input, textarea', html).first().trigger('focus');
						}
					});
				}
			});
		});
	});

	/*
	History.pushState({state:1}, "State 1", "?state=1"); // logs {state:1}, "State 1", "?state=1"
	History.replaceState({state:3}, "State 3", "?state=3"); // logs {state:3}, "State 3", "?state=3"
	History.back(); // logs {}, "Home Page", "?"
	History.go(2); // logs {state:3}, "State 3", "?state=3"
	*/
});

