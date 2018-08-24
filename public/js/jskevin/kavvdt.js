var bootstrapDesing="<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
function createdt(objeto,{buscar="",pagT="full_numbers",col=0,com="asc",sx=true,dom=bootstrapDesing,cant=[-1],cantT=["Todo"],columdef=[],ordering=true,searchC}={})
{
  return objeto.DataTable({
    "destroy": true,
    "pagingType": pagT,//botones primero, anterio,siguiente, ultimo y numeros
    "order": [[col,com]],//ordenara por defecto en la columna Nombre de forma ascendente
    "scrollX": sx,//Scroll horizontal
    "dom": dom,
    "language": {//Cambio de idioma al español
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords": "No se encontro ningun registro",
        "info": "Pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros",
        "infoFiltered": "(Filtrado entre _MAX_ total registro)",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "paginate": {
            "first": "Primera",
            "last": "Ultima",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "aria": {
            "sortAscending":  ": activar para ordenar la columna ascendente",
            "sortDescending": ": activar para odenar la columna descendente"
        },
        //Especificamos como interpretara los puntos decimales y los cientos
        "decimal": ".",
        "thousands": ","
    },
    //Definimos la cantidad de registros que se podran mostrar
    //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
    "lengthMenu": [cant, cantT],
    "columnDefs": columdef,
    "ordering": ordering,
  }).search(buscar).draw();
}
