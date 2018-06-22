@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg-dark" style="padding-top: 10px; color:white;visibility:hidden;" id="main">
    
        @include('alert.mensaje')
        <div id="mensaje"></div>
        <div class="row ">
            <div class="col-md-4">
                <div class="form-group">
                    <select onchange="filtro();" class="form-control" id="tipofil">
                        <option >Cliente</option>
                        <option Selected>Personal</option>
                    </select>
                </div>
            </div>
            <!--<div class="col-md" >
                <div class="form-group" >
                    <input id="cedu" onkeypress="return cedulanica(event,this);" onkeyup="formatonica(this); filtrovetado();" type="text" class="form-control" placeholder="Cedula del cliente" aria-label="Cedula del Cliente" aria-describedby="basic-addon2" >
                </div>
            </div>-->
        </div>
        <table class="table table-hover table-dark" cellspacing="0" id="Datos" style="width:100%;" >
            <thead >
                <th class="text-center">Cedula</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Apellido</th>
                <th class="text-center">Vetado por:</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody class="text-center" id="lista"> 
                @include('vetado.recargable.lvp')
            </tbody>
        </table>
        
        <input type="hidden"  value="0" id="comodin">
    </div> 
    <!-- Modal -->
    <div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Esta apunto de vetar a:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <input type="hidden" id="id">
                        <div class="row ">
                            <div class="col-md-3 "></div>
                            <div class="col-md-6 ">
                                <div class="form-group text-center">
                                    {!!Form::label('Cedula','Cedula:')!!}
                                    {!!Form::label('','',['class' => 'badge badge-pill badge-info','id'=>'cedula'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Nombre','Nombre:')!!}
                                    {!!Form::label('','',['class' => 'badge badge-pill badge-info','id'=>'nombre'])!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!!Form::label('Apellido','Apellido:')!!}
                                    {!!Form::label('','',['class' => 'badge badge-pill badge-info','id'=>'apellido'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Edad','Edad:')!!}
                                    {!!Form::label('','',['class' => 'badge badge-pill badge-info','id'=>'edad'])!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!!Form::label('Sexo','Sexo:')!!}
                                    {!!Form::label('','',['class' => 'badge badge-pill badge-info','id'=>'sexo'])!!}
                                </div>
                            </div>
                        </div> 
                        <div class="row ">
                            <div class="col-md-3 "></div>
                            <div class="col-md-12 ">
                                <div class="form-group text-center">
                                    {!!Form::label('Descripcion','Descripcion:')!!}
                                    <textarea class="form-control" placeholder="Será vetado debido a: " id="descripcion" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="actualizar();" id="vetar" >Actualizar</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section("script")
    {!!Html::script("js/jskevin/cedulanica.js")!!} 
    {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
    {!!Html::script("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")!!} 
    {!!Html::script("https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js")!!} 
    <script>
        var table;
        var fila;
        $(document).ready( function () {
            table= $('#Datos').DataTable({
                "pagingType": "full_numbers",
                "order": [[ 1, "asc" ]],
                "scrollX": true,
                
                "language": {
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
                    "decimal": ".",
                    "thousands": ","
                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
                
            }).search('{!!session("valor")!!}').draw();
            $("#main").css("visibility", "visible");
        });
        function filtro()
        {
            if($("#tipofil").val()=="Cliente")
            {
                location.href ="http://127.0.0.1:8080/vetado/";
                
            }
            else
            {
                location.href ="http://127.0.0.1:8080/vetado/personal/vetado.indexp";
            }
        }
        function filtrovetado()
        {
            var ruta="http://127.0.0.1:8080/vetado/personal/vetado.recargable.lvp/"+$("#cedu").val();
            $.get(ruta,function(res){
                console.log(res);
                $("#lista").empty();
                $("#lista").append(res);
            });
        }
        
         $('.edit').on( 'click', function () {
            fila=$(this).parents('tr');//Dejamos almacenada temporalmente la fila en la que clickeamos editar
            var ruta="http://127.0.0.1:8080/descripcion/personal/"+$(this).val();
            $.get(ruta,function(res)
            {
                console.log(res);
                $("#cedula").text(res.Cedula_Personal);
                $("#nombre").text(res.Nombre);
                $("#apellido").text(res.Apellido);
                $("#edad").text(res.Fecha_Nac);
                $("#sexo").text(res.Direccion);
                $("#descripcion").val(res.descripcion);
            });
        });
        function actualizar()
        {
            console.log("entro");
            var ruta="http://127.0.0.1:8080/vetado/"+$("#cedula").text();
            var token=$("#token").val();
            $.ajax({
                url: ruta,
                headers: {'X-CSRF-TOKEN': token},
                type: 'PUT',
                dataType: 'json',
                data:{"descripcion":$("#descripcion").val(),"tipo":"personal"},
                success: function(){
                    message(["Se edito correctamente "],{manual:true})
                    table.cell(fila.children('td')[3]).data( $("#descripcion").val());
                    table=$("#Datos").DataTable().draw();
                    return;
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                console.log("entra al ajax error");
                message(jqXHR,{tipo:"danger"});
            });
        }
        
        $('.delete').on( 'click', function () {
            var row=$(this).parents('tr');
            var route="http://127.0.0.1:8080/vetado/"+$(this).val();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                data: {'tipo':'personal'},
                success: function(){
                    message(['Se elimino la vetacion correctamente'],{manual:true});
                    table.row(row).remove().draw( false );
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        });
    </script>
@stop