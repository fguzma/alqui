var nica=false;
var edad=0,year=0,month=0,day=0;
function CharCedula(e,campo)
{
    var cedula=campo.value;
    var keynum = (document.all) ? e.keyCode : e.which;; //No se la dvd
    if($("#nacional").prop('checked')==true)//Si es idenficacion Nica
    {
        if( cedula.length<14)//Permitir un maximo de 15 caracteres
        {
            //Rango de caracteres permitidos diferentes a numeros
            if ((((keynum>64 && keynum<91) || (keynum>96 && keynum<123) || (keynum>47 && keynum<10)) && keynum!=8))
            return true;//se escribe
        }
        else
            return false;//No se escribe
        return /\d/.test(String.fromCharCode(keynum));//Solo escribe numeros
    }
}
function formatonica(campo)
{
    if($("#nacional").prop('checked')==true)//Si es idenficacion Nica
    {
        cedula=campo.value;//texto del campo cedula
        if(cedula.length <16 && nica==true)//si es menor a la cantidad de 16 char y tiene aplicado el formato nica
        {
            var temp="";
            for(i=0; i<cedula.length; i++)//recorremos el string para quitar los guiones
            {
                if(cedula[i]!="-")
                    temp+=cedula[i];
            }
            campo.value=temp;//escribimos en el campo
            nica=false;//formato nica false
            edad=year=month=day=0;
        }
        if( cedula.length==14)//Permitir un maximo de 15 caracteres
        {
            //aplicamos formato nica
            campo.value=(cedula.substr(0,3)+'-'+cedula.substr(3,6)+'-'+cedula.substr(9,4)+cedula[13].toUpperCase());
            nica=true;
            var hoy = new Date();
            year=cedula.substr(7,2)*1;
            month=cedula.substr(5,2);
            day=cedula.substr(3,2);
            var millennial=hoy.getFullYear()-year;
            if(millennial>=2000)
                year="20"+cedula.substr(7,2);
            var fechanac = new Date(year+'-'+month+'-'+day);
      
            edad = hoy.getTime() - fechanac;
            edad = Math.trunc((edad)/(1000*60*60*24*365));
        }
    }
}