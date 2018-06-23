        

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
                  {!!Form::text('Apellido',null,['id'=>'Apellido','class'=>'form-control','placeholder'=>'cliente'])!!}
              </div>
            </div>
            <div class="col-md-2"></div>
          </div>

           <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Edad:')!!}
                  {!!Form::text('Edad',null,['id'=>'Edad','class'=>'form-control','placeholder'=>'Edad del Cliente'])!!}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('Sexo:')!!}
<!--                  {!!Form::text('Sexo',null,['id'=>'Sexo','class'=>'form-control','placeholder'=>'Sexo del Cliente'])!!}-->
                  {!!Form::select('Sexo', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'], null, ['placeholder' => 'Sexo','class'=>'form-control', 'id'=>'Sexo'])!!}
              </div>
            </div>
            <div class="col-md-2"></div>
          </div> 

          