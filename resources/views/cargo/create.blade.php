@extends('layouts.dashboard')
@section('content')
<div class="card" >
  <h4 class="card-header" >Agregar Cargo</h4>
  <div class="card-body">
    <div id="mensaje"></div>
    @include('alert.mensaje')
    <form id="data" >

        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
    
        <div class="row ">
            <div class="col-md-6">
                <div class="form-group">
                    {!!Form::label('Nombre del Cargo:')!!}
                    {!!Form::text('Nombre_Cargo',null,['id'=>'Nom', 'class'=>'form-control','placeholder'=>'ej: Conductor'])!!}
                    
                    <input type="text" style="display:none;">
                </div>
            </div>
        </div>
        <input class="btn btn-primary" type="button" value="Guardar" onclick="guardarcargo('guardar');">
        <input class="btn btn-primary" type="button" value="Guardar y ver" onclick="guardarcargo('guardarv');">
    </form>
  </div>
</div>   
<div class="card" id="cardA">
  <h4 class="card-header">Asignar cargo a personal</h4>
  <div id="msjtabla"></div>
  <div class="card-body text-center">

    <a class="btn btn-primary " href="#tablaB" onclick="add()">Agregar</a>
    <div class="row ">
      <div class="form-group">
      </div>
    </div>

    <!--TABLA A-->
    <div class="row bg-dark" style="color:White; visibility:hidden;" id="tablaA"> 
      <div class="col-md-4 " id="lc" style="height:30em; overflow:scroll; padding-left: 0px;">
        @include('cargo.listacargo.listacargo')
      </div>
      <div class="col-md-8" style="height:30em; overflow:scroll;padding-left: 0px; ">
        <div class="tab-content" id="nav-tabContent">
            <div  data-spy="scroll" class="tab-pane fade show active" role="tabpanel" >
              <table class="table table-hover table-dark" id="tablapersonal" cellspacing="0" style="width:100%;" >
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cedula</th>
                    <th class="text-center" data-orderable="false" ></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($personal as $persona)
                      <tr>
                        <td >{!!$persona->Nombre!!}</td>
                        <td >{!!$persona->Apellido!!}</td>
                        <td >{!!$persona->Cedula_Personal!!}</td>
                        <td class="btn-primary text-center">
                          <input type="checkbox" OnClick='addpersonal(this,"{!!$persona->Nombre!!}","{!!$persona->Apellido!!}","{!!$persona->Cedula_Personal!!}");'>
                        </td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>  

<div class="card" id="cardB" style="display:none;">
  <h4 class="card-header text-center">Visualizacion previa del personal con sus nuevos cargos</h4>
  <div class="card-body text-center">
    <!--TABLA B-->
    <div  id="tablaB"> 
      <div class="col-md-12" style=" overflow:scroll;padding-left: 0px;padding-right: 0px; ">
        <div class="tab-content" id="nav-tabContent">
            <div  data-spy="scroll" class="tab-pane fade show active" role="tabpanel" >
              <table class="table table-hover table-dark " >
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cedula</th>
                    <th>Cargo</th>
                  </tr>
                </thead>
                <tbody id="tb">
                </tbody>
              </table>
            </div>
        </div>
      </div>
      <div class="text-center">
        <a href="#" class="btn btn-primary" id="guardar" onclick="guardar();" >Guardar</a>
        <a href="#" class="btn btn-primary" onclick="retornar();" >Regresar</a>
      </div >
    </div>
  </div>
</div>

@stop
@section("script")
  {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
  {!!Html::script("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")!!} 
  {!!Html::script("https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js")!!} 
  {!!Html::script("js/jskevin/kavvdt.js")!!} 
  <script>

    
    $(document).ready( function () {
      createdt($("#tablacargos"),{dom:"f"});
      createdt($("#tablapersonal"),{dom:"f"});
      $("#tablaA").css("visibility", "visible");
  });

  //PARA MAYOR EFICIENCIA HACER UN OBJETO PRINCIPAL CON UNA COLECCION DE OBJETO(similar a un tree) para poder hacer una agregacion grande
  //ejemplo: agregar persona1 con cargo x,y. persona2 con cargo x,y pero persona 3 con cargo a,b al mismo tiempo.
    var listapersonal=new Object();
    var listacargo=new Object();
    //agregamos o eliminamos en la lista personal
    function addpersonal(elemento,nombre,apellido,cedula)
    {
      if(elemento.checked==true)
        listapersonal[cedula]=[nombre,apellido,cedula];
      else
        delete listapersonal[cedula];
    }
    //agregamos o eliminamos en la lista cargo
    function addcargo(elemento,cargo,key)
    {
      if(elemento.checked==true)
        listacargo[key]=[cargo,key];
      else
        delete listacargo[key];
    }
    function add()
    {
      if(!jQuery.isEmptyObject(listapersonal) && !jQuery.isEmptyObject(listacargo))
      {
        $("#cardA").hide();
        $("#tb").empty();
        $("#cardB").show();
        for(var obj in listapersonal)
        {
          $("#tb").append(function(){
            var cadena="<tr><td>"+listapersonal[obj][0]+"</td><td>"+listapersonal[obj][1]+"</td><td>"+listapersonal[obj][2]+"</td><td>";

            for(var objc in listacargo)
            {
              cadena+='"'+listacargo[objc][0]+'"  ';
            }
            cadena+="</td></tr>";
            console.log(cadena.slice(0,-1));
            return cadena;
          });

        }
      }
      
    }
    function guardar()
    {
      /*HACER FUNCIONAR ESTO*/
      var ruta = "/cargosave";
      var token = $("#token").val();
      console.log("entra");
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:{"listapersonal":listapersonal,"listacargos":listacargo},
        success: function(result)
        {
          console.log(result);
          if(result!=1)
          {
            message(result,{manual:true,objeto:$("#msjtabla"),tipo:'danger'});
          }
          else
          {
            message(["Cargos asignados correctamente"],{manual:true,objeto:$("#msjtabla")})
          }          
          retornar();
          return;
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
        console.log(jqXHR.responseJSON);
        message(jqXHR,{tipo:"danger"});
      });
    }

    function guardarcargo(decision)
    {

      /*HACER FUNCIONAR ESTO*/
      var ruta = "/cargo";
      var token = $("#token").val();
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:$("#data").serialize(),
        success: function(result){
          if(result==1)
          {
            if(decision=="guardar")
            {
              message(["Se agrego el cargo correctamente"],{manual:true});
              recargalista();
            }
            if(decision=="guardarv")
            {
              location.href="/cargov/1/"+$("#Nom").val();
            }
          }
          else
          {
            message(["El nombre del cargo ya existe"],{manual:true,tipo:"danger"});
          }
          return;
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
        message(jqXHR,{tipo:"danger"});
        
      });
    }
    function recargalista()
    {
      ruta="/listacargo";
      $.get(ruta,function(res){
        $("#lc").empty();
        $("#lc").append(res);
        createdt($("#tablacargos"),{dom:"f"});
        $("#cardA").show();
        $("#cardB").hide();
        $("#Nom").val("");
        listacargo=new Object();
      });
    }
    function retornar()
    {
      $("#cardA").show();
      $("#cardB").hide();
    }
  </script>
@stop