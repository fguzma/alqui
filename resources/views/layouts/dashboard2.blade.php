<html>
  <head lang="en">
    <meta charset="utf-8">
    <meta content="IE=edge, chrome=1" http-equiv="X-UA-Compatible">
    <link href="assets/img/favicon.icon" rel="icon" type="image/png">
    <title>
      Light Boostrap Dashboard by Creative Tim
    </title>
    <meta content="width=device-width" initial-scale="maximun-scale=1.0" name="viewport" user=scalable="0">
    <meta content="width = device-width" initial-scale="1" name="viewport" shrink-to-fit="no">
   <!-- <link href="css/cssF/bootstrap.min.css" rel="stylesheet"> 
    <link href="css/cssF/animate.min.css" rel="stylesheet">
    <link href="css/cssF/light-bootstrap-dashboard.css" rel="stylesheet">
    <link href="css/cssF/demo.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/cssF/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300" rel="stylesheet" type="text/css">
    <link href="css/cssF/pe-icon-7-stroke.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    -->

    {!!Html::style("css/cssF/bootstrap.min.css")!!}
    {!!Html::style("css/cssF/animate.min.css")!!}
    {!!Html::style("css/cssF/light-bootstrap-dashboard.css")!!}
    {!!Html::style("css/cssF/demo.css")!!}
    {!!Html::style("http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css")!!}
    {!!Html::style("css/cssF/font-awesome.min.css")!!}
    {!!Html::style("http://fonts.googleapis.com/css?family=Roboto:400,700,300")!!}
    {!!Html::style("css/cssF/pe-icon-7-stroke.css")!!}
    {!!Html::style("https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css")!!}
  </head>
  <body>
    <div class="wrapper">
      <div class="sidebar" data-color="purple" data-image="img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
          <div class="logo">
            <a class="simple-text" href="">Alquileres Martha Varela</a>
          </div>
          <ul class="nav">
            <li class="active">
              <a href="{{url('principal')}}">
                <i class="pe-7s-graph"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li>
              <a aria-expanded="false" data-toggle="collapse" href="#collapse-cliente">
                <i class="pe-7s-user"></i>
                <p>
                  Cliente
                  <b class="carret"></b>
                </p>
              </a>
              <ul class="collapse collapseable" id="collapse-cliente">
                <li>
                  <a href="{{url('users')}}">
                    <i class="pe-7s-user"></i>
                    <p>Agregar Cliente</p>
                  </a>
                </li>
                <li>
                  <a href="{{route('cliente.index')}}">
                    <i class="pe-7s-user"></i>
                    <p>Ver Clientes</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a aria-controls="collapse-post" aria-hidden="true" data-toggle="collapse" href="#collapse-personal">
                <i class="pe-7s-note2"></i>
                <p>
                  Personal
                  <b class="carret"></b>
                </p>
              </a>
              <ul class="collapse collapseable" id="collapse-personal">
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Agregar Personal</p>
                  </a>
                </li>
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Ver Personal</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a aria-controls="collapse-post" aria-hidden="true" data-toggle="collapse" href="#collapse-vetado">
                <i class="pe-7s-map-marker"></i>
                <p>
                  Vetado
                  <b class="carret"></b>
                </p>
              </a>
              <ul class="collapse collapseable" id="collapse-vetado">
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Agregar Vetados</p>
                  </a>
                </li>
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Ver Vetados</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a aria-controls="collapse-post" aria-hidden="true" data-toggle="collapse" href="#collapse-inventario">
                <i class="pe-7s-news-paper"></i>
                <p>
                  Inventario
                  <b class="carret"></b>
                </p>
              </a>
              <ul class="collapse collapseable" id="collapse-inventario">
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Agregar Personal</p>
                  </a>
                </li>
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Ver Personal</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a aria-controls="collapse-post" aria-hidden="true" data-toggle="collapse" href="#collapse-reservacion">
                <i class="pe-7s-science"></i>
                <p>
                  Reservacion
                  <b class="carret"></b>
                </p>
              </a>
              <ul class="collapse collapseable" id="collapse-reservacion">
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Agregar Reservacion</p>
                  </a>
                </li>
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Ver Reservacion</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a aria-controls="collapse-post" aria-hidden="true" data-toggle="collapse" href="#collapse-Eventos">
                <i class="pe-7s-map-marker"></i>
                <p>
                  Eventos
                  <b class="carret"></b>
                </p>
              </a>
              <ul class="collapse collapseable" id="collapse-Eventos">
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Agregar Eventos</p>
                  </a>
                </li>
                <li>
                  <a href="">
                    <i class="pe-7s-user"></i>
                    <p>Ver Eventos</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
          <div class="container-fluid">
            <div class="navbar-header">
              <button class="navbar-toggle" data-target="#navigation-example-2" data-toggle="collapse" type="button">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="">Dashboard</a>
            </div>
            <div class="collapse navbar-collapse">
              <ul class="nav navbar-nav navbar-left">
                <li>
                  <a href="">
                    <i class="fa fa-search"></i>
                    <p class="hidden-lg hidden-md">
                      Search
                    </p>
                  </a>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="">
                    <p>Account</p>
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <p>
                      Dropdown
                      <b class="caret"></b>
                    </p>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="#">Action</a>
                    </li>
                    <li>
                      <a href="#">Another Action</a>
                    </li>
                    <li>
                      <a href="#">Something</a>
                    </li>
                    <li>
                      <a href="#">Another Action</a>
                    </li>
                    <li>
                      <a href="#">Something</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="#">Separated link</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#">
                    <p>Log Out</p>
                  </a>
                </li>
                <li class="separator hidden-lg hidden-md"></li>
              </ul>
            </div>
          </div>
        </nav>
        @yield('content')
        
      </div>
      <!--<script src="js/jsF/jquery-1.10.2.js" type="text/javascript"></script>-->
      <!--<script src="js/jsF/bootstrap.min.js" type="text/javascript"></script>
      <script src="js/jsF/light-bootstrap-dashboard.js"></script>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    -->
    {!!Html::script("js/jsF/light-bootstrap-dashboard.js")!!}
    {!!Html::script("https://code.jquery.com/jquery-3.2.1.slim.min.js")!!}
    {!!Html::script("https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js")!!}
    {!!Html::script("https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js")!!}
    </div>
    <footer class="footer">
          <div class="container-fluid">
            <nav class="pull-left">
              <ul>
                <li>
                  <a href="#">
                    Company
                  </a>
                </li>
                <li>
                  <a href="#">
                    Company
                  </a>
                </li>
                <li>
                  <a href="#">
                    Company
                  </a>
                </li>
                <li>
                  <a href="#">
                    Company
                  </a>
                </li>
              </ul>
            </nav>
            <p class="pull-right copyright">
              <script>
                <a href="">
                made with love for a better web</a>
              </script>
            </p>
          </div>
        </footer>
  </body>
</html>
