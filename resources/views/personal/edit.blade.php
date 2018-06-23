@extends('layouts.dashboard')
@section('content')
<div class="card">
    <h4 class="card-header">Editar Personal </h4>
    <div class="card-body">
    @include('alert.errores')
        {!!Form::model($trabajador,['id'=>'data','route'=>['personal.update',$trabajador->Cedula_Personal],'method'=>'PUT'])!!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="row ">
            <div class="col-md-3 "></div>
                <div class="col-md-6 ">
                <div class="form-group text-center">
                    {!!Form::label('Cedula','Cedula:')!!}
                    {!!Form::label('cedu',$trabajador->Cedula_Personal,['id'=>'cedula','value'=>$trabajador->Cedula_Personal,'class' => 'badge badge-pill badge-info'])!!}
                </div>
            </div>
            </div>
            @include('personal.formulario.datos')
            
            <!--Tabla de cargos-->
            <div class="row" >
                <div class="col-md-2"></div>
                <div class="col-md-8" id="lc">
                    <div class="list-group " id="list-tab" role="tablist" style="height:15em;width:auto; overflow:scroll;border-radius: 40px;">
                        <table class="table table-hover table-inverse">
                            <thead>
                            <tr>
                                <th class="text-center">Cargo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Cargos as $cargo)
                                <tr>
                                    <td >{!!$cargo->Nombre_Cargo!!}</td>
                                    <td class="btn-primary text-center">
                                        <input id="{!!$cargo->ID_Cargo!!}"  type="checkbox" OnClick='addcargo(this,"{!!$cargo->ID_Cargo!!}")'>
                                    </td>
                                </tr>  
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <input class="btn btn-primary" type="button" id="Agregar" onclick="guardar();" value="Actualizar">
            </div>
        {!!Form::close()!!}
    </div>
</div>
@stop
@section('script')
    {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
    <script>
    var listacargo=new Object();
    var oldlistacargo=new Object();
        $( document ).ready(function(){
            var idcargos={!!$idcargos!!}
            for(var ic in idcargos)
            {
                $("#"+idcargos[ic].ID_Cargo).prop('checked', true);
                oldlistacargo[idcargos[ic].ID_Cargo]=[idcargos[ic].ID_Cargo];
                listacargo[idcargos[ic].ID_Cargo]=[idcargos[ic].ID_Cargo];
            }

        });
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
        function guardar()
        {
            var ruta = "https://alqui.herokuapp.com/personal/"+$("#cedula").text()+"";
            var token = $("#token").val();
            //Consulta para añadir el nuevo personal
            $.ajax({
            url: ruta,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data:$("#data").serialize(),
            success: function(res){
                console.log("segundo");
                ruta="https://alqui.herokuapp.com/pcargoupdate";
                //Consulta para agregar los cargos que se han predefinido del personal
                $.ajax({
                url:ruta,
                headers: {'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {'oldlistacargo':oldlistacargo,'listacargo':listacargo,'cedula':$("#cedula").text()},
                success: function(res)
                {
                    console.log("cargo agregado");
                }
                }).fail( function( jqXHR, textStatus, errorThrown ) {
                    message(jqXHR,{tipo:"danger"});
                });
                console.log("se agrego");
                location.href ="https://alqui.herokuapp.com/personalv/2/"+$("#cedula").text();
                return;
            }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                console.log("error");
                message(jqXHR,{tipo:"danger"});
            });
        }
    </script>
@stop