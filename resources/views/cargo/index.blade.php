@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg bg-dark" style="color:white; padding-top: 10px;visibility:hidden;" id="main">
        <!--<div class="input-group mb-2 ">
            <input onkeyup="filtro(this);" type="text" class="form-control" placeholder="Nombre del servicio" aria-label="Nombre del servicio" aria-describedby="basic-addon2" value="{!!session('valor')!!}">
            <div class="input-group-append">
                <button class="btn btn-dark" type="button" id="filtrar">Buscar</button>
            </div>
        </div>-->

        @include('alert.mensaje')
        <div id="mensaje"></div>
        <table class="table table-bordered table-hover table-dark" cellspacing="0" id="Datos" style="width:100%;" >
            <thead>
                <th class="text-center">Nombre</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody id="lista"> 
                @include('cargo.listacargo.listacindex')
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
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="id">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <!--UNA VEZ TERMINADA LA CLASE DE IS REGRESAR LOS FORMULARIOS A SU TAMAñO GRANDE E IMPORTARLO AQUI-->

                        <div class="row text-center">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!!Form::label('Nombre del Cargo:')!!}
                                    {!!Form::text('Nombre_Cargo',null,['id'=>'Nom', 'class'=>'form-control','placeholder'=>'ej: Conductor'])!!}
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="actualizar();" id="actualizar" >Actualizar</button>
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
        var fila;
        var table;
        $(document).ready( function () {
            table= $('#Datos').DataTable({
                "pagingType": "full_numbers",//botones primero, anterio,siguiente, ultimo y numeros
                "order": [[ 0, "asc" ]],//ordenara por defecto en la columna Nombre de forma ascendente
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
        function filtro(val)
        {
            var ruta="http://127.0.0.1:8080/filtrocargo/"+val.value;
            var token=$("#token").val();
            $.get(ruta, function(res){
                $("#lista").empty();//Elimina la lista actual
                //$(".pagination").remove();
                jQuery("#lista").append(res);//Actualiza la lista
            });
        }
        $('.edit').on( 'click', function () {
            fila=$(this).parents('tr');//Dejamos almacenada temporalmente la fila en la que clickeamos editar
            var row=table.row(fila).data();//Tomamos el contenido de la fila 
            //Sobreescribimos en los campos editables los datos del cliente
            $("#Nom").val(row[0]);
            $("#id").val($(this).val());
        });
        //Actualizacion de fila donde no es posible actualizar id
        function actualizar()
        {
            route="http://127.0.0.1:8080/cargo/"+$("#id").val();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'PUT',
                dataType: 'json',
                data:$("#data").serialize(),
                success: function(res){
                    if(res==1)
                    {
                        message(['Cargo editado correctamente'],{manual:true});
                        table.cell(fila.children('td')[0]).data( $("#Nom").val());
                        table=$("#Datos").DataTable().draw();
                    }
                    else
                    {
                        message(['No se actualizo: El nombre ya existia'],{manual:true,tipo:"danger"});
                    }
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        }
        $('.delete').on( 'click', function () {
            var route="http://127.0.0.1:8080/cargo/"+$(this).val();
            var token=$("#token").val();
            var row=$(this).parents('tr');
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                success: function(res){
                    message(['Se elimino el cargo correctamente'],{manual:true});
                    table.row(row).remove().draw( false );
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        });
    </script>
@stop