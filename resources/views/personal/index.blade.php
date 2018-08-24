@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg bg-dark" style="color:white; padding-top: 10px;visibility:hidden;" id="main">

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
                        <div class="row" >
                            <div class="col-md-12" id="lc">
                                <div class="list-group " id="list-tab" role="tablist" style="height:15em;width:auto; overflow:scroll;">
                                    <table class="table table-hover table-dark" cellspacing="0" id="cargos" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Cargo</th>
                                                <th data-orderable="false"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Cargos as $cargo)
                                                <tr>
                                                    <td >{!!$cargo->Nombre_Cargo!!}</td>
                                                    <td class="btn-primary text-center">
                                                        <input id="{!!$cargo->ID_Cargo!!}" type="checkbox" OnClick='addcargo(this,"{!!$cargo->ID_Cargo!!}")'>
                                                    </td>
                                                </tr>  
                                            @endforeach
                                        </tbody>
                                    </table>
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
@section("script")
    {!!Html::script("js/jskevin/cedulanica.js")!!}
    {!!Html::script("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")!!} 
    {!!Html::script("https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js")!!} 
    {!!Html::script("js/jskevin/tiposmensajes.js")!!}  
    {!!Html::script("js/jskevin/kavvdt.js")!!}  
    <script>
        var table;
        var fila;
        $(document).ready( function () {
            table= createdt($("#Datos"),{buscar:'{!!session("valor")!!}',col:1,cant:[10,20,-1],cantT:[10,20,"todo"]})
            createdt($("#cargos"),{col:0,dom:""});
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
            $('input[type="checkbox"]').prop('checked',false);
            ruta="/cargopersonal/"+row[0];
            $.get(ruta,function(res){
                console.log(res);
                listacargo=new Object();
                for(i=0; i<res.length; i++)
                {
                    $("#"+res[i].ID_Cargo).prop("checked",true);
                    listacargo[res[i].ID_Cargo]=res[i].ID_Cargo;
                }
            });
        });
        function actualizar()
        {
            route="/personal/"+$("#ce").val();
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
                        ruta="/pcargoupdate";
                        $.ajax({
                            url: ruta,
                            headers:{'X-CSRF-TOKEN': token},
                            type: 'POST',
                            dataType: 'json',
                            data:{"listacargo":listacargo,"cedula":$("#cedu").val()},
                            success: function(res){
                                console.log("entra man");
                            }
                        }).fail( function( jqXHR, textStatus, errorThrown ) {
                            message(jqXHR,{tipo:"danger"});
                        });
                            
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
            var route="/personal/"+cedula;
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
        var listacargo=new Object();
        function addcargo(elemento,key)
        {
            if(elemento.checked==true)
            {
                listacargo[key]=[key];
            }
            else
            {
                delete listacargo[key];
            }
        }
    </script>
@stop