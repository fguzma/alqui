@extends('layouts.dashboard')
@section('content')
  <div class="card">
    <h4 class="card-header">Agregar al menu</h4>
    <div class="card-body">
    <div id="mensaje"></div>
      {!!Form::open(['route'=>'menus.store', 'method'=>'POST', 'id' => 'data','enctype'=>'multipart/form-data'])!!}
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        @include('menu.formulario.datos')

        <div class="text-center">
          <input class="btn btn-primary" type="button"  onclick="save('guardar');" value="Guardar">
          <input class="btn btn-primary" type="button"  onclick="save('guardarv');" value="Guardar y ver">
        </div>
      {!!Form::close()!!}
    </div>
  </div>   

@stop
@section('script')
  {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
  <script>
    function save(decision)
    {
      var ruta = "/menus";
      var token = $("#token").val();
      var formData = new FormData($('#data')[0]);
      console.log(formData);
      message(["Enviando... por favor espere la confirmacion!"],{manual:true})
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:formData,
        contentType: false,
        processData: false,
        success: function(){
          if(decision=="guardar")
          {
            message(["Se agrego el menu correctamente correctamente"],{manual:true})
            limpiar();
          }

          if(decision=="guardarv")
            location.href ="/menus/1/"+$("#descripcion").val();

          console.log("agregado");
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
          message(jqXHR,{tipo:"danger"});
      });
    }
    function limpiar()
    {
      $("#descripcion").val("");
      $("#costo").val("");
      $("#path").val("");
    }
  </script>
@stop
