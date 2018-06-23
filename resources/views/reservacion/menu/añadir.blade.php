
  <div class="card">
    <h4 class="card-header">Agregar al menu</h4>
    <div class="card-body">
    <div id="mensajemenuc"></div>
      {!!Form::open(['route'=>'menus.store', 'method'=>'POST', 'id' => 'datamenu','enctype'=>'multipart/form-data'])!!}
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenmenu">
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
        
        <div class="row " >
            <div class="col-md-1 "></div>
            <div class="col-md-10" id="fileimagen">
                {!!Form::label('Imagen:')!!}
                <div class="form-group">
                    {!!Form::file('path',['value'=>'subir imagen','id'=>'path','class'=>'btn btn-dark col-md-12'])!!}
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-1 "></div>
            <div class="col-md-10 text-center" id="imagen" >

            </div>
        </div>

      {!!Form::close()!!}
    </div>
  </div>   
