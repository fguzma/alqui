        

          <div class="row ">
            <div class="col-md-2"></div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Nombre:')!!}
                  {!!Form::text('Nombre',null,['id'=>'Nombre','class'=>'form-control','placeholder'=>'Nombre del Cliente'])!!}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Apellido:')!!}
                  {!!Form::text('Apellido',null,['id'=>'Apellido','class'=>'form-control','placeholder'=>'Apellido del Cliente'])!!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
              <div class="form-group">
                {!!Form::label('Edad:')!!}
                <div  class="input-group ">
                  {!!Form::text('Edad',null,['id'=>'Edad','class'=>'form-control','placeholder'=>'Edad del Cliente'])!!}
                  <div class="input-group-append">
                    <button class="btn btn-primary fa fa-eye" onclick="mostraredad();"  type="button"></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Sexo:')!!}
                  {!!Form::select('Sexo', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'], null, ['placeholder' => 'Sexo','class'=>'form-control', 'id'=>'Sexo'])!!}
              </div>
            </div>
          </div> 
          <div class="row ">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div class="form-group">
                  {!!Form::label('*Direccion:')!!}
                  {!!Form::text('Direccion',null,['id'=>'Direccion','class'=>'form-control','placeholder'=>'Direccion del Cliente'])!!}
              </div>
            </div>
          </div>

          