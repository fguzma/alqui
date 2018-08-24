var Farticulo;
var A;
var facturas;
function mostrar(btn)
{
    Farticulo=btn.parentNode.parentNode;//Guardamos la fila seleccionada "<tr>"
    $("#cant").val("");
    $("#precio").val(Tarti.row(Farticulo).data()[2]);//Escribimos el valor por defecto
}

$('#Add').on('shown.bs.modal', function (e) {
    $("#cant").select();
});
function AddToListArticulo()
{
    var articulo = Tarti.row(Farticulo).data();//Guardamos los datos de  la fila
    var cantidadOr=articulo[1];//Cantidad original
    var cantAdd=$("#cant").val()*1;//Cantidad a agregar
    if(cantAdd>0 && cantAdd<=cantidadOr && $("#manual").prop('checked')==false)//validamos el no agregar mas que la existencia
    {
        $("#Add").modal('toggle');//ocultamos el modal
        //Actualizamos la cantidad total del articulo
        Tarti.cell(Farticulo.children[1]).data((cantidadOr)-(cantAdd));
        var id=Farticulo.children[3].children[0].value;
        AddToList({Tabla:TA,articulo:articulo,cantAdd:cantAdd,id:id});
        location.href="#TablaA";
    }
    else
    {
        console.log(cantAdd);
        if(cantAdd=="" && $("#manual").prop('checked')==false)
            message(["No ha ingresado la cantidad"],{objeto:$("#mensajearticulo"),tipo:"danger",manual:true}); 
        else
        {
            if($("#precio").val() == "")
                message(["No ha ingresado el precio"],{objeto:$("#mensajearticulo"),tipo:"danger",manual:true}); 
            else
            {
                if(cantAdd>cantidadOr && $("#manual").prop('checked')==false)
                    message(["Sobre pasa la cantidad existente"],{objeto:$("#mensajearticulo"),tipo:"danger",manual:true});
                else
                {
                    $("#Add").modal('toggle');//ocultamos el modal
                    //Actualizamos la cantidad total del articulo
                    Tarti.cell(Farticulo.children[1]).data((cantidadOr)-(cantAdd));
                    var id=Farticulo.children[3].children[0].value;
                    articulo[2]=$("#precio").val();
                    AddToList({Tabla:TA,articulo:articulo,cantAdd:cantAdd,id:id});
                    location.href="#TablaA";
                }
            }
        }
    }
}

function AddToList({Tabla=null,articulo=null,cantAdd=null,indexname=0,tipo='Arti',id=""}={})
{
    //verificamos si ya fue agregado el articulo
    if(TA.cell('td[id='+articulo["DT_RowId"]+']').length>0)
    {
        //sumamos la cantidad agregada anteriormente con la actual
        var cantidad= TA.cell('td[id='+articulo["DT_RowId"]+']').data()*1 + cantAdd;//SOLO cantAdd si no quisiera sumar lo previo agregado
        var indexrow=TA.cell('td[id='+articulo["DT_RowId"]+']').index().row;
        var costo=articulo[2];//TA.cell(indexrow,2).data();
        TA.cell(indexrow,1).data(cantidad);//Agregamos la nueva cantidad
        TA.cell(indexrow,2).data(costo);//Agregamos el precio
        TA.cell(indexrow,4).data(costo*diff*cantidad);
    }
    else
    {
        //Agregar la fila
        var newrow = TA.row.add(
        [
            articulo[indexname],
            cantAdd,
            articulo[2],
            $("#dias").val(),
            cantAdd*($("#dias").val()*1)*articulo[2],
            '<button onclick="EraseRow({boton: this,pos:\''+articulo["DT_RowId"]+'\',tipo:\''+tipo+'\'});" value="'+id+tipo+'"class="btn btn-danger">Eliminar</button>'
        ]).draw().node();
        newrow.children[1].id=articulo["DT_RowId"];//Agregamos la clase para la columna de cantidad
        newrow.children[3].className="day";
    }
}

function EraseRow({boton=null,pos=null,tipo=""}={})
{
    deletedrow=TA.row(boton.parentNode.parentNode);
    if(tipo!="Menu")
    {
        valororiginal=Tarti.cell('td[id=c_'+pos+']').data()*1 + deletedrow.data()[1]*1;
        Tarti.cell('td[id=c_'+pos+']').data(valororiginal);
    }
    deletedrow.remove().draw( false ); 
}

function AddToListMenu(boton)
{
    console.log(boton.value);
    if($("#c_menucant"+boton.value).val()*1)
    {
        var articulo = table.row(boton.parentNode.parentNode).data();//Guardamos los datos de  la fila
        var cantAdd=$("#c_menucant"+boton.value).val()*1;//Cantidad a agregar
        AddToList({Tabla:table,articulo:articulo,cantAdd:cantAdd,indexname:1,tipo:"Menu",id:boton.value});
        $("#c_menucant"+boton.value).val("");
        message(["Se agrego a la lista"],{objeto:$("#mensajemenu"), manual:true});
        location.href="#mensajemenu";
    }
}

