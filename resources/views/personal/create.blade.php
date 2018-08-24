@extends('layouts.dashboard')
@section('content')
  <div class="card">
    <h4 class="card-header">Agregar Personal</h4>
    <div class="card-body">
    <div id="mensaje"></div>
      <form id="data" >

        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
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
                  {!!Form::text('Cedula_Personal',null,['class'=>'form-control','placeholder'=>'xxx-xxxxxx-xxxxx', 'autocomplete'=>'off', 'onkeypress'=>'return CharCedula(event,this);', 'onkeyup'=>'formatonica(this)','id'=>'cedu'])!!}  
                  <div class="input-group-append">
                    <button class="btn btn-primary fa fa-search" onclick="buscar();"  type="button"></button>
                    <button class="btn btn-primary fa fa-eraser" onclick="limpiar();"  type="button"></button>
                  </div>
                </div>
            </div>
          </div>
        </div>
        @include('personal.formulario.datos')
        <!--Tabla de cargos-->
        <div class="row" >
          <div class="col-md-2"></div>
          <div class="col-md-8" id="lc">
            <div class="list-group " id="list-tab" role="tablist" style="height:15em;width:auto; overflow:scroll;border-radius: 40px;">
              <table class="table table-hover table-dark" cellspacing="0" id="cargos" style="width:100%;">
                <thead>
                  <tr>
                    <th class="text-center">Cargo</th>
                    <th data-orderable="false"></th>
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
  {!!Html::script("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")!!} 
  {!!Html::script("https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js")!!} 
  {!!Html::script("js/jskevin/kavvdt.js")!!}  
  <script>
    var listacargo=new Object();
    campocedula=$("#cedu");
    $(document).ready(function(){
      createdt($("#cargos"),{col:0,dom:""});
    });
    function buscar()
    {
      cedula=0;
      if($("#cedu").length>0)
      {
        cedula=campocedula.val();
        var ruta="/personal/"+cedula;
        $.get(ruta,function(res){
          if(res)
          {
            $("#Nombre").val(res.Nombre);
            $("#Apellido").val(res.Apellido);
            $("#Direccion").val(res.Direccion);
            $("#Fecha_Nac").val(res.Fecha_Nac);
            message(['El personal ya existe, no podra ser registrado!'],{objeto:$("#mensaje"),tipo:"danger",manual:true});
          }
          else
          {
            message(['Cedula no registrada, se puede registrar!'],{objeto:$("#mensaje"),tipo:"success",manual:true});
          }
        });
      }
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
      var ruta = "/personal";
      var token = $("#token").val();
      //Consulta para añadir el nuevo personal
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:$("#data").serialize(),
        success: function(res){
          ruta="/personalcargo";
          //Consulta para agregar los cargos que se han predefinido del personal
          $.ajax({
            url:ruta,
            headers: {'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {'listacargo':listacargo,'cedula':$("#cedu").val()},
            success: function(res)
            {
            }
          }).fail( function( jqXHR, textStatus, errorThrown ) {
            message(jqXHR,{tipo:"danger"});
          });
          
          if(decision=='guardarv')//si desea guardar y ver el personal recien agregado
            location.href="/personalv/"+"1"+"/"+$("#cedu").val();
          if(decision=='guardar')//Si desea guardar e ingresar uno mas
          {
            message(["Se agrego el personal correctamente "],{manual:true})
            limpiar();
          }
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
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
        $("#"+elemento).prop('checked',false);
      }
      listacargo=new Object();
    }
    function mostrarfechanac()
    {
      if(year>0 && month>0 && day>0)
        $("#Fecha_Nac").val(year+"-"+month+"-"+day);
    }
  </script>  
@stop