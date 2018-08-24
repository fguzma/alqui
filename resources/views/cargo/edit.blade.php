@extends('layouts.dashboard')
@section('content')
<div class="card">
    <h4 class="card-header">Editar Cargo</h4>
    <div class="card-body">
    @include('alert.errores')
        {!!Form::model($cargo,['route'=>['cargo.update',$cargo->ID_Cargo],'method'=>'PUT'])!!}
            <div class="row ">
                <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('Nombre del Cargo:')!!}
                        {!!Form::text('Nombre_Cargo',null,['id'=>'Nom', 'class'=>'form-control','placeholder'=>'ej: Conductor'])!!}
                    </div>
                </div>
            </div>
            {!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!}
        {!!Form::close()!!}
    </div>
</div>
@stop