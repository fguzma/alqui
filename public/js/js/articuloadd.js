$(document).ready(function(){
   /* var tabladatos=$("#datos");
    var route="http://localhost:8080/add";
    
    $.get(route,function(res){
        $(res).each(function(key,value){
            tabladatos.append("<tr><td>"+value.Nombre+"</td><td><button value="+value.id+" OnClick='Mostrar(this);' class='btn btn-primary'>")
        });
    });*/
});
var item;
$(".mostrar").on('click',function(){
    item=$(this).parent('td').parent('tr');
    $("#id").val($(this).val());

/*    var route="http://127.0.0.1:8080/reservacion/"+$(this).val()+"/edit";
    //revisar esto... si ya tengo el id ... es necesario enviarlo para que me lo devuelva el objeto en este momento?
    $.get(route, function(res){
        $("#id").val(res.ID_Objeto);
    });*/
 

});


$("#anadir").click(function(){//cantidadoriginal, cantidad ingresada,"fila",modal
    var cantidadOr=item.children('td[class="can"]').text()*1;
    if($("#cant").val()*1>0 && $("#cant").val()*1<=cantidadOr)
    {
        
        $("#Add").modal('toggle');
        item.children('td[class="can"]').text((cantidadOr)-($("#cant").val()*1));
        var id=$("#id").val();
        var tabla=$("#articuloren");
        var cant=$("#cant").val()*1;
        if(tabla.children('tr[id="'+ id +'"]').length!=0)
        {
            
            cant+= tabla.children('tr[id="'+ id +'"]').children('td[class="itemaddcant"]').text()*1;
            tabla.children('tr[id="'+ id +'"]').empty();
            tabla.children('tr[id="'+ id +'"]').append("<td>"+item.children('td[class="itemname sorting_1"]').text()+"</td><td class=\"itemaddcant\">"+cant+"</td><td>"+item.children('td[class="cost"]').text()+"</td><td>"+$("#dias").val()+"</td><td> "+(cant*(item.children('td[class="cost"]').text()*1)*$("#dias").val())+"</td><td><button value="+id+" OnClick='Eliminar(this);' class='btn btn-danger'>Eliminar</button></td>");

        }
        else
            tabla.append("<tr id=\""+id+"\"><td>"+item.children('td[class="itemname sorting_1"]').text()+"</td><td class=\"itemaddcant\">"+cant+"</td><td>"+item.children('td[class="cost"]').text()+"</td><td>"+$("#dias").val()+"</td><td> "+(cant*(item.children('td[class="cost"]').text()*1)*$("#dias").val())+"</td><td><button value="+id+" OnClick='Eliminar(this);' class='btn btn-danger'>Eliminar</button></td></tr>");
        
        
        location.href="#TablaA";

        //se envia el id del item para adquirir todos sus atributos
        /*var id=$("#id").val();
        var tabla=$("#articuloren");
        var cant=$("#cant").val();
        var route="http://127.0.0.1:8080/reservacion/"+id+"/edit";
        var token=$("#token").val();
        $.ajax({
            url: route,
            headers:{'X-CSRF-TOKEN': token},
            type: 'GET',
            dataType: 'json',
            success: function(){
                console.log("entro");
                $("#Add").modal('toggle');
                $("#TablaA").show();
                cantidadOr.text((cantidadOr.text()*1)-($("#cant").val()*1));
                location.href="#TablaA";
                agregar();
            }
        });*/
    }
});
function agregar()
{
    $("#articuloren").append("<tr id=\""+"1"+"\"><td>"+$("#Enombre").val()+"</td><td class=\"itemaddcant\">"+$("#Ecantidad").val()+"</td><td>"+$("#Ecost").val()+"</td><td>"+$("#dias").val()+"</td><td> "+($("#Ecantidad").val()*($("#Ecost").val()*1)*$("#dias").val())+"</td><td><button value="+"1"+" OnClick='Eliminar(this);' class='btn btn-danger'>Eliminar</button></td></tr>");
}
$(".reser").click(function(){
    $("#cant").val("");
});

function Eliminar(btn)
{  
        var cantoriginal=$("#tablaarticulos").children('tr[id="'+ btn.value +'"]').children('td[class="can"]');
        var cantagregada=$("#articuloren").children('tr[id="'+ btn.value +'"]').children('td[class="itemaddcant"]').text()*1;
        cantoriginal.text((cantoriginal.text()*1)+(cantagregada));
        $("#articuloren").children('tr[id="'+ btn.value +'"]').remove();
       // document.getElementById("tableid").deleteRow(i);
}
function Enviar()
{
    var f = new Date();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var cantc=1;
    var pago=0;
    var lce=$("#lce").text($("#Cedu").val());
    var lnom=$("#lnom").text($("#Nom").val());
    var ldir=$("#ldir").text($("#Dir").val());
    var lfi=$("#lfi").text($("#datepicker").val());
    var lff=$("#lff").text($("#datepicker2").val());
    var lf=$("#lf").text("Fecha: "+f.getDate() + " de " + (meses[f.getMonth()]) + " de " + f.getFullYear());
    var pos=0;
    var A=new Array();
    $("#artifin").empty();
//TABLA DE ARTICULOS SOLICITADOS
    $("#artifin").append("<tr>");
    $("#articuloren tr td").each(function(){
        /*Si es el boton de eliminar que no lo replique*/
        if($(this).text()!="Eliminar")
        {
            $("#artifin").append("<td>"+ $(this).text()+ "</td>");
            A[pos]=$(this).text();
            pos++;
        }
        cantc++;
        if(cantc>$("#TablaA th").length)
        {
            pago+=parseInt($(this).text());
            $("#artifin").append("</tr><tr>");
            cantc=0;
        }
    });
    A[pos]=pago;
    /*asumiendo que si tiene IVA, cree que sea necesario A[pos+1]? simbolizando el valor del iva*/ 
    A[pos+1]=0;//pago*0.15;
    A[pos+2]=0;//pago+(pago*0.15);
    A[pos+3]="Fecha: "+f.getDate() + " de " + (meses[f.getMonth()]) + " de " + f.getFullYear();
    $("#arre").val(A);
    console.log($("#arre").val());

    $("#artifin").append("</tr>"+
                            /*"<tr><td> </td><td> </td><td><b>Sub Total:</b></td><td>"+pago+"</td></tr>"+
                            "<tr><td> </td><td> </td><td><b>IVA:</b></td><td>"+(pago*0.15)+"</td></tr>"+*/
                            '<tr><td> </td><td> </td><td><b>Gran Total:</b></td><td style="text-align: center">'+pago+'</td></tr>');

    CambioPag();
    
/*$("#tablaB").submit();
console.log(lf);
    $("#F").text(lf);
    $("#NC").text(lnom);
    $("#D").text(ldir);
    $("#FI").text(lfi);
    $("#FF").text(lff);*/
}
function CambioPag()
{
    if($("#parte1").hasClass('active'))
    {
        $("#parte1").removeClass("active");
        $("#parte2").addClass("active");
    }
    else
    {
        $("#parte2").removeClass("active");
        $("#parte1").addClass("active");
    }
}

$("#impri").click(function(){

    var route="https://alquiler.herokuapp.com/pdf";
    
    var token=$("#token").val();

    $.ajax({
        url: route,
        headers:{'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
    });
});
function Imprimir(btn)
{
    $("#ac").val(btn);
    if(btn=="imprimir")
        $('#formulario').attr('target','_BLANK');
    else
        $('#formulario').removeAttr('target');
}
