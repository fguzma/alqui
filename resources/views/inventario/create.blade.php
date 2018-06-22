@extends('layouts.dashboard')
@section('content')
  <div class="card">
    <h4 class="card-header">Agregar Inventario</h4>
    <div class="card-body">
      <div id="mensaje">
        @include('alert.mensaje')
      </div>
      <form action="{{route('inventario.store')}}" method="POST" id="data">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        @include('inventario.formulario.datos')
        <div class="text-center">
          <input class="btn btn-primary" type="button" value="Guardar" onclick="save('save');">
          <input class="btn btn-primary" type="button" value="Guardar y ver" onclick="save('savev');">
        </div>
      </form>
    </div>
  </div>     
 
@stop
@section('script')
  {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
  <script>
    //Agrega el item mediante una consulta AJAX
    
    function save(condition)
    {
      var ruta="http://127.0.0.1:8080/inventario";
      var token=$("#token").val();
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:$("#data").serialize(),
        success: function(result){
          if(condition=="save")
          {
            message(["Articulo agregado exitosamente"],{manual:true})
            limpiar();
          }
          if(condition=="savev")
          {
            location.href="http://127.0.0.1:8080/inventariov/1/"+$("#servicios").val()+"/"+$("#nombre").val();
          }
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
        console.log(jqXHR.responseJSON);
        message(jqXHR,{tipo:"danger"});
      });
    }
    function limpiar()
    {
      $("#servicios").val("");
      $("#nombre").val("");
      $("#cantidad").val("");
      $("#CA").val("");
      $("#CO").val("");
    }
  </script>
@stop