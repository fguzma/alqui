@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg-dark" style="padding-top: 10px; color:white;visibility:hidden;" id="main">
    
        @include('alert.mensaje')
        <div id="mensaje"></div>
        <div class="row ">
            <div class="col-md-4">
                <div class="form-group">
                    <select onchange="filtro();" class="form-control" id="tipofil">
                        <option Selected>Cliente</option>
                        <option >Personal</option>
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
                @include('vetado.recargable.lvc')
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
    {!!Html::script("js/jskevin/kavvdt.js")!!}   
    <script>
    
        var table;
        var fila;
        $(document).ready( function () {
            table=createdt($('#Datos'),{buscar:'{!!session("valor")!!}',col:1,cant:[10,20,-1],cantT:[10,20,"Todo"]});
            $("#main").css("visibility", "visible");
        });
        function filtro()
        {
            if($("#tipofil").val()=="Cliente")
                location.href ="/vetado/cliente";
            else
                location.href ="/vetado/personal/vetado.indexp";
        }

        function eliminar(cedu)
        {
            console.log("entro");
            var ruta="/vetado/"+cedu;
            var token=$("#token").val();
            $.ajax({
                url: ruta,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                data:{"tipo":"cliente"},
                success: function(){
                    message(["Se elimino la vetacion del cliente correctamente "],{manual:true})
                    console.log("se agrego");
                    filtrovetado();
                    return;
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                console.log("entra al ajax error");
                message(jqXHR,{tipo:"danger"});
            });
        }
        $('.edit').on( 'click', function () {
            fila=$(this).parents('tr');//Dejamos almacenada temporalmente la fila en la que clickeamos editar
            var ruta="/descripcion/cliente/"+$(this).val();
            $.get(ruta,function(res)
            {
                console.log(res);
                $("#cedula").text(res.Cedula_Cliente);
                $("#nombre").text(res.Nombre);
                $("#apellido").text(res.Apellido);
                $("#edad").text(res.Edad);
                $("#sexo").text(res.Sexo);
                $("#descripcion").val(res.descripcion);
            });
        });
        function actualizar(cedula)
        {
            route="/vetado/"+$("#cedula").text();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'PUT',
                dataType: 'json',
                data:{"descripcion":$("#descripcion").val(),"tipo":"cliente"},
                success: function(res){
                    message(['Se edito correctamente'],{manual:true});
                    table.cell(fila.children('td')[3]).data( $("#descripcion").val());
                    table=$("#Datos").DataTable().draw();
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        }
        $('.delete').on( 'click', function () {
            var row=$(this).parents('tr');
            var route="/vetado/"+$(this).val();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                data: {'tipo':'cliente'},
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