        

        <div class="row ">
          <div class="col-md-3 "></div>
          <div class="col-md-6 ">
            <div class="form-group text-center">
                {!!Form::label('Descripcion','Descripcion:')!!}
                <textarea name="descripcion" class="form-control" placeholder="Especifique el servicio de comida" id="descripcion" rows="3"></textarea>
          </div>
          </div>
        </div>
        <div class="row ">
          <div class="col-md-2"></div>
          <div class="col-md-4">
            <div class="form-group">
                {!!Form::label('Costo:')!!}
                {!!Form::text('costo',null,['id'=>'costo','class'=>'form-control','placeholder'=>'Costo'])!!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                {!!Form::label('Imagen:')!!}
                {!!Form::file('path',['value'=>'subir imagen','id'=>'path','class'=>'btn btn-secondary'])!!}
            </div>
          </div>
        </div>

          