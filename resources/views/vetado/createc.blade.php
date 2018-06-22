@extends('layouts.dashboard')
@section('content')

    <div class="d-block bg-dark" style="padding-top: 10px; color:white;visibility:hidden;" id="main">
    
        <div id="mensaje"></div>
        <div class="row ">
            <div class="col-md-4">
                <div class="form-group">
                    <select onchange="filtro(this,0);" class="form-control" id="tipofil">
                        <option Selected>Cliente</option>
                        <option >Personal</option>
                    </select>
                </div>
            </div>
            <!--<div class="col-md" >
                <div class="form-group" >
                    <input id="cedu" onkeypress="return cedulanica(event,this);" onkeyup="formatonica(this); filtrocedulacli('vetado.recargable.listavetadoc');" type="text" class="form-control" placeholder="Cedula del cliente" aria-label="Cedula del Cliente" aria-describedby="basic-addon2" >
                </div>
            </div>-->
        </div>
        <table class="table table-hover table-dark" cellspacing="0" id="Datos" style="width:100%;" >
            <thead >
                <th class="text-center">Cedula</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Apellido</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody class="text-center" id="lista"> 
                @include('vetado.recargable.listavetadoc')
            </tbody>
        </table>
        
        <input type="hidden"  value="0" id="comodin">
    </div> 
    <!-- Modal -->
    <div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="vetado();" id="vetar" >Vetar</button>
                            
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
        var servi=0;
        var item=0;
        //Filtramos por el campo cedula    
        function filtro()
        {
            if($("#tipofil").val()=="Cliente")
            {
                location.href ="http://127.0.0.1:8080/listacliente";
                
            }
            else
            {
                location.href ="http://127.0.0.1:8080/listapersonal";
            }
        }
        function vetado()
        {
            console.log("entro");
            var ruta="http://127.0.0.1:8080/vetar";
            var token=$("#token").val();
            $.ajax({
                url: ruta,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data:{"La cedula del cliente":$("#cedula").text(),"descripcion":$("#descripcion").val(),"tipo":"cliente"},
                success: function(){
                    
                    message(["Se vetó al cliente correctamente "],{manual:true})
                    table.row(fila).remove().draw( false );
                    return;
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                console.log("entra al ajax error");
                message(jqXHR,{tipo:"danger"});
            });
        }
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
            });
            $("#main").css("visibility", "visible");
        });
        $('.delete').on( 'click', function () {
            fila=$(this).parents('tr');
            var ruta="http://127.0.0.1:8080/cliente/"+$(this).val()+"";
            console.log(ruta);
            $("#descripcion").val("");
            $.get(ruta,function(res)
            {
                console.log(res.Nombre);
                $("#cedula").text(res.Cedula_Cliente);
                $("#nombre").text(res.Nombre);
                $("#apellido").text(res.Apellido);
                $("#edad").text(res.Edad);
                $("#sexo").text(res.Sexo);
            });
        });
    </script>
@stop