        

          <div class="row ">
            <div class="col-md-2"></div>
            <div class="col-md-4">
              <div class="form-group">
                {!!Form::label('Usuario:')!!}
                {!!Form::text('Usuario',null,['autocomplete'=>'off','id'=>'usuario','class'=>'form-control','placeholder'=>'Ejemplo123'])!!}
                <spam id="msjuser" style="color:red;"></spam> 
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {!!Form::label('*Identificacion:')!!}
                {!!Form::text('identificacion',null,['id'=>'identificacion','class'=>'form-control','placeholder'=>'Cedula'])!!}
              </div>
            </div>
          </div>

           <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
              <div class="form-group">
                {!!Form::label('Contraseña:')!!}
                <input type="password" class="form-control"  name="contraseña" id="contraseña" placeholder="*******" onkeyup="coinciden();">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {!!Form::label('Confirmar Contraseña:')!!}
                <input type="password" class="form-control"  name="confcontraseña" id="confcontraseña" placeholder="*******" onkeyup="coinciden();">
                <spam id="msjpass" style="color:red;"></spam>
              </div>
            </div>
          </div> 

          
          