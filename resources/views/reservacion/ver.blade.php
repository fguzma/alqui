@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg bg-dark" style="color:white; padding-top: 10px;visibility:hidden;" id="main">
            <div style="overflow-x: auto; min-width:80%;">
                @include('alert.mensaje')
                <div id="mensaje"></div>
                <table class="table table-hover table-dark text-center" cellspacing="0" id="Datos" style="width:100%;">
                    <thead>
                        <th style="" >Nombre</th>
                        <th style="" >Cedula</th>
                        <th style="" >Fecha Facturacion</th>
                        <th data-orderable="false" ></th>
                    </thead>
                    <tbody class="text-center" id="lista"    > 
                        @include('reservacion.recargable.listareservas')
                    </tbody>
                </table>
            </div>
    </div>

      <!-- Modal -->
    <div class="modal fade" id="infore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Informacion</h5>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!!Form::label('Cliente:')!!}
                                    {!!Form::label('Cliente:',null,['id' => 'cliente','class'=>'badge badge-pill badge-info'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!!Form::label('Cedula:')!!}
                                    {!!Form::label('Cedula:',null,['id' => 'cedula','class'=>'badge badge-pill badge-info'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!!Form::label('Direccion:')!!}
                                    {!!Form::label('Direccion:',null,['id' => 'direccion','class'=>'badge badge-pill badge-info'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!!Form::label('Fecha:')!!}
                                    {!!Form::label('Fecha:',null,['id' => 'fecha','class'=>'badge badge-pill badge-info'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h4>Descripcion</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th >Cantidad</th>
                                                <th >Descripcion</th>
                                                <th >P/Unitario</th>
                                                <th >Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbdes">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="editar();">Editar</button>
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
    {!!Html::script("js/jskevin/kavvdt.js")!!}  
    <script>
        var tablareservas;
        var resinfo = new Object();
        var des = new Object();
        $(document).ready(function(){
            tablareservas=createdt($("#Datos"),{cant:[10,20,-1],cantT:["10","20","Todo"]});
            $("#main").css('visibility','visible');
            var x;
            x={!!$reservas!!};
            for(var i=0; i<x.length; i++)
                resinfo[x[i].ID_Reservacion]=x[i];
            des={!!json_encode($des)!!};
        });

        var evento;
        $(".detalle").on('click',function(){
            evento=$(this).val();
            console.log($(this).val());
            $("#cliente").text(resinfo[evento].Nombre_Contacto);
            $("#cedula").text(resinfo[evento].Cedula_Cliente);
            $("#direccion").text(resinfo[evento].Direccion_Local);
            $("#fecha").text(resinfo[evento].Fecha_Inicio + " - " + resinfo[evento].Fecha_Fin);
            $("#tbdes").empty();
            var total=0;
            for(i=0; i<des[evento].length; i++)
            {
                $("#tbdes").append(
                    '<tr>'+
                        '<td>'+des[evento][i].Cantidad+'</td>'+
                        '<td >'+des[evento][i].Nombre+'</td>'+
                        '<td>'+des[evento][i].P_Unitario+'</td>'+
                        '<td>'+des[evento][i].Total+'</td>'+
                    '</tr>'
                );
                total+=des[evento][i].Total;
            }
            var iva=resinfo[evento].iva;
            if(iva==0)
            {
                $("#tbdes").append(
                    '<tr><td></td><td></td><td><b>Gran Total<b></td><td>'+total+'</td></tr>'
                );
            }
            else
            {
                $("#tbdes").append(
                    '<tr><td></td><td></td><td><b>Sub Total<b></td><td>'+total+'</td></tr>'+
                    '<tr><td></td><td></td><td><b>IVA<b></td><td>'+(total*iva).toFixed(2)+'</td></tr>'+
                    '<tr><td></td><td></td><td><b>Gran Total<b></td><td>'+((total)+(total*iva)).toFixed(2)+'</td></tr>'
                );
            }
            $("#infore").modal('show');
        });
        function editar()
        {
            location.href="/reserva/"+evento+"/edit";
        }
    </script>
@stop