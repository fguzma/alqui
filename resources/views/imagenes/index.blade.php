@extends('layouts.dashboard')
@section('content')
    {{--video--}}
    <div class="row" style="margin-left: 0px">
        <div class="video-container img-fluid black" id="header">
            <video id="vid" autoplay loop height="720">
                @foreach( $videos as $video )
                    <source src="{{ $video->image_url }}" type="video/mp4">
                    {{--<source src="video/webm/wine.webm" type="video/webm">--}}
                @endforeach
            </video>
            <button id="boton_video" type="button" class="btn btn-primary tu" data-toggle="modal" data-target="#exampleModal1" >Cambiar</button>
        </div>
    </div>

    {{--galeria--}}
    @php $n_cat = array();
     foreach($categories as $category)
        $n_cat[]= $category->title;
    @endphp

    <div class="row" style="margin-left: 0em">
        @foreach( $images as $indexKey=>$image)
            <div id="{{ $indexKey+1 }}" class="col-12 col-md-3 col-lg-3 services border border-secondary" style="background-size: 100% 100%; background-image: url({{ $image }}) ">
                {{--<button id="boton_down" type="button" class="btn btn-primary tu" data-toggle="modal" data-target="#exampleModal2" >Cambiar</button>--}}
                <div class="screen">
                    <div class="row full-height t-div">
                        <div class="col-12 white-text t-child">
                            <h3 id="Slide{{ $indexKey+1 }}" class="text-center satisfy subtitle">{{ $n_cat[$indexKey+1] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{--carusel--}}
    <div class="row" style="margin-left: 0em;">
        <div id="gallery" class="carousel slide border border-secondary" data-ride="carousel" >
            {{--inicio de indicadores "responsive" conforme las imagenes agregadas--}}
            <ol class="carousel-indicators">
                @foreach( $carus as $caru )
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            {{--Fin de indicadores--}}

            <div class="carousel-inner">
                @foreach( $carus as $caru )
                    <div class="carousel-item {{$loop->first ? 'active' : ''}}" style=" width:100%; height: 697px">
                        <img class="w-100 d-block" src="{{ $caru->image_url }}" alt="{{ $caru->image_name }}">
                        {{--boton para activacion del modal--}}
                    </div>
                @endforeach
            </div>

            <a class="carousel-control-prev" href="#gallery" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#gallery" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

            <button id="boton_down2" type="button" class="btn btn-primary tu" data-toggle="modal" data-target="#exampleModal3" >Cambiar</button>
        </div>
    </div>

    {{--inicio del modal 1 upload video--}}
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="mContent" class="modal-content">
                {{--cabezera del modal--}}
                <div id="mHead" class="modal-header">
                    <h5 class="modal-title mx-auto" id="exampleModalLongTitle">Subir Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--Cuerpo del modal--}}
                <div id="mBody" class="modal-body">
                    <div class="mx-auto">
                        <form id="form" class="mx-auto" role="form" enctype="multipart/form-data" method="post" action="">
                            <div class="col-md-12 text-center" id="video" >
                                <img>
                            </div>

                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <div class=" form-group mx-auto m-4 {{$errors->has('name') ? 'has-error' : ''}}">
                                <input type="file" name="image_name2" class="form-control" id="ImageFileInput">
                            </div>

                            <div class="form-group">
                                <button id="boton_submit" type="submit" class="btn btn-primary">Subir Video </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{--pie del modal--}}
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{--Fin del modal--}}

    {{--inicio del modal 2 || para activar el carusel dentro de cada categoria--}}
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="mContent" class="modal-content" style="width: 800px">
                {{--Cuerpo del modal--}}
                {{--<div id="mBody2" class="modal-body" >--}}
                    <div id="carouselExampleControls1" class="carousel slide" data-ride="carousel">
                        <div id="interno" class="carousel-inner">

                        </div>
                        <!-- Fin contenido modal -->
                        <!-- Boton izquierda -->
                        <a class="carousel-control-prev" href="#carouselExampleControls1" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <!-- Boton derecha -->
                        <a class="carousel-control-next" href="#carouselExampleControls1" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                {{--</div>--}}
            </div>
        </div>
    </div>
    {{--Fin del modal--}}

    {{--inicio del modal 2.1 || cambio de la imagen--}}
    <div class="modal fade" id="exampleModalOn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="mContent" class="modal-content">
                {{--cabezera del modal--}}
                <div id="mHead" class="modal-header">
                    <h5 class="modal-title mx-auto" id="exampleModalLongTitle">Subir Fotos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--Cuerpo del modal--}}
                <div id="mBody4" class="modal-body">
                    <div class="mx-auto">
                        <form id="form4" class="mx-auto" role="form" enctype="multipart/form-data" method="post" action="">
                            <div class="col-md-12 text-center" id="imagen4" >

                            </div>

                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <div class=" form-group mx-auto m-4 {{$errors->has('name') ? 'has-error' : ''}}">
                                <input type="file" name="image_name4" class="form-control" id="ImageFileInput4">
                            </div>

                            <div class="form-group">
                                <button id="boton_submit4" type="submit" class="btn btn-primary">Subir Imagen </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{--pie del modal--}}
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{--Fin del modal--}}

    {{--inicio del modal 3--}}
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="mContent" class="modal-content">
                {{--cabezera del modal--}}
                <div id="mHead" class="modal-header">
                    <h5 class="modal-title mx-auto" id="exampleModalLongTitle">Subir Fotos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--Cuerpo del modal--}}
                <div id="mBody3" class="modal-body">
                    <div class="mx-auto">
                        <form id="form3" class="mx-auto" role="form" enctype="multipart/form-data" method="post" action="">
                            <div class="col-md-12 text-center" id="imagen3" >

                            </div>

                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <div class=" form-group mx-auto m-4 {{$errors->has('name') ? 'has-error' : ''}}">
                                <input type="file" name="image_name2" class="form-control" id="ImageFileInput3">
                            </div>

                            <div class="form-group">
                                <button id="boton_submit3" type="submit" class="btn btn-primary">Subir Imagen </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{--pie del modal--}}
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{--Fin del modal--}}

