@extends('layouts.dashboard')
@section('content')
<div class="card">
    <h4 class="card-header">Editar Cliente</h4>
    <div class="card-body">
    @include('alert.errores')
        {!!Form::model($articulo,['route'=>['inventario.update',$articulo->ID_Objeto],'method'=>'PUT'])!!}
            @include('inventario.formulario.datos')
            <div class="text-center">
            {!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!}
        </div >
        {!!Form::close()!!}
    </div>
</div>
@stop