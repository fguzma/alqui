<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


	<title>Alquileres</title>
    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="/img/logosantana.jpg" type="image/x-icon" rel="shortcut icon" />
</head>

</style>
<body class="bg-info" style="width:100%; height:100%;">
    <div id="app" >
        <nav class="navbar navbar-static-top" style=" background-color:#0976A5;" >
            <div class="container" >
                <div class="navbar-header">

                    <!--Agregar flecha de retroseso-->
                    <a class="navbar-brand menu" style="color: white;" href="{{ url('/') }}">
                       Regresar
                    </a>
                </div>

            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
