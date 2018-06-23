@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg-dark" style="padding-top: 10px; color:white;visibility:hidden;" id="main">
        <div id="mensaje"></div>
        <div class="row ">
            <div class="col-md-4">
                <div class="form-group">
                    <select onchange="filtro(this,0);" class="form-control" id="tipofil">
                        <option >Cliente</option>
                        <option Selected>Personal</option>
                    </select>
                </div>
            </div>
            <!--<div class="col-md" >
                <div class="form-group" >
                    <input id="cedu" onkeypress="return cedulanica(event,this);" onkeyup="formatonica(this); filtrocedulaper('vetado.recargable.listavetadop');" type="text" class="form-control" placeholder="Cedula del personal" aria-label="Cedula del Cliente" aria-describedby="basic-addon2" >
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
                @include('vetado.recargable.listavetadop')
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
                                    {!!Form::label('Direccion','Direccion:')!!}
                                    {!!Form::label('','',['class' => 'badge badge-pill badge-info','id'=>'direccion'])!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!!Form::label('Fecha','Fecha de nacimiento:')!!}
                                    {!!Form::label('','',['class' => 'badge badge-pill badge-info','id'=>'fechan'])!!}
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
        var table;
        var fila;
        //Filtramos por el campo cedula    
        function filtro(val1=0,val2=0)
        {
            var ruta;
            console.log($("#tipofil").val()+"entra");
            if($("#tipofil").val()=="Cliente")
                location.href ="https://alqui.herokuapp.com/listacliente";
            else
                location.href ="https://alqui.herokuapp.com/listapersonal";
        }

        function vetado()
        {
            console.log("entro");
            var ruta="https://alqui.herokuapp.com/vetar";
            var token=$("#token").val();
            $.ajax({
                url: ruta,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data:{"La cedula del personal":$("#cedula").text(),"descripcion":$("#descripcion").val(),"tipo":"personal"},
                success: function(){
                
                    message(["Se vetó al personal correctamente "],{manual:true})
                    table.row(fila).remove().draw( false );
                    return;
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                console.log("error");
                message(jqXHR,{tipo:"danger"});
            });
        }
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
            var ruta="https://alqui.herokuapp.com/personal/"+$(this).val();
            console.log(ruta);
            $("#descripcion").val("");
            $.get(ruta,function(res)
            {
                console.log(res.Nombre);
                $("#cedula").text(res.Cedula_Personal);
                $("#nombre").text(res.Nombre);
                $("#apellido").text(res.Apellido);
                $("#direccion").text(res.Direccion);
                $("#fechan").text(res.Fecha_Nac);
            });
        });
    </script>
@stop