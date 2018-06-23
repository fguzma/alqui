@extends('layouts.dashboard')
@section('content')
  <div class="card" >
    <h4 class="card-header">Agregar Usuario</h4>
    <div class="card-body">
    <div id="mensaje"></div>
      <form action="{{route('usuario.store')}}" method="POST" id="data">

        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <div class="row ">
          <div class="col-md-3 "></div>
          <div class="col-md-6 ">
            <div class="form-group text-center">
                {!!Form::label('Correo:')!!}
                {!!Form::text('correo',null,['id'=>'Correo','class'=>'form-control','placeholder'=>'ejemplo@hotmail.com','onkeyup'=>'existe("2");','autocomplete'=>'off'])!!}
                <spam id="msjemail" style="color:red;"></spam> 
            </div>
          </div>
        </div>
        @include('usuario.formulario.datos')
        <div class="text-center">
          <button class="btn btn-primary agregar" type="button" onclick="save('save')"  disabled="disabled">Guardar</button>
          <button class="btn btn-primary agregar" type="button" onclick="save('savev')" disabled="disabled">Guardar y ver</button>
        </div >
      </form>
    </div>
  </div>
@stop
@section('script')
  {!!Html::script("js/jskevin/tiposmensajes.js")!!} 
  <script>
    var correcto=true;
    function coinciden()
    {
        var contra1=$("#contraseña").val();
        var contra2=$("#confcontraseña").val();
        /*si estan vacios los campos*/
        if(contra1.length==0)
        {
          $("#msjpass").empty();
          $(".agregar").attr("disabled", true);
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
              $(".agregar").attr("disabled", true);
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
            $(".agregar").attr("disabled", true);
            return;
          }
          else
          {
            correcto=true;
            $(".agregar").attr("disabled", false);
          }
        }
    }
    function existe(decision)
    {
      /*validacion para el usuario*/
      if(decision==1)
      {
        var ruta="https://alqui.herokuapp.com/userexist/"+$("#usuario").val()+"/"+decision;
        if($("#usuario").val()!="")
        {
          $.get(ruta, function(res){
              if(res.length>0)
                jQuery("#msjuser").append("Este usuario ya existe!");
              else
                $("#msjuser").empty();
          });
        }
      }

      /*validacion para el correo*/
      if(decision==2)
      {
        var ruta="https://alqui.herokuapp.com/userexist/"+$("#Correo").val()+"/"+decision;
        if($("#correo").val()!="")
        {
          $.get(ruta, function(res){
              if(res.length>0)
                jQuery("#msjemail").append("Este email ya existe!");
              else
                $("#msjemail").empty();
          });
        }
      }
    }
    function save(condition)
    {
      var ruta="https://alqui.herokuapp.com/usuario";
      var token=$("#token").val();
      $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:$("#data").serialize(),
        success: function(result){
          if(result==1)
          {
            if(condition=="save")
            {
              message(["Usuario agregado exitosamente"],{manual:true})
              limpiar();
            }
            if(condition=="savev")
            {
              location.href="https://alqui.herokuapp.com/usuariov/1/"+$("#Correo").val();
            }
          }
          else
          {
            message(['Hay un problema con su contraseña'],{manual:true,tipo:'danger'});
          }
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
        console.log(jqXHR.responseJSON);
        message(jqXHR,{tipo:"danger"});
      });
    }
    function limpiar()
    {

    }
  </script>
@stop