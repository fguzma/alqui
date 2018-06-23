var nica=true;
function cedulanica(e,campo)
{
    //importante "evaluamos siempre mediante la longitud del campo"
    var pos=campo.value.length;
    var cedula=campo.value;
    var keynum = (document.all) ? e.keyCode : e.which;; 
    //console.log(pos);
    if(keynum!=8 && nica!=false)
    {
        //console.log(pos);
        if(pos==3 || pos==10)//las posiciones donde van las "-"
        {
        campo.value=campo.value+"-";
        }
        if(nica==true && pos>15)//Seccion de codigo para quitar los guiones de la cedula
        {
        var ce="";
        for(var i=0; i<pos; i++)
        {
            if(cedula[i]!="-")
            {
            ce+=cedula[i];
            }
        }
        campo.value=ce;
        nica=false;
        //console.log(nica);
        }
    }
    //console.log(nica);   
    if(keynum==8)//si preciono la tecla borrar/retroceso
    {
        //console.log(cedula.substr(3,1));
        campo.value=cedula.substr(0,(cedula.length-1));
    }
    //console.log(keynum);
    //validacion para las teclas que no son permitidas
    if ((((keynum>64 && keynum<91) || (keynum>96 && keynum<123) || (keynum>47 && keynum<10)) && keynum!=8))
    return true;

    return /\d/.test(String.fromCharCode(keynum));
}
/*VULNERABLE Si no suelto la tecla de borrar no se pondra el formato nica*/ 
function formatonica(campo)
{
    /*Si la cedula no era nica y entra nuevamente a los rangos de la cedula nica, se ponen los guiones*/
    var cedula=campo.value;
    var pos=campo.value.length;
    //console.log(pos);
    if(nica==false && pos==14 )
    {
        //console.log("menor y falso");
        nica=true;
        var ce="";
        for(var i=0; i<pos; i++)
        {
        if(i==3 || i==9)
            ce+="-"+cedula[i];
        else
            ce+=cedula[i];
        }
        campo.value=ce;
    }
}
function filtrocedulacli(vista)
{
    var ruta="https://alqui.herokuapp.com/filtrocliente/"+vista+"/"+$("#cedu").val();
    console.log($("#cedu").val());
    var token=$("#token").val();
    
    $.get(ruta, function(res){
        $('#pag').empty();
        $("#lista").empty();//Elimina la lista actual
        //$(".pagination").remove();
        jQuery("#lista").append(res);//Actualiza la lista
        
    });
}
function filtrocedulaper(vista)
{
    var ruta="https://alqui.herokuapp.com/filtropersonal/"+vista+"/"+$("#cedu").val();
    var token=$("#token").val();
    $.get(ruta, function(res){
        $("#lista").empty();//Elimina la lista actual
        //$(".pagination").remove();
        jQuery("#lista").append(res);//Actualiza la lista
        $('#Datos').DataTable();
    });
}