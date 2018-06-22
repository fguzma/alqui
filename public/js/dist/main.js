;(function(){

	let sticky = false //declaramos esta variable cuando no esta abajo...
	let currentPosition = 0//variable de la posicion actual del slider...

	let imageCounter = $("[data-name='image-counter']").attr("content")//declaramos la cantidad de imagenes para el slide
	const email = "trihexa_romero@hotmail.com"

	$("#form-contact").on("submit",function(ev){
		ev.preventDefault()

		sendForm($(this))

		return false
	})



	setInterval(()=>{//definimos un intervalo de tiempo

		if(currentPosition < imageCounter)//decimos que si la posicion actual es menor a la cantidad de imagenes
		{
		currentPosition++//aumentamos la posicion
		}
		else
		{
			currentPosition = 0//sino la reiniciamos 
		}

		$("#gallery .inner").css({//declaramos la funcion en el div gallery en su miembro inner
			left:"-"+currentPosition*100+"%"//cambiamos su css de la propiedad left a la posicion actual por 100
		})

	},2000)//el intervalo de tiempo 1000 = 1s
	//monitoreo del scroll de la pantalla
	$(window).scroll(()=>{
		const inBottom = isInBottom()
		//si esta abajo y la variable sticky es falsa
		if(inBottom && !sticky){
			//volvemos sticky verdadero y llamamos la funcion para la navegacion sticky
			sticky = true
			stickNavigation()
		}
		//si no esta abajo pero sticky es true
		if(!inBottom && sticky){
			//hacemos sticky falso y llamamos la funcion para esconder la barra
			sticky = false
			unStickNavigation()
		}
	})
	//mostrar navegacion sticky
	function stickNavigation(){
		$("#description").addClass("fixed").removeClass("absolute")//al div description le añadimos la clase fixed y removemos la absolute

		$("#navigation").slideUp("fast")//utilizamos la funcion de jquery  slide up con el div navigation
		$("#sticky-navigation").slideDown("fast")//utilizamos la funcion slide down con el div sticky-navigation
	}
	//ocultar navegacon sticky
	function unStickNavigation(){
		$("#description").removeClass("fixed").addClass("absolute")//removemos clase fixed y añadimos absolute

		$("#navigation").slideDown("fast")//slide down a navigation
		$("#sticky-navigation").slideUp("fast")//slide up a sticky navigation
	}

	//enviar datos del form via ajax
	function sendForm($form){
		$.ajax({
			url: $form.attr("action"),
			method: "POST",
			data: $form.formObject(),
			dataType: "json",
			success: function(){
				alert("todo bien")
			}

		})
	}
	//verificar si el div de la descripcion (footer) esta abajo (bottom)
		function isInBottom(){
		const $description = $("#description")//declaramos el div descripcion como variable
		const descriptionHeight = $description.height()//tomamos su altura

		return $(window).scrollTop() > $(window).height() - (descriptionHeight * 2)//decimos que si el scroll superior es mayor que la altura menos descriprion por 2
	}
})()
