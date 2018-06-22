@extends('layouts.dashboard')
@section('content')
  <div class="card">
    <h4 class="card-header">Agregar Personal</h4>
    <div class="card-body">
    <div id="mensaje"></div>
      <form action="{{route('personal.store')}}" method="POST" id="data" >

        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <div class="row ">
          <div class="col-md-3 "></div>
          <div class="col-md-6 ">
            <div class="form-group text-center">
                {!!Form::label('Cedula','Cedula:')!!}
                {!!Form::text('Cedula_Personal',null,['id'=>'cedu','class'=>'form-control','placeholder'=>'xxx-xxxxxx-xxxxx', 'onkeypress="return cedulanica(event,this);"','onkeyup="formatonica(this); buscar(this);"'])!!}
          </div>
          </div>
        </div>
        @include('personal.formulario.datos')
        <!--Tabla de cargos-->
        <div class="row" >
          <div class="col-md-2"></div>
          <div class="col-md-8" id="lc">
            <div class="list-group " id="list-tab" role="tablist" style="height:15em;width:auto; overflow:scroll;border-radius: 40px;">
              <table class="table table-hover table-dark">
                <thead>
                  <tr>
                    <th class="text-center">Cargo</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($Cargos as $cargo)
                    <tr>
                      <td >{!!$cargo->Nombre_Cargo!!}</td>
                      <td class="btn-primary text-center">
                        <input id="{!!$cargo->ID_Cargo!!}" type="checkbox" OnClick='addcargo(this,"{!!$cargo->Nombre_Cargo!!}","{!!$cargo->ID_Cargo!!}")'>
                      </td>
                    </tr>  
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="text-center">
          <input class="btn btn-primary" type="button" id="Agregar" onclick="guardar('guardar');" value="Guardar">
          <input class="btn btn-primary" type="button" id="Agregar" onclick="guardar('guardarv');" value="Guardar y ver">
        </div>
      </form>
    </div>
  </div>   

@stop
<!--Ese escript no siempre se utiliza por lo que hacemos uso de la seccion script-->
@section("script")
  {!!Html::script("js/jskevin/cedulanica.js")!!} 
  {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
  <script>
    var listacargo=new Object();
    var autocompletado=false;
    var repetir=false;
    function buscar(cedula)
    {
      var ruta="http://127.0.0.1:8080/personal/"+cedula.value;
      var token=$("#token").val();
      autocompletado=false;
        $.ajax({
            url: ruta,
            headers:{'X-CSRF-TOKEN': token},
            type: 'GET',
            dataType: 'json',
            success: function(){
                autocompletado=true;
                alert("El Personal ya esta registrado, no sera posible agregarlo");
                $("#Agregar").prop('disabled',true);
                autocompletar(cedula.value);
            }
        });
        if(autocompletado==false)
        {
          if(repetir==true)
          {
            $("#Nombre").val("");
            $("#Apellido").val("");
            $("#Direccion").val("");
            $("#Fecha_Nac").val("");
            $("#Agregar").prop('disabled',false);
            repetir=false;
          }
        }
    }
    function autocompletar(cedula)
    {
      var ruta="http://127.0.0.1:8080/personal/"+cedula;
      $.get(ruta, function(res){
            $("#Nombre").val(res.Nombre);
            $("#Apellido").val(res.Apellido);
            $("#Direccion").val(res.Direccion);
            $("#Fecha_Nac").val(res.Fecha_Nac);
        });
      repetir=true;
    }
    //agregamos o eliminamos en la lista cargo
    function addcargo(elemento,cargo,key)
    {
      if(elemento.checked==true)
      {
        listacargo[key]=[cargo,key];
      }
      else
      {
        delete listacargo[key];
      }
    }
    function guardar(decision)
    {
      var ruta = "http://127.0.0.1:8080/personal";
      var token = $("#token").val();
      console.log($("#data").serialize());
      //Consulta para añadir el nuevo personal
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:$("#data").serialize(),
        success: function(res){
          ruta="http://127.0.0.1:8080/personalcargo";
          //Consulta para agregar los cargos que se han predefinido del personal
          $.ajax({
            url:ruta,
            headers: {'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {'listacargo':listacargo,'cedula':$("#cedu").val()},
            success: function(res)
            {
              console.log("cargo agregado");
            }
          }).fail( function( jqXHR, textStatus, errorThrown ) {
            message(jqXHR,{tipo:"danger"});
          });
          if(decision=='guardarv')//si desea guardar y ver el personal recien agregado
            location.href="http://127.0.0.1:8080/personalv/"+"1"+"/"+$("#cedu").val();
          if(decision=='guardar')//Si desea guardar e ingresar uno mas
          {
            message(["Se agrego el personal correctamente "],{manual:true})
            limpiar();
          }
          console.log("se agrego");
          return;
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
        console.log("error");
        message(jqXHR,{tipo:"danger"});
      });
    }
    function limpiar()
    {
      $("#cedu").val("");
      $("#Nombre").val("");
      $("#Apellido").val("");
      $("#Direccion").val("");
      $("#Fecha_Nac").val("");
      for(var elemento in listacargo)
      {
        console.log(elemento);
        $("#"+elemento).prop('checked',false);
      }
      listacargo=new Object();
    }
  </script>  
@stop