@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <h4 class="card-header">Editar Cliente</h4>
        <div class="card-body">
        @include('alert.errores')
            {!!Form::model($servicio,['route'=>['servicio.update',$servicio->ID_Servicio],'method'=>'PUT'])!!}
                @include('servicio.formulario.datos')
                {!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!}
            {!!Form::close()!!}
        </div>
    </div>
@stop