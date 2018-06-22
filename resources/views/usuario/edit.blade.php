@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <h4 class="card-header">Editar Usuario</h4>
        <div class="card-body">
            @include('alert.errores')
            @include('alert.mensaje')
            {!!Form::model($usuario[0],['route'=>['usuario.update',$usuario[0]["id"]],'method'=>'PUT'])!!}
                <div class="row ">
                    <div class="col-md-3 "></div>
                    <div class="col-md-6 ">
                        <div class="form-group text-center">
                            {!!Form::label('correo')!!}
                            {!!Form::text('correo',$usuario[0]["email"],['autocomplete'=>'off','id'=>'Correo','class' => 'form-control','placeholder'=>'ejemplo@hotmail.com','onkeyup'=>'existe("2");'])!!}
                            <spam id="msjemail" style="color:red;"></spam> 
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('Usuario:')!!}
                            {!!Form::text('Usuario',$usuario[0]["name"],['autocomplete'=>'off','id'=>'usuario','class'=>'form-control','placeholder'=>'Ejemplo123','onkeyup'=>'existe("1");'])!!}
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
                <hr class="bg-info"/>
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="0" id="defaultCheck1" name="restablecerpass">
                            <label class="form-check-label " for="defaultCheck1">
                                Cambiar Contraseña
                            </label>
                        </div>
                    </div>
                </div>
                <hr class="bg-info"/>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('Cambiar Contraseña:')!!}
                            <input type="password" class="form-control"  name="contraseña" id="contraseña" placeholder="*******" onkeyup="coinciden();" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('Confirmar Nueva Contraseña:')!!}
                            <input type="password" class="form-control"  name="confcontraseña" id="confcontraseña" placeholder="*******" onkeyup="coinciden();" disabled>
                            <spam id="msjpass" style="color:red;"></spam>
                        </div>
                    </div>
                </div> 
            <div class="text-center">
            {!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!}
        </div >
            {!!Form::close()!!}
        </div>
    </div>


@stop
@section('script')
  <script>
    var email=$("#Correo").val();
    var user=$("#usuario").val();
    var correcto=true;
    function coinciden()
    {
        var contra1=$("#contraseña").val();
        var contra2=$("#confcontraseña").val();
        /*si estan vacios los campos*/
        if(contra1.length==0)
        {
          $("#msjpass").empty();
          $("#agregar").attr("disabled", true);
          correcto=true;/*enrealidad no esta correcto, es para no crear conflicto*/
          return;
        }
        /*validar que sean iguales*/
        if(contra1!=contra2)
        {
            if(correcto==true)/*condicion con el fin de evitar sobre escribir cada momento en #msjpass*/
            {
              jQuery("#msjpass").append("No coinciden las contraseñas!");
              correcto=false;
              $("#agregar").attr("disabled", true);
              return;
            }
        }
        else
        {
          $("#msjpass").empty();
          /*Validar longitud*/
          if(contra1.length < 6)
          {
            jQuery("#msjpass").append("La longitud de la contraseña debe ser mayor a 5");
            correcto=false;
            $("#agregar").attr("disabled", true);
            return;
          }
          else
          {
            correcto=true;
            $("#agregar").attr("disabled", false);
          }
        }
    }
    function existe(decision)
    {
      /*validacion para el usuario*/
        if(decision==1)
        {
            $("#msjuser").empty();
                        console.log("entreus");
            if(user!=$("#usuario").val())
            {
                var ruta="http://127.0.0.1:8080/userexist/"+$("#usuario").val()+"/"+decision;
                if($("#usuario").val()!="")
                {
                    $.get(ruta, function(res){
                        if(res.length>0)
                            jQuery("#msjuser").append("Este usuario ya existe!");
                    });
                }
            }
        }
      
        /*validacion para el correo*/
        if(decision==2)
        {
            $("#msjemail").empty();
            console.log("entreem");
            if(email!=$("#Correo").val())
            {
                var ruta="http://127.0.0.1:8080/userexist/"+$("#Correo").val()+"/"+decision;
                if($("#correo").val()!="")
                {
                    $.get(ruta, function(res){
                        if(res.length>0)
                            jQuery("#msjemail").append("Este email ya existe!");
                    });
                }
            }
        }
    }
    //si la casilla "cambiar contraseña" es clickeada
    $('#defaultCheck1').click(function(){
        console.log($("#defaultCheck1").prop('checked'));
        //habilitamos los campos para la contraseña
        if($("#defaultCheck1").prop('checked')==true)
        {
            $("#contraseña").attr("disabled",false);
            $("#confcontraseña").attr("disabled",false);
            $("#defaultCheck1").val(1);
        }
        else
        {
            $("#contraseña").attr("disabled",true);
            $("#confcontraseña").attr("disabled",true);
            $("#defaultCheck1").val(0);
        }
    })
  </script>
@stop