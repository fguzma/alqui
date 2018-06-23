@extends('layouts.dashboard')
@section('content')
<!--Arreglar toda la mierda que hiciste-->
    <div class="d-block bg bg-dark" style="padding-top: 10px; color:white;visibility:hidden;" id="main">
        @include('alert.mensaje')
        <div id="mensaje"></div>
        <!--class="table table-striped table-bordered"-->
        <table class="table table-bordered table-hover table-dark" cellspacing="0" id="Datos" style="width:100%;" >
            <thead>
                <tr>
                    <th class="text-center" >Cedula</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Apellido</th>
                    <th class="text-center">Edad</th>
                    <th class="text-center">Sexo</th>
                    <th class="text-center" data-orderable="false" style="width:20%"></th>
                </tr>
            </thead >
            <tbody class="text-center" id="lista" >
                @include('cliente.recargable.listaclientes')
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
                        <input type="hidden" id="ce">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <div class="row ">
                            <div class="col-md-3 "></div>
                            <div class="col-md-6 ">
                                <div class="form-group text-center">
                                    {!!Form::label('Cedula','Cedula:')!!}
                                    {!!Form::text('Cedula_Cliente',null,['class'=>'form-control','placeholder'=>'xxx-xxxxxx-xxxxx','id="cedula"'])!!}    
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Nombre:')!!}
                                    {!!Form::text('Nombre',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre del Cliente'])!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Apellido:')!!}
                                    {!!Form::text('Apellido',null,['id'=>'apellido','class'=>'form-control','placeholder'=>'Apellido del Cliente'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Edad:')!!}
                                    {!!Form::text('Edad',null,['id'=>'edad','class'=>'form-control','placeholder'=>'Edad del Cliente'])!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!!Form::label('Sexo:')!!}
                    <!--                  {!!Form::text('Sexo',null,['id'=>'Sexo','class'=>'form-control','placeholder'=>'Sexo del Cliente'])!!}-->
                                    {!!Form::select('Sexo', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'], null, ['placeholder' => 'Sexo','class'=>'form-control', 'id'=>'sexo'])!!}
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


    <script>

        var table;
        var fila;
        $(document).ready( function () {
            //Agregar filtros especificos parte1
            /*$('#Datos tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );*/
            //Creacion de la tabla
            table= $('#Datos').DataTable({
                //stateSave: true,
                "pagingType": "full_numbers",//botones primero, anterio,siguiente, ultimo y numeros
                "order": [[ 1, "asc" ]],//ordenara por defecto en la columna Nombre de forma ascendente
                //"dom": '<"top" lf>rt<"bottom"ip>',//asignamos al div con clase top el filtro y longitud y en parte inferior la pginacion
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
                //Otra forma de asignar el lenguaje es esta
                /*"language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },*/
                
                //Definimos la cantidad de registros que se podran mostrar
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
                
            }).search('{!!session("valor")!!}').draw();

            /*$('#Datos tbody').on('click', 'tr', function () {//Recopilacion de informacion en la tabla
                var data = table.row( this ).data();
                alert( 'You clicked on '+data[1]+" "+data[2]+'\'s row' );
            } );*/

            /*var eventFired = function ( type ) {//Funcion para demostrar los eventos de datatables
                var n = $('#temporal')[0];
                n.innerHTML += '<div>'+type+' event - '+new Date().getTime()+'</div>';
                n.scrollTop = n.scrollHeight;      
            }
            //Eventos de datatables
            $('#Datos')
                .on( 'order.dt',  function () { eventFired( 'Ordenar' ); } )
                .on( 'search.dt', function () { eventFired( 'Buscar' ); } )
                .on( 'page.dt',   function () { eventFired( 'Paginacion' ); } )
                .DataTable();*/

                //Agregar filtros especificos parte2
                // Apply the search
                /*table.columns().every( function () {
                    var that = this;
                    console.log(that.search());
                    console.log(this.value);
            
                    $( 'input', this.footer() ).on( 'keyup change', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                    console.log("entra");
                        }
                    } );
                } );*/

            //Filtro "manual"
            //table.column(0)search( '001-010997-0012P' ).draw();
            //Para personalizar el buscador a busquedas especificas https://datatables.net/examples/api/regex.html
            
            $("#main").css("visibility", "visible");
        });
        $('.delete').on( 'click', function () {
            console.log(table.row($(this).parents('tr')).data());
            table.row($(this).parents('tr')).remove().draw( false );
        });
        function erase(cedula)
        {
            var route="https://alqui.herokuapp.com/cliente/"+cedula;
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                success: function(){
                    message(['Se elimino al cliente correctamente'],{manual:true});
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                message(jqXHR,{tipo:"danger"});
            });
        }
        $('.edit').on( 'click', function () {
            fila=$(this).parents('tr');//Dejamos almacenada temporalmente la fila en la que clickeamos editar
            var row=table.row(fila).data();//Tomamos el contenido de la fila 
            //Sobreescribimos en los campos editables los datos del cliente
            $("#cedula").val(row[0]);
            $("#nombre").val(row[1]);
            $("#apellido").val(row[2]);
            $("#edad").val(row[3]);
            $("#sexo").val(row[4]);
            $("#ce").val(row[0]);//Campo que almacena la cedula inicial
        });
        function actualizar()
        {
            route="https://alqui.herokuapp.com/cliente/"+$("#ce").val();
            var token=$("#token").val();
            $.ajax({
                url: route,
                headers:{'X-CSRF-TOKEN': token},
                type: 'PUT',
                dataType: 'json',
                data:$("#data").serialize(),
                success: function(res){
                    console.log(res);
                    console.log('edita2');
                    if(res==1)
                    {
                        message(['Cliente editado correctamente'],{manual:true});
                        table.cell(fila.children('td')[0]).data( $("#cedula").val());
                        table.cell(fila.children('td')[1]).data( $("#nombre").val());
                        table.cell(fila.children('td')[2]).data( $("#apellido").val());
                        table.cell(fila.children('td')[3]).data( $("#edad").val());
                        table.cell(fila.children('td')[4]).data( $("#sexo").val());
                        fila.children('td.botones').children('input.delete').removeAttr( "onclick");//Eliminamos la funcion onclick del boton eliminar
                        fila.children('td.botones').children('input.delete').attr( "onclick",'erase(\''+$("#cedula").val()+'\');');//Agregamos la funcion onclick con el nuevo parametro
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
    </script>
@stop