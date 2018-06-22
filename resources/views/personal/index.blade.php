@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg bg-dark" style="color:white; padding-top: 10px;visibility:hidden;" id="main">
        <!--<div class="input-group mb-2 ">
            <input id="cedu" onkeypress="return cedulanica(event,this);" onkeyup="formatonica(this); filtrocedulaper('personal.recargable.listapersonal');" type="text" class="form-control" placeholder="Cedula del cliente" aria-label="Cedula del Cliente" aria-describedby="basic-addon2" value="{!!session('valor')!!}">
            <div class="input-group-append">
                <button class="btn btn-dark" type="button" id="filtrar">Buscar</button>
            </div>
        </div>-->
        @include('alert.mensaje')
        <div id="mensaje"></div>
        <table class="table table-hover table-dark" cellspacing="0" id="Datos" style="width:100%;">
            <thead>
                <th class="text-center">Cedula</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Apellido</th>
                <th class="text-center">Direccion</th>
                <th class="text-center">Fecha Nacimiento</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody class="text-center" id="lista"> 
                @include('personal.recargable.listapersonal')
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
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="ce">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <!--UNA VEZ TERMINADA LA CLASE DE IS REGRESAR LOS FORMULARIOS A SU TAMAñO GRANDE E IMPORTARLO AQUI-->
                        <div class="row ">
                            <div class="col-md-3 "></div>
                            <div class="col-md-6 ">
                                <div class="form-group text-center">
                                    {!!Form::label('Cedula','Cedula:')!!}
                                    {!!Form::text('Cedula_Personal',null,['id'=>'cedu','class'=>'form-control','placeholder'=>'xxx-xxxxxx-xxxxx', 'onkeypress="return cedulanica(event,this);"','onkeyup="formatonica(this); buscar(this);"'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Nombre:')!!}
                                    {!!Form::text('Nombre',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre del Personal'])!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Apellido:')!!}
                                    {!!Form::text('Apellido',null,['id'=>'apellido','class'=>'form-control','placeholder'=>'Apellido del Personal'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Direccion:')!!}
                                    {!!Form::text('Direccion',null,['id'=>'direccion','class'=>'form-control','placeholder'=>'Direccion del personal'])!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Fehca de nacimiento:')!!}
                                    {!!Form::text('Fecha_Nac',null,['id'=>'Fecha_Nac','class'=>'form-control','placeholder'=>' año/mes/dia'])!!}
                                </div>
                            </div>
                        </div> 

                        <!--@include('personal.formulario.datos')-->
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
@section("script")
    {!!Html::script("js/jskevin/cedulanica.js")!!}
    {!!Html::script("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")!!} 
    {!!Html::script("https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js")!!} 
    {!!Html::script("js/jskevin/tiposmensajes.js")!!}  
    <script>
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

        $('.edit').on( 'click', function () {
            fila=$(this).parents('tr');//Dejamos almacenada temporalmente la fila en la que clickeamos editar
            var row=table.row(fila).data();//Tomamos el contenido de la fila 
            //Sobreescribimos en los campos editables los datos del cliente
            $("#cedu").val(row[0]);
            $("#nombre").val(row[1]);
            $("#apellido").val(row[2]);
            $("#direccion").val(row[3]);
            $("#Fecha_Nac").val(row[4]);
            $("#ce").val(row[0]);//Campo que almacena la cedula inicial
        });
        function actualizar()
        {
            route="http://127.0.0.1:8080/personal/"+$("#ce").val();
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
                        message(['Personal editado correctamente'],{manual:true});
                        table.cell(fila.children('td')[0]).data( $("#cedu").val());
                        table.cell(fila.children('td')[1]).data( $("#nombre").val());
                        table.cell(fila.children('td')[2]).data( $("#apellido").val());
                        table.cell(fila.children('td')[3]).data( $("#direccion").val());
                        table.cell(fila.children('td')[4]).data( $("#Fecha_Nac").val());
                        fila.children('td.botones').children('input.delete').removeAttr( "onclick");//Eliminamos la funcion onclick del boton eliminar
                        fila.children('td.botones').children('input.delete').attr( "onclick",'erase(\''+$("#cedu").val()+'\');');//Agregamos la funcion onclick con el nuevo parametro
                        table=$("#Datos").DataTable().draw();
                    }
                    else
                    {
                        message(['No se actualizo: La cedula ingresada ya estaba registrada'],{manual:true,tipo:"danger"});
                    }
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        }

        $('.delete').on( 'click', function () {
            table.row($(this).parents('tr')).remove().draw( false );
        });
        function erase(cedula)
        {
            var route="http://127.0.0.1:8080/personal/"+cedula;
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                success: function(){
                    message(['Se elimino al personal correctamente'],{manual:true});
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        }
    </script>
@stop