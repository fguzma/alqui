@extends('layouts.dashboard')
@section('content')
    <div class="d-block bg-primary" style="padding-top: 10px;">
        <div class="row ">
            <div class="col-md-6">
                <div class="form-group">
                    {!!Form::select('size', ['fechafac' => 'Filtrar por fecha de facturacion', 'CC' => 'Filtrar por cedula de cliente', 'NC' => 'Filtrar por nombre de cliente'], null, ['class'=>'form-control','placeholder' => 'Filtar por:','id'=>'tipofil','onchange="filtro();"']);!!}
                    <!--<select onchange="filtro();" class="form-control" id="tipofil">
                        <option></option>
                        <option>Filtrar por fecha de facturacion</option>
                        <option>Filtrar por cedula de cliente</option>
                        <option>Filtrar por nombre de cliente</option>
                    </select>-->
                </div>
            </div>
            <div class="col-md" >
                <div class="form-group" >
                    {!!Form::text('valorfilro',null,['id'=>'valorf', 'class'=>'form-control','placeholder'=>'Ingrese el valor segun el tipo de filtro', 'onkeyup="filtro();"'])!!}
                </div>
            </div>
        </div>
        @include('alert.mensaje')
        <!--Mejorar la vista de las reservaciones y terminar el filtro por fecha de facturacion, fechaI,FechaF-->
        <div style="overflow-x: auto; min-width:80%;">
            <table class="table table-hover table-inverse">
                <thead>
                    <th style="width:13%;" >Fecha Facturacion</th>
                    <th style="width:13%;" class="text-center">Fecha Inicio</th>
                    <th style="width:13%;" class="text-center" >Fecha Fin</th>
                    <th style="width:20%;" class="text-center" >Nombre</th>
                    <th style="width:20%;" class="text-center">Cedula</th>
                    <th style="width:21%;" class="text-center">Direccion</th>
                </thead>
                <tbody class="text-center" id="lista"    > 
                    @include('reservacion.recargable.listareservas')
                </tbody>
            </table>
        </div>
        {!!$reservas->render("pagination::bootstrap-4")!!}
    </div>
    <script>
        var tfiltro=0;
        var valorfil=0;
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
            console.log(tfiltro+"--"+valorfil);
            var ruta="http://127.0.0.1:8080/filtroreservas/"+tfiltro+'/'+valorfil;
            console.log(ruta);
            var token=$("#token").val();
            $.get(ruta, function(res){
                $("#lista").empty();//Elimina la lista actual
                //$(".pagination").remove();
                jQuery("#lista").append(res);//Actualiza la lista
            });
        }
    </script>
@stop