function Eliminar(btn, menu=false)
{  
        if(menu!=false)
        {
            var cantoriginal=$("#tablaarticulos").children('tr[id="'+ btn.value +'"]').children('td[class="can"]');
            var cantagregada=$("#articuloren").children('tr[id="'+ btn.value +'"]').children('td[class="itemaddcant"]').text()*1;
            cantoriginal.text((cantoriginal.text()*1)+(cantagregada));
            $("#articuloren").children('tr[id="'+ btn.value +'"]').remove();
        }
        else
            $("#articuloren").children('tr[id="'+ btn.value +'"]').remove();
       // document.getElementById("tableid").deleteRow(i);
}
function Enviar()
{
    var f = new Date();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
    $("#lce").text($("#Cedu").val());
    $("#lnom").text($("#Nom").val());
    $("#ldir").text($("#Dir").val());
    $("#lfi").text($("#datepicker").val());
    $("#lff").text($("#datepicker2").val());
    var lf=$("#lf").text("Fecha: "+f.getDate() + " de " + (meses[f.getMonth()]) + " de " + f.getFullYear());

    if($("#filafactura").val()=="")
        $("#filafactura").val(TA.data().length);
    if($("#filafactura").val()!=0)
    {
        tablafactura();
        A[A.length-1][2]=lf.text();
    }
    CambioPag();
}


function tablafactura()
{
    $("#artifin").empty();
    filafac=$("#filafactura").val()*1;
    if(filafac>0)
    {
        A= [[]];
        aux=filafac;
        cantfac=0;
        var i=0;
        facturas=[[""]];
        html="";
        var pago=0;
        for(i=0; i<TA.data().length; i++)//se repetira hasta la cantidad maxima de filas en las facturas
        {
            if(i==filafac)
            {
                facturas.push(['']);
                filafac+=aux;
            }
            A[i].push(
                TA.row(i).data()[0],
                TA.row(i).data()[1],
                TA.row(i).data()[2],
                TA.row(i).data()[3],
                TA.row(i).data()[4],
                TA.row(i).node().children[5].children[0].value
            );
            html+=
                '<tr>'+
                    '<td>'+(A[i][0])+'</td>'+
                    '<td>'+(A[i][1])+'</td>'+
                    '<td>'+(A[i][2])+'</td>'+
                    '<td>'+(A[i][3])+'</td>'+
                    '<td>'+(A[i][4])+'</td>'+
                '</tr>';
            pago+=parseInt(TA.row(i).data()[4]);
            A.push([]);
            if(i==filafac-1)//Si es la ultima linea definida por factura
            {
                facturas[cantfac][0]=html;
                facturas[cantfac].push(pago);
                cantfac++;
                pago=0;
                html="";
            }  
        }
        if(i<filafac)
        {
            for(;i<filafac; i++)
                html+='<tr><td></td><td></td><td></td><td></td><td></td></tr>';
                
            facturas[cantfac][0]=html;
            facturas[cantfac].push(pago);
        }
        $("#artifin").append(facturas[0][0]);
        A[A.length-1].push(pago,0,$("#lf").text(),aux);
        facactual=0;
        $("#numfac").text("Factura #1");
        $("#numfac").text("Factura #1");
        $("#facactual").val(0);
        eliminardetalles();
    }
    
}

//Elimina las filas subtota, iva y total segun convenga
function eliminardetalles(pos=0)
{
    var x = $("#artifin");
    var pago=0;
    
    if($("#iva").prop('checked')==false)//si no esta aprovado el uso de iva
    {
        x.children('tr[id]').remove();//removemos todas las filas con id (son maximo 3 de esa tabla)
        pago=facturas[pos][1];//A[A.length-1][0];//almacenamos el valor del pago total
        ultimodetalle(pago,0);//funcion que agregar a la tabla el subtotal, iva y total segun convenga (pago,iva,valoriva)
    }
    else
    {
        valor=($("#valoriva").val()*1)/100;//obtenemos el valor del iva a aplicar 
        if(valor!=0)//si el valor ingresado es 0 o no se ingreso un valor no ocurrira nada
        {
            x.children('tr[id]').remove();
            pago=facturas[pos][1];//A[A.length-1][0];
            ultimodetalle(pago,valor);
        }
    }
}
//IMPLEMENTAR EL IVA
function ultimodetalle(pago,iva)
{
    if(iva==0)
    {
        $("#artifin").append("</tr >"+
            '<tr id="tftotal"><td> </td><td> </td><td></td><td><b>Gran Total:</b></td><td>'+pago+'</td></tr>');
        A[A.length-1][1]=0;
    }
    else
    {
        $("#artifin").append("</tr >"+
            '<tr id="tfsubtotal"> <td></td> <td></td> <td></td> <td> <b>Sub Total:</b></td><td>'+pago+'</td> </tr>'+
            '<tr id="tfiva"> <td></td> <td></td> <td> </td><td><b>IVA:</b></td><td>'+(pago*iva).toFixed(2)+'</td> </tr>'+
            '<tr id="tftotal"> <td></td> <td></td> <td> </td><td><b>Gran Total:</b></td><td>'+(pago+(pago*iva)).toFixed(2)+'</td> </tr>');
        
        A[A.length-1][1]=iva;
    }
    $("#arre").val(A);
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

facactual=0;
function cambiofac(valor)
{
    temp=facactual+valor*1;
    if(temp>=0 && temp<facturas.length)
    {
        facactual=temp;
        tf=$("#artifin");
        tf.empty();
        tf.append(facturas[facactual][0]);
        eliminardetalles(facactual);
        $("#numfac").text("Factura #"+(facactual+1));
        $("#facactual").val(facactual);
    }
}