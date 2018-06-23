@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg-dark" style="color:white; padding-top: 10px;visibility:hidden;" id="main">
        <!--<div class="row ">
            <div class="col-md-4">
                <div class="form-group">
                    <select onchange="filtro(this,0);" class="form-control" id="servicios"  >
                        <option></option>
                        @foreach($servicios as $servicio)
                            @if(session('filtro')==$servicio->ID_Servicio)
                                <option value='{!!$servicio->ID_Servicio!!}' selected>{!!$servicio->Nombre!!}</option>
                            @else
                                <option value='{!!$servicio->ID_Servicio!!}' >{!!$servicio->Nombre!!}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md" >
                <div class="form-group" >
                    {!!Form::text('NombreArti',session('valor'),['id'=>'nombreA', 'class'=>'form-control','placeholder'=>'Nombre del articulo', 'onkeyup="filtro(0,this);"'])!!}
                </div>
            </div>
        </div>-->
        @include('alert.mensaje')
        <div id="mensaje"></div>
        <table class="table table-hover table-dark" cellspacing="0" id="Datos" style="width:100%;">
            <thead >
                <th class="text-center">Servicio</th>
                <th class="text-center">Nombre</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th>Costo_Alquiler</th>
                <th>Costo_Objeto</th>
                <th>Disponibilidad</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody class="text-center" id="lista"> 
                @include('inventario.recargable.listainventario')
            </tbody>
        </table>
        
    </div>
    <!-- Modal -->
    <div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="data">
                        <input type="hidden"  id="id">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <!--UNA VEZ TERMINADA LA CLASE DE IS REGRESAR LOS FORMULARIOS A SU TAMAñO GRANDE E IMPORTARLO AQUI-->

                        <div class="row ">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="form-group text-center">
                                    {!!Form::label('Servicio:')!!}
                                    <select class="form-control" name="ID_Servicio" id="servicios">
                                        @foreach($servicios as $servicio)
                                            <option class="{!!$servicio->Nombre!!}" value='{!!$servicio->ID_Servicio!!}'>{!!$servicio->Nombre!!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Nombre:')!!}
                                    {!!Form::text('Nombre',null,['id'=>'nombre', 'class'=>'form-control','placeholder'=>'Nombre del articulo'])!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Cantidad:')!!}
                                    {!!Form::text('Cantidad',null,['id'=>'cantidad','class'=>'form-control','placeholder'=>'Cantidad'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Costo de Alquiler:')!!}
                                    {!!Form::text('Costo_Alquiler',null,['id'=>'CA','class'=>'form-control','placeholder'=>'Costo de Alquiler'])!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Costo de Objeto:')!!}
                                    {!!Form::text('Costo_Objeto',null,['id'=>'CO','class'=>'form-control','placeholder'=>' Costo de Objeto'])!!}
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Disponibilidad:')!!}
                                    <div class="btn-group" data-toggle="buttons" name="opcion">
                                        <label class="btn btn-secondary active">
                                            <input type="radio" name="options" id="option1" autocomplete="off" checked value="SI"> SI
                                        </label>
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="options" id="option2" autocomplete="off" value="NO"> NO
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="actualizar();" id="actualizar">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    {!!Html::script("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")!!} 
    {!!Html::script("https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js")!!} 
    {!!Html::script("js/jskevin/tiposmensajes.js")!!}  
    <script>
        var servi=0;
        var item=0;
        var table;
        var fila;
        $(document).ready( function () {
            table= $('#Datos').DataTable({
                "pagingType": "full_numbers",//botones primero, anterio,siguiente, ultimo y numeros
                "order": [[ 1, "asc" ]],//ordenara por defecto en la columna Nombre de forma ascendente
                "scrollX": true,//Scroll horizontal
                
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
            }).search('{!!session("valor")!!}').draw();
            $("#main").css("visibility", "visible");
        });
        //Filtramos por el campo cedula    
        function filtro(val1=0,val2=0)
        {
            if($("#servicios").val()=="")
                servi=0;
            else
                servi=$("#servicios").val();

            if($("#nombreA").val()=="")
                item=0;
            else
                item=$("#nombreA").val();
            console.log(servi+"--"+item);
            var ruta="https://alquiler.herokuapp.com/filtroinventario/"+servi+'/'+item;
            console.log(ruta);
            var token=$("#token").val();
            $.get(ruta, function(res){
                $("#lista").empty();//Elimina la lista actual
                //$(".pagination").remove();
                jQuery("#lista").append(res);//Actualiza la lista
            });
        }
        $('.edit').on( 'click', function () {
            fila=$(this).parents('tr');//Dejamos almacenada temporalmente la fila en la que clickeamos editar
            var row=table.row(fila).data();//Tomamos el contenido de la fila s
            $("#servicios option[class="+ row[0] +"]").attr("selected",true);
            $("#nombre").val(row[1]);
            $("#cantidad").val(row[2]);
            $("#CA").val(row[4]);
            $("#CO").val(row[5]);
            $("#id").val($(this).val());
        });
        function actualizar()
        {
            route="https://alquiler.herokuapp.com/inventario/"+$("#id").val();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'PUT',
                dataType: 'json',
                data:$("#data").serialize(),
                success: function(res){
                    console.log(res);
                    if(res==1)
                    {
                        message(['Articulo editado correctamente'],{manual:true});
                        console.log($("#servicios option[selected]").text());
                        table.cell(fila.children('td')[0]).data( $("#servicios option[value="+ $("#servicios").val() +"]").text());
                        table.cell(fila.children('td')[1]).data( $("#nombre").val());
                        table.cell(fila.children('td')[2]).data( $("#cantidad").val());
                        table.cell(fila.children('td')[4]).data( $("#CA").val());
                        table.cell(fila.children('td')[5]).data( $("#CO").val());
                        table=$("#Datos").DataTable().draw();
                    }
                    else
                    {
                        message(['No se actualizo: El nombre ya estaba en uso'],{manual:true,tipo:"danger"});
                    }
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        }
        $('.delete').on( 'click', function () {
            var row=$(this).parents('tr');
            var route="https://alquiler.herokuapp.com/inventario/"+$(this).val();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                success: function(){
                    message(['Se elimino el articulo correctamente'],{manual:true});
                    table.row(row).remove().draw( false );
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        });
    </script>
@stop