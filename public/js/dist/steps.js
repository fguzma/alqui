"use strict";

;(function () {

	$(".step:nth-child(1)").addClass("active");

	var selector = "#form-contact";

	$(selector).find(".input").on("change", function (ev) {
		var $input = $(ev.target);

		var $next_step = $input.parent().next();

		focus_new_input($next_step);
	}

	//helpers

	);function validar_form() {
		if (es_valido()) {} else {
			$(selector).find(".input:invalid");
		}
	}

	function es_valido() {
		return document.querySelector(selector).checkValidity();
	}

	function focus_new_input($next_step) {
		$(".step.active").removeClass("active");
		$next_step.addClass("active");
		$next_step.find(".input").focus
		//$next_input.focus()
		();
	}
})();