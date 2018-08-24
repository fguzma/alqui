@extends('layouts.dashboard')
@section('content')
  <div class="card">
    <h4 class="card-header">Agregar Cliente</h4>
    <div class="card-body">
      <div id="mensaje"></div>
      <form  id="data">

        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <!-- Fila de la cedula -->
        <div class="row ">
          <div class="col-md-3 "></div>
          <div class="col-md-6 ">
            <div class="form-group text-center">
                {!!Form::label('Cedula','Cedula:')!!}
                <div  class="input-group ">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="checkbox" id="nacional" checked>
                      <label class="form-check-label badge badge-pill badge-info" for="defaultCheck1">
                          Nica
                      </label>
                    </div>
                  </div>
                  {!!Form::text('Cedula_Cliente',null,['class'=>'form-control','placeholder'=>'xxx-xxxxxx-xxxxx', 'autocomplete'=>'off', 'onkeypress'=>'return CharCedula(event,this);', 'onkeyup'=>'formatonica(this)','id'=>'CC'])!!}  
                  <div class="input-group-append">
                    <button class="btn btn-primary fa fa-search" onclick="buscar();"  type="button"></button>
                    <button class="btn btn-primary fa fa-eraser" onclick="limpiar();"  type="button"></button>
                  </div>
                </div>
            </div>
          </div>
        </div>
        @include('cliente.formulario.datos')
        <div class="text-center">
          <a href="#" class="btn btn-primary col-md-2" onclick="save('guardar');" >Guardar</a>
          <a href="#" class="btn btn-primary col-md-2" onclick="save('guardarv');" >Guardar y ver</a>
          <a href="#" class="btn btn-primary col-md-2" onclick="save('guardarr');" >Guardar y reservar</a>
        </div >
        
      </form>
    </div>
  </div>

@stop

@section("script")
  {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
  {!!Html::script("js/jskevin/cedulanica.js")!!} 
  <script>
    campocedula=$("#CC");
    function buscar()
    {
      cedula=0;
      if($("#CC").length>0)
      {
        cedula=campocedula.val();
        var ruta="/cliente/"+cedula;
        $.get(ruta,function(res){
          if(res)
          {
            $("#Nombre").val(res.Nombre);
            $("#Apellido").val(res.Apellido);
            $("#Edad").val(res.Edad);
            $("#Sexo").val(res.Sexo);
            $("#Direccion").val(res.Direccion);
            message(['El cliente ya existe, no podra ser registrado!'],{objeto:$("#mensaje"),tipo:"danger",manual:true});
          }
          else
          {
            message(['Cedula no registrada, se puede registrar!'],{objeto:$("#mensaje"),tipo:"success",manual:true});
          }
        });
      }
    }
    
    //Agrega al cliente mediante una consulta AJAX
    function save(decision)
    {
      var ruta = "/cliente";
      var token = $("#token").val();
      return $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:$("#data").serialize(),
        success: function(){
          if(decision=="guardar")
          {
            message(["Se agrego el cliente correctamente"],{manual:true})
            limpiar();
          }
          if(decision=="guardarv")//redireccion a la lista de clientes
            location.href ="/clientev/1/"+$("#CC").val();
          if(decision=="guardarr")//redireccion a la reservacion
            location.href ="/reservacliente/"+$("#CC").val();

        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
          message(jqXHR,{tipo:"danger"});
          estado=false;
      });
    }
    function limpiar()
    {
      $("#CC").val("");
      $("#Nombre").val("");
      $("#Apellido").val("");
      $("#Edad").val("");
      $("#Sexo").val("");
      $("#Direccion").val("");
    }
    $("#nacional").on("change",function()
    {
        if($("#nacional").prop('checked')==true)//Si es idenficacion Nica
        {
          campocedula.val("");
          $("#Edad").val("");
        }
    });
    function mostraredad()
    {
      if(edad!=0)
        $("#Edad").val(edad);
    }
  </script>
@stop