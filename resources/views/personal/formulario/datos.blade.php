        

          <div class="row ">
            <div class="col-md-2"></div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Nombre:')!!}
                  {!!Form::text('Nombre',null,['id'=>'Nombre','class'=>'form-control','placeholder'=>'Nombre del Personal'])!!}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Apellido:')!!}
                  {!!Form::text('Apellido',null,['id'=>'Apellido','class'=>'form-control','placeholder'=>'Apellido del Personal'])!!}
              </div>
            </div>
            <div class="col-md-2"></div>
          </div>

           <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Direccion:')!!}
                  {!!Form::text('Direccion',null,['id'=>'Direccion','class'=>'form-control','placeholder'=>'Direccion del personal'])!!}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Fehca de nacimiento:')!!}
                  <div  class="input-group ">
                    {!!Form::text('Fecha_Nac',null,['id'=>'Fecha_Nac','class'=>'form-control','placeholder'=>' año-mes-dia'])!!}
                    <div class="input-group-append">
                      <button class="btn btn-primary fa fa-eye" onclick="mostrarfechanac();"  type="button"></button>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-2"></div>
          </div> 

          