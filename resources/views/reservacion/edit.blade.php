@extends('layouts.dashboard')
@section('content')
  <!--Referencias para el calendario-->
  {!!Html::style("http://code.gijgo.com/1.5.1/css/gijgo.css")!!}
  <form action="{{route('reservacion.store')}}" method="POST" id='formulario' target="_blank">
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="false" >
      <div class="carousel-inner">
        <div id="parte1" class="carousel-item active">
          <div class="card">
            <h4 class="card-header">Reservar</h4>
            <div class="card-body">
              @include('alert.errores')
              <div id="mensajereserva"></div>
              <div class="row ">
                <div class="col-md-3 "></div>
                <div class="col-md-6 ">
                  <div class="form-group text-center">
                    {!!Form::label('Cedula','Cedula:')!!}
                    {!!Form::text('Cedula_Cliente',$reservacion->Cedula_Cliente,['id'=>'Cedu','class'=>'form-control','placeholder'=>'xxx-xxxxxx-xxxxx', 'onkeypress="return cedulanica(event,this);"','onkeyup="formatonica(this); buscar(this);"'])!!}
                  </div>
                </div>
              </div>
              <div class="row ">
                <div class="col-md">
                  <div class="form-group">
                      {!!Form::label('Nombre:')!!}
                      {!!Form::text('Nombre_Contacto',$reservacion->Nombre_Contacto,['id'=>'Nom','class'=>'form-control','placeholder'=>'Nombre completo'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md">
                  <div class="form-group">
                      {!!Form::label('Direccion del evento:')!!}
                      {!!Form::text('Direccion_Local',$reservacion->Direccion_Local,['id'=>'Dir','class'=>'form-control','placeholder'=>'Direccion donde se realizara el evento'])!!}
                  </div>
                </div>
              </div> 

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      {!!Form::label('Fecha de Inicio:')!!}
                      <input id="datepicker" width="276" value="{!!$reservacion->Fecha_Inicio!!}" disabled/> 
                      <input type="hidden" id="dp1" value="{!!$reservacion->Fecha_Inicio!!}" name="Fecha_Inicio" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {!!Form::label('Fecha de Fin:')!!}
                      <input id="datepicker2" width="276" value="{!!$reservacion->Fecha_Fin!!}" disabled /> 
                      <input type="hidden" id="dp1" value="{!!$reservacion->Fecha_Fin!!}" name="Fecha_Fin" >
                  </div>
                </div>
              </div>
            </div>

          </div>

            <!--TENGO QUE AGREGAR LO QUE EL USUARIO APARTO PARA ESE DIA-->

          <div id="tablas" style="display:none;">
            <div class="row tablaA" style="" >
              <div class="col-md-4">
                <div class="list-group" id="list-tab" role="tablist" style="height:20em; overflow:scroll;">
                  <table id="tablaservicios" cellspacing="0" style="width:102%;">
                    <thead>
                      <th class="text-center">Servicios</th>
                    </thead>
                    <tbody>
                      @foreach($servicios as $servicio)
                        <tr><td>
                          <a class="list-group-item list-group-item-action serviciobuscar" id='{!!$servicio->ID_Servicio!!}' data-toggle="list" href='#panelarticulo'>{!!$servicio->Nombre!!}</a>
                        </td></tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/*PERFECCIONAR LA TABLA ESPECIFICAR UN ALTO ESTATICO PARA CADA DIRECCION Y UN SCROLL EN "Y"*/-->
              <div class="col-md-8 tablaA" style="height:20em; overflow:scroll; ">
                <div class="tab-content" id="nav-tabContent">
                  <div  data-spy="scroll" class="scrollspy-example tab-pane fade"data-target="#list-tab" data-offset="0" id="panelarticulo" role="tabpanel" aria-labelledby="{!!$servicio->ID_Servicio!!}">
                    {!!$articulo!!}
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4" ></div>
                <button type="button" id="btnmenu" class="btn btn-success col-md-4" data-toggle="modal" data-target="#serviespecial" >Servicio de comida</button>
              
            </div>
            <!--Tabla de articulos reservados-->
            <input type="hidden" id="contf" value=0>
            <input type="hidden" id="dias">
            <table class="table table-hover TablaA" id="TablaA"  style="width: 100%">
              <thead>
                <tr id="fila0" value="0">
                  <th >Nombre</th>
                  <th data-orderable="false">Cantidad</th>
                  <th data-orderable="false">Costo Alquiler</th>
                  <th data-orderable="false">Dias Alquilados</th>
                  <th data-orderable="false">Costo Total</th>
                  <th data-orderable="false"></th>
                </tr>
              </thead>
              <tbody id="articuloren">
              </tbody>
            </table>
          </div>
          <button type="button" class="btn btn-primary btn-lg btn-block"OnClick='Enviar();' id="reser">Actualizar</button> 
        </div> 

        <!--Segunda parte (Pre visualizacion de los datos finales)-->
        <div id="parte2" class="carousel-item">
          <div class="card">
            <h4 class="card-header">Reservar</h4>
            <div class="card-body">
              <button type="button" class="btn btn-primary float-right" OnClick='CambioPag();'>Regresar</button>
              <div class="row ">
                <div class="col-md">
                  <div class="form-group">
                      {!!Form::label('DD','',['id'=>'lf','class' => 'badge badge-pill badge-info'])!!}
                  </div>
                </div>
              </div>

              <div class="row ">
                <div class="col-md-6 ">
                  <div class="form-group">
                      {!!Form::label('','Cliente:')!!}
                      {!!Form::label('','Nombre:',['id'=>'lnom','class' => 'badge badge-pill badge-info'])!!}
                      {!!Form::label('','/')!!}
                      {!!Form::label('','Cedula:',['id'=>'lce','class' => 'badge badge-pill badge-info'])!!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md">
                  <div class="form-group">
                      {!!Form::label('','Direccion: ')!!}
                      {!!Form::label('','',['id'=>'ldir','class' => 'badge badge-pill badge-info'])!!}
                  </div>
                </div>
              </div> 

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      {!!Form::label('','Fecha de Inicio: ')!!}
                      {!!Form::label('','',['id'=>'lfi','class' => 'badge badge-pill badge-info'])!!}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {!!Form::label('','Fecha de Fin: ')!!}
                      {!!Form::label('','Fecha de Fin:',['id'=>'lff','class' => 'badge badge-pill badge-info'])!!}
                  </div>
                </div>
              </div> 

              
              <div class="row">
                <div  class="input-group">
                  <!-- botones para definir la longitud de la factura -->
                  <div class="col col-md-6" style="display:flex; justify-content:flex-start">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><b>Filas de la factura</b></span>
                    </div>
                    <input type="text" id="filafactura" value="{!!$reservacion->rowfac!!}" class="form-control col-md-2 text-center" aria-label="Text input with checkbox">
                    <div class="input-group-append">
                      <button class="btn btn-info " onclick="tablafactura();" type="button">Aplicar</button>
                    </div>
                  </div>
                  <!-- botones para definir el iva-->
                  <div class="col col-md-6" style="display:flex; justify-content:flex-end">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        @if($reservacion->iva==0)
                          <input type="checkbox" id="iva">
                        @else
                          <input type="checkbox" id="iva" checked>
                        @endif
                        <label class="form-check-label badge badge-pill badge-info" for="defaultCheck1">
                            IVA
                        </label>
                      </div>
                    </div>
                    <input type="text" id="valoriva" value="{!!$reservacion->iva*100!!}" class="form-control col-md-2 text-center" aria-label="Text input with checkbox">
                    <div class="input-group-append">
                      <span class="input-group-text"><b>%</b></span>
                      <button class="btn btn-info" onclick="eliminardetalles();"  type="button">Aplicar</button>
                    </div>
                  </div>
                </div>
                <!-- botones para seleccionar las factura-->
                <div class="input-group">                
                  <div class="col col-md-12" style="display:flex; justify-content:center">
                    <div class="input-group-prepend">
                      <button class="btn btn-info fa fa-angle-left" onclick="cambiofac(-1);" type="button"></button>
                    </div>
                    <span class="input-group-text"><b id="numfac">Factura #1</b></span>
                    <div class="input-group-append">
                      <button class="btn btn-info fa fa-angle-right" onclick="cambiofac(1);" type="button"></button>

                      <button class="btn btn-info fa fa-print" style="margin-left: 1px;" onclick="" type="submit"></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md">
                  <div class="form-group">
                    <table class="table table-hover text-center" id="tablaB" name="TB">
                      <thead>
                        <tr id="fila0"  value="0">
                          <th>Nombre</th>
                          <th>Cantidad</th>
                          <th>Costo Alquiler</th>
                          <th>Dias Alquilados</th>
                          <th>Costo Total</th>
                        </tr>
                      </thead>
                      <tbody  id="artifin">
                      </tbody>
                    </table>   
                    <input class="btn btn-primary btn-lg btn-block" type="button" value="Actualizar" Onclick='reservaupdate();' > 
                  </div>
                </div>
              </div> 
              <input type="hidden" id="arre" name="lista" value=" ">
              <input type="hidden" id="ac" name="accion" value=" ">
              <input type="hidden" id="facactual" name="facactual" value="0">
              
              
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal para añadir la cantidad de articulos -->
  <div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Cuanto desea reservar?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
          <input type="hidden" id="id">
          <div id="mensajearticulo"></div>
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="0" id="manual" name="sinimagen">
                <label class="form-check-label " for="defaultCheck1">
                    Automatico (No recomendado)
                </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
                {!!Form::label('Cantidad:')!!}
            </div>
            <div class="col-md-10">
                {!!Form::text('Cantidad',null,['id'=>'cant','class'=>'form-control','autocomplete'=>'off','onkeypress'=>'return valida(event)'])!!}
            </div>
          </div>
          <div class="row" id="rowprice" style="visibility:hidden;">
            <div class="col-md-2">
                {!!Form::label('Precio:')!!}
            </div>
            <div class="col-md-10">
                {!!Form::text('Precio',null,['id'=>'precio','class'=>'form-control','autocomplete'=>'off','onkeypress'=>'return valida(event)'])!!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          {!!link_to('#TablaA',$title='Añadir',$attributes=['id'=>'anadir','class'=>'btn btn-primary','onclick'=>'AddToListArticulo();'],$secure = null)!!}
        </div>
      </div>
    </div>
  </div>
  <!-- Modal para añadir una comida o un pedido especial-->
  <div class="modal fade bd-example-modal-lg" id="serviespecial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Reserva especial</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token2">
          <input type="hidden" id="id2">
          <input type="hidden" id="returnLista">
          <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="false">
            <div class="carousel-inner">
            <!-- Aplicar un tamaño de altura, refrescar el menu al agregar, mostrar msjs -->
              <div id="menuparte1" class="carousel-item active">
                <div class="row" style="height:50em">
                  <div id="menuLista" class="col-md-12" style="overflow-y:scroll;">
                    @include('reservacion.menu.menu')
                  </div>
                </div>
              </div>
              <div id="menuparte2" class="carousel-item">
                @include('reservacion.menu.añadir')
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="display: flex; justify-content:center">
        
          <input id="btnGuardarComida" class="btn btn-success" type="button" style="display:none;" onclick="save('guardar');" value="Guardar">
          {!!link_to('#TablaA',$title='Agregar nuevo plato',$attributes=['onclick'=>'CambioPagMenu();','class'=>'btn btn-primary', 'id'=>'btnCambio'],$secure = null)!!}
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
  <div id="factura" ></div>
@stop
@section('script')
  {!!Html::script("js/jskevin/cedulanica.js")!!} 
  {!!Html::script("js/js/gijgo/gijgo.js")!!}
  {!!Html::script("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")!!} 
  {!!Html::script("https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js")!!} 
  {!!Html::script("js/jskevin/tiposmensajes.js")!!}  
  {!!Html::script("js/js/articuloadd.js")!!}
  <script>
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
    });
    $('#datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
    });
    $('#Calen').click(function(){
      /*alert('focus');*/
        $('#Cal').focus();
    });
    /*Estaba quitando el calendario cuando diera  click en algun lugar q no sea el mismo(pendiente*/
    $('#Cal').blur(function(){
      /*alert('entro');*/
      return;
    });
  
    var autocompletado=false;
    function buscar(cedula)
    {
      var ruta="/cliente/"+cedula.value;
      var token=$("#token").val();
      autocompletado=false;
        $.ajax({
            url: ruta,
            headers:{'X-CSRF-TOKEN': token},
            type: 'GET',
            dataType: 'json',
            success: function(){
                autocompletado=true;
                autocompletar(cedula.value);
            }
        });
        if(autocompletado==false)
        {
          $("#Nom").val("");
        }
    }
    function limpiarCliente()
    {
      $("#Cedu").val("");
      $("#Nom").val("");
      $("#Dir").val("");
    }
    function autocompletar(cedula)
    {
      var ruta="/cliente/"+cedula;
      $.get(ruta, function(res){
            $("#Nom").val(res.Nombre+ " " +res.Apellido);
        });
    }
    $('#datepicker').on( 'change', function (){
      $("#dp1").val($('#datepicker').val());
      SuccessDay();
    });
    $('#datepicker2').on( 'change', function (){
      $("#dp2").val($('#datepicker2').val());
      SuccessDay();
    });
    function SuccessDay()
    {
      if(dias())
      {
        $("#dias").val(diff);
        $("#tablas").show();
        CargarTablaArticulo();
        diastabla();
        $( "#reser" ).prop('disabled',false);
      }
      else
      {
        $("#tablas").hide();
        $( "#reser" ).prop('disabled',true);
      }
    }
    var diff;
    //Evalua si la diferencia de dias es valida
    function dias()
    {
      var fechaInicio = new Date($("#datepicker").val()).getTime();
      var fechaFin    = new Date($("#datepicker2").val()).getTime();

      diff = fechaFin - fechaInicio;
      diff=diff/(1000*60*60*24);
      console.log(diff);
      if(diff==0)
        diff=1;
      if(diff>=1)
        return true;
      else
        return false;
    }
    function CargarTablaArticulo()
    {
      ruta="/recargaarticulos/"+$("#datepicker").val()+"/"+$("#datepicker2").val();
      columArticulos=[{"targets": [ 4 ],"visible": false}];
      $.get(ruta,function(res){
        $("#panelarticulo").empty();//Limpiamos el div
        $("#panelarticulo").append(res);//Agregamos la tabla
        Tarti=createdt($('#tablaarti'),{buscar:'',columdef:columArticulos,searchC:4});//Datatable articulos
        Tarti.column(4).search(busqueda).draw();//Hacemos filtros por columna
        for(i=0; i<TA.rows().count(); i++)
        {
          TA.cell(i,1).data(0);
          TA.cell(i,4).data(0);
        }
      });
    }
    //ARREGLAR ESTO USAR LA DATATABLE
    function diastabla()
    {
      //recorremos cada una de las filas
      for(var i=0; i<TA.rows().count() ;i++)
      {
        cant=TA.rows(i).data()[0][1];
        costo=TA.rows(i).data()[0][2];
        TA.cell(i,3).data(diff);//establecemos la nueva cantidad de dias
        TA.cell(i,4).data(cant*costo*diff);//Establecemos el total
      }
    }
    
    function valida(e){
        tecla = (document.all) ? e.keyCode : e.which;

        //Tecla de retroceso para borrar, siempre la permite
        if (tecla==8){
            return true;
        }
            
        // Patron de entrada, en este caso solo acepta numeros
        patron =/[0-9]/;
        console.log(patron);
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    
    var table,TA,Tarti;
    var fila;
    var data;
/*           { className:"comidades", "targets": [ 1 ] },
          { className:"comidacos", "targets": [ 2 ] },
          { className:"comidacant", "targets": [ 3 ] },
          { className:"botones", "targets": [ 4 ] } */
          var descripcion;
    $(document).ready( function () {
      //Cargamos las tablas de articulos
      columArticulos=[{"targets": [ 4 ],"visible": false}];
      Tarti=createdt($('#tablaarti'),{buscar:'',columdef:columArticulos,searchC:4});//Datatable articulos
      //Cargamos los dias
      dias();
      $("#dias").val(diff);
      inicializarfun();
      createdt($('#tablaservicios'));//Datatable servicio
      //columArticulos=[{"targets": [ 4 ],"visible": false}]
      //Tarti=createdt($('#tablaarti'),{columdef:columArticulos});//Datatable articulos
      TA=createdt($("#TablaA"),{dom:"",ordering:false});//Datatable lista articulos solicitados
      columMenu=[{ className:"comidades", "targets": [ 1 ] },
          { className:"comidacos", "targets": [ 2 ] },
          { className:"comidacant", "targets": [ 3 ] },
          { className:"botones", "targets": [ 4 ] }];
      ////Datatable menu
      table=createdt($('#tablamenu'),{pagT:"first_last_numbers",col:1,dom:'"fp"',cant:[5],cantT:["5"],columdef:columMenu});
      descripcion=({!!json_encode($descripcion)!!});
      for(i=0; i<descripcion.length; i++)
      {
        Farticulo=Tarti.row('tr[id=artiCant'+descripcion[i].ID_Objeto+']').node();
        articulo = Tarti.row(Farticulo).data();
        AddToList({Tabla:TA,articulo:articulo,cantAdd:descripcion[i].Cantidad,id:descripcion[i].ID_Objeto});
      }
      descripcion=({!!json_encode($desmenu)!!});
      console.log(descripcion);
      for(i=0; i<descripcion.length; i++)
      {
        Farticulo=table.row('tr[id=menucant'+descripcion[i].id+']').node();
        articulo = table.row(Farticulo).data();
        AddToList({Tabla:table,articulo:articulo,cantAdd:descripcion[i].Cantidad,indexname:1,tipo:"Menu",id:descripcion[i].id});
      }
       
      //Tarti.row('tr[id=artiCant'+78+']').node()
      $("#tablas").show();
    });
    function inicializarfun()
    {
      $(".menuadd").on( 'click', function () {
        data = table.row( $(this).parents('tr') ).data();
        var tabla=$("#articuloren");
        var cant = $("#menucant"+$(this).val()).val()*1;
        var id = $(this).val();
        if(tabla.children('tr[id="plato'+ id +'"]').length!=0)
        {
          cant += tabla.children('tr[id="plato'+ id +'"]').children('td[class="itemaddcant"]').text()*1;
          tabla.children('tr[id="plato'+ id +'"]').children('td[class="itemaddcant"]').text(cant);
          tabla.children('tr[id="plato'+ id +'"]').children('td[class="costoT"]').text((cant) * (data[2]*1) * ($("#dias").val()*1));
        }
        else
        {
          tabla.append(
            "<tr id=\"plato"+id+"\">"+
              "<td>"+data[1]+"</td>"+
              "<td class=\"itemaddcant\">"+cant+"</td>"+
              "<td>"+data[2]+"</td>"+
              "<td>"+$("#dias").val()+"</td>"+
              "<td class=\"costoT\"> "+(cant) * (data[2]*1) * ($("#dias").val()*1)+"</td>"+
              "<td><button value=plato"+id+" OnClick='Eliminar(this);' class='btn btn-danger'>Eliminar</button></td>"+
            "</tr>"
          );
        }
        message(["Se agrego a la lista!"],{objeto:$("#mensajemenu"),manual:true});
        location.href="#mensajemenu";
        /* var item=$(this).parent('td').parent('tr');
        var cant=item.children('td[class=" comidacant"]').children().val();
        var tabla=$("#articuloren");
        tabla.append("<tr id=\"plato"+$(this).val()+"\"><td>"+item.children('td[class=" comidades "]').text()+"</td><td class=\"itemaddcant\">"+cant+"</td><td>"+item.children('td[class=" comidacos"]').text()+"</td><td>"+$("#dias").val()+"</td><td> "+(cant*(item.children('td[class=" comidacos"]').text()*1)*$("#dias").val())+"</td><td><button value=plato"+$(this).val()+" OnClick='Eliminar(this);' class='btn btn-danger'>Eliminar</button></td></tr>");
        location.href="#TablaA";  */
      });
    }

    function createdt(objeto,{buscar="",pagT="full_numbers",col=0,com="asc",sx=true,dom='"f"',cant=[-1],cantT=["Todo"],columdef=[],ordering=true,searchC}={})
    {
      return objeto.DataTable({
        "destroy": true,
        "pagingType": pagT,//botones primero, anterio,siguiente, ultimo y numeros
        "order": [[col,com]],//ordenara por defecto en la columna Nombre de forma ascendente
        "scrollX": sx,//Scroll horizontal
        "dom": dom,
        "language": {//Cambio de idioma al español
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontro ningun registro",
            "info": "Pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros",
            "infoFiltered": "(Filtrado entre _MAX_ total registro)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "paginate": {
                "first": "Primera",
                "last": "Ultima",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending":  ": activar para ordenar la columna ascendente",
                "sortDescending": ": activar para odenar la columna descendente"
            },
            //Especificamos como interpretara los puntos decimales y los cientos
            "decimal": ".",
            "thousands": ","
        },
        //Definimos la cantidad de registros que se podran mostrar
        //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
        "lengthMenu": [cant, cantT],
        "columnDefs": columdef,
        "ordering": ordering,
      }).search(buscar).draw();
    }

    //JS DEL MENU
    function CambioPagMenu()
    {
        console.log(table);
        if($("#menuparte1").hasClass('active'))
        {
          $("#btnGuardarComida").css("display","block");
          $("#btnCambio").text("Regresar al Menu");
          $("#menuparte1").removeClass("active");
          $("#menuparte2").addClass("active");
        }
        else
        {
          $("#btnGuardarComida").css("display","none");
          $("#btnCambio").text("Agregar nuevo plato");
          $("#menuparte2").removeClass("active");
          $("#menuparte1").addClass("active");
        }
    }
    //Guardar el nuevo plato
    function save(decision)
    {
      var ruta = "/reservamenu";
      var token = $("#tokenmenu").val();
      var formData = new FormData($('#datamenu')[0]);
      console.log(formData);
      message(["Guardando... por favor espere"],{objeto:$("#mensajemenuc"),manual:true})
      $("#btnGuardarComida").attr("disabled",true);
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:formData,
        contentType: false,
        processData: false,
        success: function(result){
          if(decision=="guardar")
          {
            RecargarMenu(result);
            limpiarMenu();
            CambioPagMenu();
            $("#btnGuardarComida").attr("disabled",false);
          }
          console.log("agregado");
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
          message(jqXHR,{objeto:$("#mensajemenuc"),tipo:"danger"});
      });

    }
    function limpiarMenu()
    {
      $("#descripcion").val("");
      $("#costo").val("");
      $("#path").val("");
      $("#imagen").empty();
    }
    //Vista previa de la imagen
    $('#path').change(function(e) {
        addImage(e); 
    });
    var file;
    function addImage(e){
        file = e.target.files[0],
        imageType = /image.*/;
        
        if (!file.type.match(imageType))
        return;
    
        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    }
    var result;//USAR ESTO PARA MOSTRAR DIRECTAMENTE LA IMAGEN SIN TENER QUE CARGARLA DESDE LA NUBE
    function fileOnload(e) {
      result=e.target.result;
      $("#imagen").empty();
      $("#imagen").append('<image class="col-md-10" style="border-radius: 40px;" src="'+result+'">');
    }
    
    function RecargarMenu(contenido)
    {
      /* $("#menuLista").empty();
      $("#menuLista").append(contenido["html"]); */
      newRow = table.row.add(
      [
        '<img src="https://s3.us-east-2.amazonaws.com/pruebakavv/Menu/'+contenido["path"]+'" style="height:10em;border-radius: 40px;" value="">',
        contenido["descripcion"],
        contenido["costo"],
        '<input type="text" onkeypress="return valida(event);" class="form-control" style="width:100%" id="c_menucant'+contenido["id"]+'">',
        '<button class="btn btn-success" onclick="AddToListMenu(this)" value="'+contenido["id"]+'">Añadir</button>'
      ]);
      table.search(contenido["descripcion"]).draw();
      inicializarfun();
      message(["Guardado correctamente!"],{objeto:$("#mensajemenu"),manual:true})
      
    }
    var senddata={};
    function reservaupdate()
    {
      ruta = "/reserva/"+{!!$reservacion->ID_Reservacion!!};
      token = $("#token").val();//Dir, Nom,datepicker2
      senddata = {
                  "Cedula_Cliente":$("#Cedu").val(), 
                  "Nombre_Contacto":$("#Nom").val(),
                  "Direccion_Local":$("#Dir").val(),
                  "Fecha_Inicio": $("#datepicker").val(),
                  "Fecha_Fin": $("#datepicker2").val(),
                  "accion": "guardar",
                  "lista": A,
                };
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:senddata,
        success: function(result){
          RecargarReserva();
          message(["Actualizado correctamente!"],{objeto:$("#mensajereserva"),manual:true})
          location.href="#mensajereserva";
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
          message(jqXHR,{objeto:$("#mensajemenuc"),tipo:"danger"});
      });
    }
    function RecargarReserva()
    {
      CambioPag();
    }
    function abrirEnPestana(url) {
      var a = document.createElement("a");
      a.target = "_blank";
      a.href = url;
      a.click();
	  }
    var busqueda="";
    $(".serviciobuscar").on('click',function(){
      busqueda=$(this)[0].id+"servicio";
      Tarti.column(4).search(busqueda).draw();
      $("#panelarticulo").show();  
      console.log("mostrar");
    });
    $("#manual").on("click",function(){
      if($("#manual").prop('checked')==true)
      {
          $("#rowprice").css('visibility','visible');
      }
      else
      {
          $("#rowprice").css('visibility','hidden');
      }
    });

  </script>


@stop