<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">


    {!!Html::script("https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js")!!}
    {!!Html::script("https://code.jquery.com/jquery-migrate-3.0.0.js")!!}

    {!!Html::style("css/cssF/principal/style.css")!!}
    {!!Html::style("css/cssF/principal/reset.css")!!}
    {!!Html::script("js/jsF/principal/modernizr.js")!!}
  	
	<title>Alquileres Santana </title><!--Martha Varela-->
	<link href="/img/logosantana.jpg" type="image/x-icon" rel="shortcut icon" />
</head>
<body>
	<a id= "recover" class="cd-nav-trigger cd-text-replace" href="#primary-nav">Menu<span aria-hidden="true" class="cd-icon"></span></a>
	
	<div id = "ver" class="cd-projects-container ">
		<ul class="cd-projects-previews">
			<li>
				<a id = "boton1" href ="{!!URL('landing')!!}">
					<div class="cd-project-title">
						<h2>Clientes</h2>
					</div>
				</a>
			</li>

			<li>
				<a id = "boton2" href="{!!ROUTE('home')!!}">
					<div class="cd-project-title ">
						<h2>Administracion</h2>
					</div>
				</a>
			</li>
		</ul> <!-- .cd-projects-previews -->

		<ul class="cd-projects" >
			<li  id="htmlext1" class="cd-projects-container" >
			</li>

			<li id="htmlext2" class="cd-projects-container">
			</li>
		</ul> <!-- .cd-projects -->

		<!--
		<button class="scroll cd-text-replace">Scroll</button> -->
	</div> <!-- .cd-project-container -->



	<nav class="cd-primary-nav" id="primary-nav">
		<ul>
			<li class="cd-label">Equipo</li>
			<li><a href="#0">Kevin Antonio Valverde Varela</a></li>
			<li><a href="#0">Felipe Genaro Guzman Vilchez</a></li>
			<li><a href="#0">Maria Yissel Cruz Flores</a></li>
			<li><a href="#0">Juan Ramon Romero Cano</a></li>
		</ul>
	</nav> <!-- .cd-primary-nav -->

    {!!Html::script("js/jsF/principal/main.js")!!}
</body>
</html>