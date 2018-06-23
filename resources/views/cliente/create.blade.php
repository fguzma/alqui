@extends('layouts.dashboard')
@section('content')
  <div class="card">
    <h4 class="card-header">Agregar Cliente</h4>
    <div class="card-body">
      <div id="mensaje"></div>
      <form action="{{route('cliente.store')}}" method="POST" id="data">

        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row ">
          <div class="col-md-3 "></div>
          <div class="col-md-6 ">
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                {!!Form::label('Cedula','Cedula:')!!}
                {!!Form::text('Cedula_Cliente',null,['class'=>'form-control','placeholder'=>'xxx-xxxxxx-xxxxx',  'onkeypress="return cedulanica(event,this);"','onkeyup="formatonica(this); buscar(this);"','id="CC"'])!!}    
            </div>
          </div>
        </div>
        @include('cliente.formulario.datos')
        <!---->
        <div class="text-center">
          <a href="#" class="btn btn-primary col-md-2" onclick="save('guardar');" >Guardar</a>
          <a href="#" class="btn btn-primary col-md-2" onclick="save('guardarv');" >Guardar y ver</a>
          <a href="#" class="btn btn-primary col-md-2" onclick="save('guardarr');" >Guardar y reservar</a>
        </div >
        
        <!--<input class="btn btn-primary" type="button" value="Crear con js" onclick="agregar();">-->
      </form>
    </div>
  </div>

@stop

@section("script")
  {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
  {!!Html::script("js/jskevin/cedulanica.js")!!} 
  <script>
    var autocompletado=false;
    var repetir=false;
    function buscar(cedula)
    {
      var ruta="https://alquiler.herokuapp.com/cliente/"+cedula.value;
      var token=$("#token").val();
      autocompletado=false;
        $.ajax({
            url: ruta,
            headers:{'X-CSRF-TOKEN': token},
            type: 'GET',
            dataType: 'json',
            success: function(){
                autocompletado=true;
                alert("El cliente ya esta registrado, no sera posible agregarlo");
                $("#Agregar").prop('disabled', true);
                autocompletar(cedula.value);
            }
        });
        if(autocompletado==false)
        {
          if(repetir==true)
          {
            $("#Nombre").val("");
            $("#Apellido").val("");
            $("#Sexo").val("");
            $("#Edad").val("");
            $("#Agregar").prop('disabled',false);
            repetir=false;
          }
        }
    }
    
    function autocompletar(cedula)
    {
      var ruta="https://alquiler.herokuapp.com/cliente/"+cedula;
      $.get(ruta, function(res){
            $("#Nombre").val(res.Nombre);
            $("#Apellido").val(res.Apellido);
            $("#Edad").val(res.Edad);
            if(res.Sexo=="Masculino")
              $("#Sexo").val("M");
            else
              $("#Sexo").val("F");
        });
      repetir=true;
        
    }
    //Agrega al cliente mediante una consulta AJAX
    function save(decision)
    {
      var valor = $("#data").val();//{Cedula_Cliente:"999-999999-99999",Nombre:"Kavv",Apellido:"Kavv",Edad:45,Sexo:"Hombre"};
      var ruta = "https://alquiler.herokuapp.com/cliente";
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

          if(decision=="guardarv")
            location.href ="https://alquiler.herokuapp.com/clientev/1/"+$("#CC").val();
          if(decision=="guardarr")
            location.href ="https://alquiler.herokuapp.com/reservacliente/"+$("#CC").val();

          console.log("agregado");
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
          console.log("AJAX error");
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
      autocompletado=false;
      repetir=false;
    }
  </script>
@stop