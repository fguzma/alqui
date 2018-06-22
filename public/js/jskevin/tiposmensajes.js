function message(errores,{manual=false,objeto=$("#mensaje"),tipo="info"}={})
{
    var html='<div class="alert alert-'+tipo+' alert-dismissible" role="alert">'+
    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
    '<ul>';
    if(manual!=true)
    {
        if(errores.responseJSON==null)//Si el error ocurrido es desconocido o no esperado
        {
            html+='<li>Ooopps!!!... parece que ocurrio un error :( </li>';
        }
        else
        {
            $.each(errores.responseJSON,function(indice,valor){
                console.log("entra a each");

                    html+='<li>'+valor+'</li>';
            });
        }
    }
    else
    {
        for(var x=0; x<errores.length; x++)
        {
            html+='<li>'+errores[x]+'</li>';
        }
    }    
    html+='</ul>'+
    '</div>';
    objeto.empty();//Elimina la lista actual
    objeto.append(html);//Actualiza la lista
}
