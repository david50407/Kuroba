$(function () {
	$(document).on('click', 'a[data-pjax]', function(event) {
		event.preventDefault();
		var self = $(this);
		History.pushState(null, null, self.attr('href'));
	});

	History.Adapter.bind(window, 'statechange', function() {
		var state = History.getState();
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

