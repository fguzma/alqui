@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg bg-dark" style="color:white; padding-top: 10px;visibility:hidden;" id="main">
        @include('alert.mensaje')
        <div id="mensaje"></div>
        <table class="table table-hover table-dark" cellspacing="0" id="Datos" style="width:100%;">
            <thead>
                <th class="text-center" data-orderable="false">Imagen</th>
                <th class="text-center">Descripcion</th>
                <th class="text-center">Costo</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody class="text-center" id="lista"> 
                @include('menu.recargable.listamenu')
            </tbody>
        </table>
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
                <form action="{{ route('menus.update', 18)}}" method="POST" id="data" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <input type="hidden" id="id">
                        <div class="row ">
                            <div class="col-md-1 "></div>
                            <div class="col-md-10 ">
                                <div class="form-group text-center">
                                    {!!Form::label('Descripcion','Descripcion:')!!}
                                    <textarea name="descripcion" class="form-control" placeholder="Especifique el servicio de comida" id="descripcion" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-1 "></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!!Form::label('Costo:')!!}
                                    {!!Form::text('costo',null,['id'=>'costo','class'=>'form-control','placeholder'=>'Costo'])!!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="row ">
                            <div class="col-md-1 "></div>
                            <div class="col-md-10 text-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="0" id="defaultCheck1" name="sinimagen">
                                    <label class="form-check-label " for="defaultCheck1">
                                        Sin imagen
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row " >
                            <div class="col-md-1 "></div>
                            <div class="col-md-10" id="fileimagen">
                                {!!Form::label('Imagen:')!!}
                                <div class="form-group">
                                    {!!Form::file('path',['value'=>'subir imagen','id'=>'path','class'=>'btn btn-secondary col-md-12'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-1 "></div>
                            <div class="col-md-10 text-center" id="imagen" >

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="actualizar();" >Actualizar</button>
                            
                        </div>
                    </form>
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
            $("#descripcion").val(row[1]);
            $("#costo").val(row[2]);
            $("#imagen").empty();
            $("#imagen").append(row[0]);
            $("#id").val($(this).val());
        });
        function actualizar()
        {
            route="http://127.0.0.1:8080/menus/"+$("#id").val();
            var token=$("#token").val();
            var formData = new FormData($('#data')[0]);
            console.log(formData);
             $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'POST',
                data:formData,
                contentType: false,
                processData: false,
                success: function(res){
                    console.log(res);
                    if(res!=1)//Si agrego una nueva imagen
                    {
                        table.cell(fila.children('td')[0]).data( '<img src="https://s3.us-east-2.amazonaws.com/pruebakavv/Menu/'+res+'"style="height:10em;border-radius: 40px;"> ');
                    }
                    
                    message(['Menu editado correctamente'],{manual:true});
                    table.cell(fila.children('td')[1]).data( $("#descripcion").val());
                    table.cell(fila.children('td')[2]).data( $("#costo").val());
                    table=$("#Datos").DataTable().draw(); 
                    
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            }); 
        }

        $('.delete').on( 'click', function () {
            
            var row=$(this).parents('tr');
            var route="http://127.0.0.1:8080/menus/"+$(this).val();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                success: function(){
                    message(['Se elimino correctamente'],{manual:true});
                    table.row(row).remove().draw( false );
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        });
        function erase(cedula)
        {
            
        }
        //VISTA PREVIA DE LA IMAGEN A ACTUALIZAR
        $('#path').change(function(e) {
            addImage(e); 
        });
        var file;
        function addImage(e){
            file = e.target.files[0],
            imageType = /image.*/;
            
            if (!file.type.match(imageType))
            return;
        
            var reader = new FileReader();
            reader.onload = fileOnload;
            reader.readAsDataURL(file);
        }
        var result;//USAR ESTO PARA MOSTRAR DIRECTAMENTE LA IMAGEN SIN TENER QUE CARGARLA DESDE LA NUBE
        function fileOnload(e) {
            result=e.target.result;
            $("#imagen").empty();
            $("#imagen").append('<image class="col-md-10" style="border-radius: 40px;" src="'+result+'">');
        }
        //Sin imagen
        $('#defaultCheck1').click(function(){
            if($("#defaultCheck1").prop('checked')==true)
            {
                $("#fileimagen").hide();
                $("#imagen").hide();
                $("#defaultCheck1").val(1);
            }
            else
            {
                $("#fileimagen").show();
                $("#imagen").show();
                $("#defaultCheck1").val(0);
            }
        });
    </script>
@stop