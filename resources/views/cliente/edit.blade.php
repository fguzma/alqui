@extends('layouts.dashboard')
@section('content')
<div class="card">
    <h4 class="card-header">Editar Cliente</h4>
    <div class="card-body">
    @include('alert.errores')
        {!!Form::model($cliente,['route'=>['cliente.update',$cliente->Cedula_Cliente],'method'=>'PUT'])!!}
            <div class="row ">
                <div class="col-md-3 "></div>
                    <div class="col-md-6 ">
                        <div class="form-group text-center">
                            {!!Form::label('Cedula','Cedula:')!!}
                            {!!Form::label('cedu',$cliente->Cedula_Cliente,['class' => 'badge badge-pill badge-info'])!!}
                        </div>
                </div>
            </div>
            @include('cliente.formulario.datos')
            <div class="text-center">
            {!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!}
        </div >
        {!!Form::close()!!}
    </div>
</div>
@stop