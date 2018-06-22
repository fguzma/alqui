<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>
    
  </head>
  <body>
 
<div id="parte2" class="carousel-item">
    <div class="card">
        <h4 class="card-header">Reservar</h4>
        <div class="card-body">
        <div class="row ">
            <div class="col-md">
            <div class="form-group">
                {!!Form::label('','',['id'=>'lf','class' => 'badge badge-pill badge-info'])!!}
            </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-6 ">
            <div class="form-group text-center">
                {!!Form::label('','Cliente:')!!}
                <a>{{$NC}}</a>
                {!!Form::label('','/')!!}
                <a>{{$CC}}</a>
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md">
            <div class="form-group">
                {!!Form::label('','Direccion: ')!!}
                <a>{{$DL}}</a>
            </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-md-6">
            <div class="form-group">
                {!!Form::label('','Fecha de Inicio: ')!!}
                <a>{{$FI}}</a>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                {!!Form::label('','Fecha de Fin: ')!!}
                <a>{{$FF}}</a>
            </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md">
            <div class="form-group">
                <table class="table table-hover" id="tablaB">
                <thead>
                    <tr id="fila0" value="0">
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Costo Alquiler</th>
                    <th>Costo Total</th>
                    </tr>
                </thead>
                <tbody id="artifin">
                </tbody>
                </table>   
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Ingresar Reserva"> 
            </div>
            </div>
        </div> 
        
        </div>
    </div>
</div>

  </body>
</html>