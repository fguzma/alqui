@extends('layouts.dashboard')
@section('content')
<div class="card">
  <h4 class="card-header">Agregar Servicio</h4>
  <div class="card-body">
    <div id="mensaje"></div>
    <form action="{{route('servicio.store')}}" method="POST" id="data">

      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <input type="text" style="display:none;">
    
      <div class="row ">
        <div class="col-md-6">
          <div class="form-group">
              {!!Form::label('Nombre:')!!}
              {!!Form::text('Nombre',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre del servicio'])!!}
          
              <input type="text" style="display:none;">
          </div>
        </div>
      </div>

      <input class="btn btn-primary" type="button" onclick="save('save');" value="Guardar">
      <input class="btn btn-primary" type="button" onclick="save('savev');" value="Guardar y ver">
    </form>
  </div>
</div>     
@stop
@section('script')
  {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
  <script>
    function save(condition)
    {
      var ruta="/servicio";
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
            message(["Servicio agregado exitosamente"],{manual:true})
            $("#nombre").val("");
          }
          if(condition=="savev")
          {
            location.href="/serviciov/1/"+$("#nombre").val();
          }
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
        console.log(jqXHR.responseJSON);
        message(jqXHR,{tipo:"danger"});
      });
    }
  </script>
@stop