$(function() {
	$(document).on('click', 'a[data-pjax]', function(event) {
		event.preventDefault();
		var self = $(this);
		var option = {
			url:    self.attr("href"),
			target: self.attr("data-pjax")
		};
		History.pushState(option, option.target, option.url);
	});

	History.Adapter.bind(window, 'statechange', function() {
		var state = History.getState();
		$.ajax({
			url: state.url + "?_seed=" + Math.random(),
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-PJAX', 'true');
			}
		})
		.done(function (data) {
			var html = $(data);
			var old_box = $("#" + html.attr("id"));
			if (old_box.length > 0)
				old_box.remove();
			$(".container-1, .container-2").addClass("hide");
			$("#main").append(html);
		});
	});

	/*
	History.pushState({state:1}, "State 1", "?state=1"); // logs {state:1}, "State 1", "?state=1"
	History.replaceState({state:3}, "State 3", "?state=3"); // logs {state:3}, "State 3", "?state=3"
	History.back(); // logs {}, "Home Page", "?"
	History.go(2); // logs {state:3}, "State 3", "?state=3"
	*/
});

