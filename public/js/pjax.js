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

			var html = $(data).hide();
			$("#" + html.attr("id")).remove();
			$(".container-1, .container-2").stop().hide({
				effect: 'fade',
				easing: 'easeInExpo',
				duration: 200,
			});
			$("#main").append(html);
			html.show({
				effect: 'fade',
				easing: 'easeOutExpo',
				duration: 200
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

