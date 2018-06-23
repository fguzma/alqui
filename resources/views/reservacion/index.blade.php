@extends('layouts.dashboard')
@section('content')
  <!--Referencias para el calendario-->
  {!!Html::style("http://code.gijgo.com/1.5.1/css/gijgo.css")!!}
  <form action="{{route('reservacion.store')}}" method="POST" id='formulario' target="_blank" >
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="false">
      <div class="carousel-inner">
        <div id="parte1" class="carousel-item active">
          <div class="card">
            <h4 class="card-header">Reservar</h4>
            <div class="card-body">
              @include('alert.errores')
              @include('alert.mensaje')
              <div class="row ">
                <div class="col-md-3 "></div>
                <div class="col-md-6 ">
                  <div class="form-group text-center">
                    {!!Form::label('Cedula','Cedula:')!!}
                    {!!Form::text('Cedula_Cliente',$cliente['Cedula_Cliente'],['id'=>'Cedu','class'=>'form-control','placeholder'=>'xxx-xxxxxx-xxxxx', 'onkeypress="return cedulanica(event,this);"','onkeyup="formatonica(this); buscar(this);"'])!!}
                  </div>
                </div>
              </div>
              <div class="row ">
                <div class="col-md">
                  <div class="form-group">
                      {!!Form::label('Nombre:')!!}
                      {!!Form::text('Nombre_Contacto',$cliente['Nombre'].$cliente['Apellido'],['id'=>'Nom','class'=>'form-control','placeholder'=>'Nombre completo'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md">
                  <div class="form-group">
                      {!!Form::label('Direccion del evento:')!!}
                      {!!Form::text('Direccion_Local',null,['id'=>'Dir','class'=>'form-control','placeholder'=>'Direccion del personal'])!!}
                  </div>
                </div>
              </div> 

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      {!!Form::label('Fecha de Inicio:')!!}
                      <input id="datepicker" width="276" name="Fecha_Inicio"/> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {!!Form::label('Fecha de Fin:')!!}
                      <input id="datepicker2" width="276" name="Fecha_Fin" /> 
                  </div>
                </div>
              </div>
            </div>

          </div>

            <!--TENGO QUE AGREGAR LO QUE EL USUARIO APARTO PARA ESE DIA-->


          <div class="row tablaA" style="display:none;" >
            <div class="col-md-4">
              <div class="list-group" id="list-tab" role="tablist" style="height:20em; overflow:scroll;">
              <table id="tablacargo" class="table" cellspacing="0" style="width:102%;">
                <thead>
                  <th class="text-center">Servicios</th>
                </thead>
                <tbody>
                  @foreach($servicios as $servicio)
                    <tr><td>
                      <a class="list-group-item list-group-item-action" id='{!!$servicio->ID_Servicio!!}' data-toggle="list" href='#{!!$servicio->Nombre!!}' role="tab" aria-controls="{!!$servicio->Nombre!!}">{!!$servicio->Nombre!!}</a>
                    </td></tr>
                  @endforeach
                </tbody>
              </table>
              </div>
            </div>
            <!--/*PERFECCIONAR LA TABLA ESPECIFICAR UN ALTO ESTATICO PARA CADA DIRECCION Y UN SCROLL EN "Y"*/-->
            <div class="col-md-8 tablaA" style="height:20em; overflow:scroll; display:none;">
              <div class="tab-content" id="nav-tabContent">
                @foreach($servicios as $servicio)
                  <div  data-spy="scroll" class="scrollspy-example tab-pane fade"data-target="#list-tab" data-offset="0" id="{!!$servicio->Nombre!!}" role="tabpanel" aria-labelledby="{!!$servicio->ID_Servicio!!}">
                    <table class="table table-hover datos" style="width:100%;">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Cantidad</th>
                          <th>Costo Alquiler</th>
                          <th class="text-center" data-orderable="false" style="width:10%"></th>
                        </tr>
                      </thead>
                      <tbody id="tablaarticulos">
                        @foreach($inventario as $item)
                          @if($item->ID_Servicio===$servicio->ID_Servicio)
                            <tr id="{!!$item->ID_Objeto!!}">
                              <td class="itemname">{!!$item->Nombre!!}</td>
                              <td class="can">{!!$item->Cantidad!!}</td>
                              <td class="cost">{!!$item->Costo_Alquiler!!}</td>
                              <td>
                                <button  value="{!!$item->ID_Objeto!!}" type="button" class="btn btn-primary reser mostrar" data-toggle="modal" data-target="#Add"  >Reservar</button>
                              </td>
                            </tr>
                          @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4" ></div>
              <button type="button" class="btn btn-success col-md-4" data-toggle="modal" data-target="#serviespecial" >Servicio de comida</button>
            
          </div>
          <!--Tabla de articulos reservados-->
          <input type="hidden" id="contf" value=0>
          <input type="hidden" id="dias">
          <table class="table table-hover" id="TablaA"  style="display:none;">
            <thead>
              <tr id="fila0" value="0">
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Costo Alquiler</th>
                <th>Dias Alquilados</th>
                <th>Costo Total</th>
              </tr>
            </thead>
            <tbody id="articuloren">
            </tbody>
          </table>
          <button type="button" class="btn btn-primary btn-lg btn-block"OnClick='Enviar();' disabled id="reser">Reservar</button> 
        </div> 

        <!--Segunda parte (Pre visualizacion de los datos finales)-->
        <div id="parte2" class="carousel-item">
          <div class="card">
            <h4 class="card-header">Reservar</h4>
            <div class="card-body">
              <button type="button" class="btn btn-primary float-right" OnClick='CambioPag();'>Regresar</button>
              <button type="submit" class="btn btn-primary float-right mr-2" Onclick='Imprimir("imprimir");'>Imprimir</button> 
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
                <div class="col-md">
                  <div class="form-group">
                    <table class="table table-hover" id="tablaB" name="TB">
                      <thead>
                        <tr id="fila0" value="0">
                          <th>Nombre</th>
                          <th>Cantidad</th>
                          <th>Costo Alquiler</th>
                          <th>Dias Alquilados</th>
                          <th>Costo Total</th>
                        </tr>
                      </thead>
                      <tbody id="artifin">
                      </tbody>
                    </table>   
                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Ingresar Reserva" Onclick='Imprimir("guarda");' > 
                  </div>
                </div>
              </div> 
              <input type="hidden" id="arre" name="puto" value=" ">
              <input type="hidden" id="ac" name="accion" value=" ">
              
              
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
          <div class="row ">
            <div class="col-md-2">
                {!!Form::label('Cantidad:')!!}
            </div>
            <div class="col-md">
                {!!Form::text('Cantidad',null,['id'=>'cant','class'=>'form-control','autocomplete'=>'off','onkeypress'=>'return valida(event)'])!!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {!!link_to('#TablaA',$title='Añadir',$attributes=['id'=>'anadir','class'=>'btn btn-primary'],$secure = null)!!}
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
          <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="false">
            <div class="carousel-inner">
              <div id="menuparte1" class="carousel-item active">
                @include('reservacion.menu.menu')
                <div class="text-center">
                  {!!link_to('#TablaA',$title='Agregar nuevo plato',$attributes=['onclick'=>'CambioPagMenu();','class'=>'btn btn-primary'],$secure = null)!!}
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              <div id="menuparte2" class="carousel-item">
                @include('reservacion.menu.añadir')
                <div class="text-center">
                  <input class="btn btn-success" type="button"  onclick="save('guardar');" value="Guardar">
                  {!!link_to('#TablaA',$title='Regresar al menu',$attributes=['onclick'=>'CambioPagMenu();','class'=>'btn btn-primary'],$secure = null)!!}
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        

        </div>
      </div>
    </div>
  </div>
@stop
@section('script')
  {!!Html::script("js/jskevin/cedulanica.js")!!} 
  {!!Html::script("js/js/gijgo/gijgo.js")!!}
  {!!Html::script("js/js/articuloadd.js")!!}
  {!!Html::script("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")!!} 
  {!!Html::script("https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js")!!} 
  {!!Html::script("js/jskevin/tiposmensajes.js")!!}  
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
      var ruta="https://alqui.herokuapp.com/cliente/"+cedula.value;
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
    function autocompletar(cedula)
    {
      var ruta="https://alqui.herokuapp.com/cliente/"+cedula;
      $.get(ruta, function(res){
            $("#Nom").val(res.Nombre+ " " +res.Apellido);
        });
    }
    $('#datepicker').on( 'change', function (){
      if(dias())
      {
        $("#dias").val(diff);
        $(".tablaA").show();
        $("#TablaA").show();
        diastabla();
        $( "#reser" ).prop('disabled',false);
      }
      else
      {
        $(".tablaA").hide();
        $( "#reser" ).prop('disabled',true);
        $("#TablaA").hide();
      }
      
    });
    $('#datepicker2').on( 'change', function (){
      if(dias())
      {
        $("#dias").val(diff);
        $(".tablaA").show();
        $("#TablaA").show();
        diastabla();
        $( "#reser" ).prop('disabled',false);
      }
      else
      {
        $(".tablaA").hide();
        $( "#reser" ).prop('disabled',true);
        $("#TablaA").hide();
      }
    });
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
    function diastabla()
    {
      var T= $("#articuloren").children('tr');
      var ct=0;
      T.each(function(){
        console.log("entro");
        $(this).children('td').each(function(index){
          switch (index) {
            case 1:
              ct=$(this).text()*1;
              console.log(ct);
              break;
            case 2:
              ct*=$(this).text()*1;
              console.log(ct);
              break;
            case 3:
              ct*=diff;
              $(this).text(diff);
              console.log(ct);
              break;
            case 4:
              $(this).text(ct);
              break;
          }
        })
      });
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

    
    var table;
    var fila;
    $(document).ready( function () {
      createdt($('#tablacargo'));
      createdt($('.datos'));
    });
    function createdt(objeto)
    {
      objeto.DataTable({
      "pagingType": "full_numbers",//botones primero, anterio,siguiente, ultimo y numeros
      "order": [[ 0, "asc" ]],//ordenara por defecto en la columna Nombre de forma ascendente
      "scrollX": true,//Scroll horizontal
      "dom": 'f',
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
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
      });
    }

    //JS DEL MENU
    function CambioPagMenu()
    {
        if($("#menuparte1").hasClass('active'))
        {
          console.log();
            $("#menuparte1").removeClass("active");
            $("#menuparte2").addClass("active");
        }
        else
        {
            $("#menuparte2").removeClass("active");
            $("#menuparte1").addClass("active");
        }
    }
    //Guardar el nuevo plato
    function save(decision)
    {
      var ruta = "https://alqui.herokuapp.com/menus";
      var token = $("#tokenmenu").val();
      var formData = new FormData($('#datamenu')[0]);
      console.log(formData);
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
            message(["Se agrego el menu correctamente correctamente"],{objeto:$("#mensajemenuc"),manual:true})
            limpiar();
          }

          console.log("agregado");
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
          message(jqXHR,{objeto:$("#mensajemenuc"),tipo:"danger"});
      });
    }
    function limpiar()
    {
      $("#descripcion").val("");
      $("#costo").val("");
      $("#path").val("");
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
    $(".menuadd").on( 'click', function () {
      var item=$(this).parent('td').parent('tr');
      var cant=item.children('td[class="comidacant"]').children().val();
      var tabla=$("#articuloren");
      tabla.append("<tr id=plato\""+id+"\"><td>"+item.children('td[class="comidades"]').text()+"</td><td class=\"itemaddcant\">"+cant+"</td><td>"+item.children('td[class="comidacos"]').text()+"</td><td>"+$("#dias").val()+"</td><td> "+(cant*(item.children('td[class="comidacos"]').text()*1)*$("#dias").val())+"</td><td><button value=plato"+id+" OnClick='Eliminar(this);' class='btn btn-danger'>Eliminar</button></td></tr>");
      location.href="#TablaA";
    });
  </script>


@stop