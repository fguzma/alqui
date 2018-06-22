@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg-dark" style="color:white; padding-top: 10px;visibility:hidden;" id="main">
        <!--<div class="row ">
            <div class="col-md-6">
                <div class="form-group">
                    {!!Form::select('size', ['fus' => 'Filtrar por Usuario', 'fco' => 'Filtrar por Correo', 'fi' => 'Filtrar por Identificacion'], null, ['class'=>'form-control','placeholder' => 'Filtar por:','id'=>'tipofil','onchange="filtro();"']);!!}
                </div>
            </div>
            <div class="col-md" >
                <div class="form-group" >
                    {!!Form::text('valorfilro',session('valor'),['id'=>'valorf', 'class'=>'form-control','placeholder'=>'Ingrese el valor segun el tipo de filtro', 'onkeyup="filtro();"'])!!}
                </div>
            </div>
        </div>-->
        @include('alert.mensaje')
        <div id="mensaje"></div>
        <table class="table table-hover table-dark" cellspacing="0" id="Datos" style="width:100%;">
            <thead>
                <th class="text-center">Correo</th>
                <th class="text-center">Usuario</th>
                <th class="text-center">Identificacion</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody class="text-center" id="lista"> 
                @include('usuario.recargable.listausuarios')
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

                        <div class="row ">
                            <div class="col-md-1 "></div>
                            <div class="col-md-10 ">
                                <div class="form-group text-center">
                                    {!!Form::label('correo')!!}
                                    {!!Form::text('correo',null,['autocomplete'=>'off','id'=>'Correo','class' => 'form-control','placeholder'=>'ejemplo@hotmail.com','onkeyup'=>'existe("2");'])!!}
                                    <spam id="msjemail" style="color:red;"></spam> 
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Usuario:')!!}
                                    {!!Form::text('Usuario',null,['autocomplete'=>'off','id'=>'usuario','class'=>'form-control','placeholder'=>'Ejemplo123','onkeyup'=>'existe("1");'])!!}
                                    <spam id="msjuser" style="color:red;"></spam> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('*Identificacion:')!!}
                                    {!!Form::text('identificacion',null,['id'=>'identificacion','class'=>'form-control','placeholder'=>'Cedula'])!!}
                                </div>
                            </div>
                        </div>
                        <hr class="bg-info"/>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="0" id="defaultCheck1" name="restablecerpass">
                                    <label class="form-check-label " for="defaultCheck1">
                                        Cambiar Contraseña
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr class="bg-info"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Cambiar Contraseña:')!!}
                                    <input type="password" class="form-control"  name="contraseña" id="contraseña" placeholder="*******" onkeyup="coinciden();" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Confirmar Nueva Contraseña:')!!}
                                    <input type="password" class="form-control"  name="confcontraseña" id="confcontraseña" placeholder="*******" onkeyup="coinciden();" disabled>
                                    <spam id="msjpass" style="color:red;"></spam>
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
        var tfiltro="";
        var valorfil="";
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
        function filtro()
        {
            if($("#tipofil").val()=="")
                tfiltro="no";
            else
                tfiltro=$("#tipofil").val();

            if($("#valorf").val()=="")
                valorfil="no";
            else
                valorfil=$("#valorf").val();
            var ruta="http://127.0.0.1:8080/filtrousuario/"+tfiltro+'/'+valorfil;
            $.get(ruta, function(res){
                $("#lista").empty();//Elimina la lista actual
                //$(".pagination").remove();
                jQuery("#lista").append(res);//Actualiza la lista
            });
        }
        $('.edit').on( 'click', function () {
            $("#msjemail").empty();
            $("#msjuser").empty();
            fila=$(this).parents('tr');//Dejamos almacenada temporalmente la fila en la que clickeamos editar
            var row=table.row(fila).data();//Tomamos el contenido de la fila s
            $("#Correo").val(row[0]);
            $("#usuario").val(row[1]);
            $("#identificacion").val(row[2]);
            $("#id").val($(this).val());
        });
        function actualizar()
        {
            route="http://127.0.0.1:8080/usuario/"+$("#id").val();
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
                        message(['Usuario editado correctamente'],{manual:true});
                        table.cell(fila.children('td')[0]).data( $("#Correo").val());
                        table.cell(fila.children('td')[1]).data( $("#usuario").val());
                        table.cell(fila.children('td')[2]).data( $("#identificacion").val());
                        table=$("#Datos").DataTable().draw();
                    }
                    else
                    {
                        message(res,{manual:true,tipo:"danger"});
                    }
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        }
        var email=$("#Correo").val();
        var user=$("#usuario").val();
        var correcto=true;
        function coinciden()
        {
            var contra1=$("#contraseña").val();
            var contra2=$("#confcontraseña").val();
            /*si estan vacios los campos*/
            if(contra1.length==0)
            {
                $("#msjpass").empty();
                $("#agregar").attr("disabled", true);
                correcto=true;/*enrealidad no esta correcto, es para no crear conflicto*/
                return;
            }
            /*validar que sean iguales*/
            if(contra1!=contra2)
            {
                if(correcto==true)/*condicion con el fin de evitar sobre escribir cada momento en #msjpass*/
                {
                    jQuery("#msjpass").append("No coinciden las contraseñas!");
                    correcto=false;
                    $("#agregar").attr("disabled", true);
                    return;
                }
            }
            else
            {
                $("#msjpass").empty();
                /*Validar longitud*/
                if(contra1.length < 6)
                {
                    jQuery("#msjpass").append("La longitud de la contraseña debe ser mayor a 5");
                    correcto=false;
                    $("#agregar").attr("disabled", true);
                    return;
                }
                else
                {
                    correcto=true;
                    $("#agregar").attr("disabled", false);
                }
            }
        }
        function existe(decision)
        {
        /*validacion para el usuario*/
            if(decision==1)
            {
                $("#msjuser").empty();
                if(user!=$("#usuario").val())
                {
                    var ruta="http://127.0.0.1:8080/userexist/"+$("#usuario").val()+"/"+decision;
                    if($("#usuario").val()!="")
                    {
                        $.get(ruta, function(res){
                            if(res.length>0)
                                jQuery("#msjuser").append("Este usuario ya existe!");
                        });
                    }
                }
            }
        
            /*validacion para el correo*/
            if(decision==2)
            {
                $("#msjemail").empty();
                console.log("entreem");
                if(email!=$("#Correo").val())
                {
                    var ruta="http://127.0.0.1:8080/userexist/"+$("#Correo").val()+"/"+decision;
                    if($("#correo").val()!="")
                    {
                        $.get(ruta, function(res){
                            if(res.length>0)
                            {
                                $("#msjemail").empty();
                                jQuery("#msjemail").append("Este email ya existe!");
                                console.log("msjemail");
                            }
                        });
                    }
                }
            }
        }
        //si la casilla "cambiar contraseña" es clickeada
        $('#defaultCheck1').click(function(){
            //habilitamos los campos para la contraseña
            if($("#defaultCheck1").prop('checked')==true)
            {
                $("#contraseña").attr("disabled",false);
                $("#confcontraseña").attr("disabled",false);
                $("#defaultCheck1").val(1);
            }
            else
            {
                $("#contraseña").attr("disabled",true);
                $("#confcontraseña").attr("disabled",true);
                $("#defaultCheck1").val(0);
            }
        });

        $('.delete').on( 'click', function () {
            var row=$(this).parents('tr');
            var route="http://127.0.0.1:8080/usuario/"+$(this).val();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                success: function(){
                    message(['Se elimino al usuario correctamente'],{manual:true});
                    table.row(row).remove().draw( false );
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        });
    </script>
@stop