@stop

@section("script")
    <script>
        //stop carousel slider
        $(document).ready(function() {
            $('.carousel').each(function () {
                $(this).carousel({
                    interval:false
                });
            })
        });
        //function for csrf_token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //upload al carusel
        $('#boton_down2').click(function (e) {
            var bg = $('div.carousel-item.active').children().attr('src');
//            bg = bg.replace('url(', '').replace('"', '').replace('"', '').replace(')', '');
            console.log(bg);
            $("#form3").submit(function (e) {
                e.preventDefault();
                if( !$('#ImageFileInput3').val()) {
//                            if (!run) {
                    $("#mBody3").prepend("<div id='hid' class='alert alert-danger text-center' role='alert'> Ingrese la imagen " +
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" + " " +
                        "<span aria-hidden='true'>&times;</span> " +
                        "</div>");
//                    run = true;
//                            }
                }
                else{
                    $input = $('#ImageFileInput3');
                    input = $('#ImageFileInput3').val();
                    data = new FormData();
                    data.append('img', $input[0].files[0]);
                    data.append('bg', bg);
//                    console.log(input)
                    $.ajax({
                        url: "/change/image",
                        type: 'POST',
                        method: 'POST',
                        dataType: "json",
                        data: data,
                        processData: false,
                        contentType: false,
                    });
                }
            });
        });
        //apertura de los carusel de categorias
        for (let i = 0; i <= 8; i++) {
            $('#Slide' + i).click(function () {
                event.preventDefault();
                var nom = $('#Slide' + i).text();
                console.log(nom);
                jQuery.ajax({
                    url : "/changeModal",
                    method: 'POST',
                    data: {
                        nom: nom
                    },
                    success: function(mensaje)
                    {
                        //si no es nulo
                        if( mensaje )
                        {
//                            console.log(mensaje);
                            $("#interno").empty();
                            $("#interno").append(mensaje);
                            $("#interno").append("<button id='boton_cat' type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalOn' >Cambiar</button>")
                            $('#exampleModal2').modal('show');
//                            $('#boton_down2').show();
                        }
                        else
                        {
                            console.log('nop');
                        }
                    }
                });
            });
        }
        //uploads de carusel de categorias
        $(document).on('click', '#boton_cat', function (e) {
            var bg = $('div#inter.carousel-item.active').children().attr('src');
            console.log(bg);

            $(document).on('submit','#form4',function (e) {
                e.preventDefault();
                if (!$('#ImageFileInput4').val()) {
                    //                            if (!run) {
                    $("#mBody4").prepend("<div id='hid' class='alert alert-danger text-center' role='alert'> Ingrese la imagen " +
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" + " " +
                        "<span aria-hidden='true'>&times;</span>" +
                        "</div>");
                    //                    run = true;
                    //                            }
                }
                else{
                    $input = $('#ImageFileInput4');
                    input = $('#ImageFileInput4').val();
                    data = new FormData();
                    data.append('img', $input[0].files[0]);
                    data.append('bg', bg);
//                    console.log(input)
                    $.ajax({
                        url: "/change/image",
                        type: 'POST',
                        method: 'POST',
                        dataType: "json",
                        data: data,
                        processData: false,
                        contentType: false,
                    });
                }
            });
        });
        //upload al video
        $("#boton_video").click(function (e) {
            var bg = $("#vid").children().attr('src');
            bg = bg.replace('url(', '').replace('"', '').replace('"', '').replace(')', '');
            console.log(bg);
            $("#form").submit(function (e) {
                e.preventDefault();
                if( !$('#ImageFileInput').val()) {
//                            if (!run) {
                    $("#mBody").prepend("<div id='hid' class='alert alert-danger text-center' role='alert'> Ingrese la imagen " +
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" + " " +
                        "<span aria-hidden='true'>&times;</span> " +
                        "</div>");
//                    run = true;
//                            }
                }
                else{
                    $input = $('#ImageFileInput');
                    input = $('#ImageFileInput').val();
                    console.log(input);
                    data = new FormData();
                    data.append('video', $input[0].files[0]);
                    data.append('bg', bg);
//                    console.log(input);
                    $.ajax({
                        url: "/change/video",
                        type: 'POST',
                        method: 'POST',
                        dataType: "json",
                        data: data,
                        processData: false,
                        contentType: false,
                        success:function (msm) {

                        }
                    });
                }
            });
        });
        //evento cuando se va a subir la imagen mostrarla, este solo funciona en el carusel
        $('#ImageFileInput3').change(function(e) {
            //declaracion de lector
            let reader = new FileReader();
            arch = e.target.files[0];
//            console.log(arch);

            //si no es imagen
            if(!arch.type.match('image.*'))
                return;

            reader.onload = function() {
                let imagen = document.getElementById('imagen3'),
                    image = document.createElement('img');
                //le pasamos la imagen al source
                image.src = reader.result;
                image.setAttribute('class','mx-auto d-block');

                imagen.innerHTML = '';
                //añadimos la imagen
//                imagen.append(image);
                imagen.append(image);
            };
            reader.readAsDataURL(arch);
        });
        $('#ImageFileInput4').change(function(e) {
            //declaracion de lector
            let reader = new FileReader();
            arch = e.target.files[0];
//            console.log(arch);

            //si no es imagen
            if(!arch.type.match('image.*'))
                return;

            reader.onload = function() {
                let imagen = document.getElementById('imagen4'),
                    image = document.createElement('img');
                //le pasamos la imagen al source
                image.src = reader.result;
                image.setAttribute('class','mx-auto d-block');

                imagen.innerHTML = '';
                //añadimos la imagen
//                imagen.append(image);
                imagen.append(image);
            };
            reader.readAsDataURL(arch);
        });
        //evento cuando se va a subir el video, lo muestra
        $('#ImageFileInput').change(function(e) {
            //declaracion de lector
            let reader = new FileReader();
            arch = e.target.files[0];
//            console.log(arch);

            //si no es imagen
            if(!arch.type.match('video.*'))
                return;

            reader.onload = function() {
                let videon = document.getElementById('video'),
                    vid = document.createElement('video');
                //le pasamos la imagen al source
                vid.src = reader.result;
                vid.setAttribute('class','mx-auto d-block');
                vid.autoplay = true;
                vid.loop = true;
//                image.setAttribute('autoplay');

                videon.innerHTML = '';
                //añadimos la imagen
//                imagen.append(image);
                videon.append(vid);
            };
            reader.readAsDataURL(arch);
        });
        //limpiar division y contenido cuando se cierra el modal(video)
        $("#exampleModal1").on('hidden.bs.modal', function (e) {
            $("#video").empty();
            $("#ImageFileInput").val('');
        });
        //limpiar division y contenido cuando se cierra el modal(carusel ultimo)
        $("#exampleModal3").on('hidden.bs.modal', function (e) {
            $("#imagen3").empty();
            $("#ImageFileInput3").val('');
        })
        $("#exampleModalOn").on('hidden.bs.modal', function (e) {
            $("#imagen4").empty();
            $("#ImageFileInput4").val('');
        })
    </script>
@endsection