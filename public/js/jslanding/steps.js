;(function(){

	//$(".step:nth-child(1)").addClass("active")

	const selector = "#form-contact"

	$(".step textarea").on("keydown", (ev)=>{
		if(ev.keyCode == 13){
			ev.preventDefault()

			$(ev.target).blur()
		}
	})

	$(".path-step").on("click",(ev)=>{
		const $current_circle = $(ev.target)

		focus_circle($current_circle)

		const posicion = $current_circle.index(".path-step") + 1

		let $test = $(".step:nth-child("+posicion+")")

		focus_new_input($test)
	})

	$(selector).find(".input").on("change",(ev)=>{
		const $input = $(ev.target)

		const $next_step = $input.parent().next(".step")

		const is_form_valid = is_valid()

		if(!is_form_valid && $next_step.length > 0)
		{
			focus_new_input($next_step)
		}
		else
		{
			validar_form()
		}

	})


	//helpers
	function validar_form(){
  		if(is_valid()){
  			send_form();
		}else{
			let fieldset_invalid = $(selector).find(".input:invalid").first().parent()
			focus_new_input($fieldset_invalid)
		}

	}

	function is_valid(){
		return document.querySelector(selector).checkValidity()
	}

	function focus_new_input($next_step){
		$(".step.active").removeClass("active")
		$next_step.addClass("active")
		$next_step.find(".input").focus()
		//coordinar los circulos

		 const posicion = ($next_step.index(".step") * 2) + 1

		

		 const $circle = $(".path-step:nth-child("+posicion+")")

		 focus_circle($circle)

		//$next_input.focus()

	}

	function focus_circle($circle){
		 $(".path-step.active").removeClass("active")
		 $circle.addClass("active")	
	}

	//enviar datos del form via ajax
	function send_form(){

		const $form = $(selector)
		$.ajax({
			url: $form.attr("action"),
			method: "POST",
			data: $form.formObject(),
			dataType: "json",
			success: function(){
				$form.slideUp()
				$("#info-contacto").html("Tu mensaje se envió, pronto te responderemos")
			}

		})
	}
})()