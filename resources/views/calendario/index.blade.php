@extends('layouts.dashboard')

    {!!Html::style("js/fullcalendar/fullcalendar.min.css")!!}
@section('content')
    {!! $calendar->calendar() !!}
      <!-- Modal -->
      <div class="modal fade" id="infore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Informacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="id">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <!--UNA VEZ TERMINADA LA CLASE DE IS REGRESAR LOS FORMULARIOS A SU TAMAñO GRANDE E IMPORTARLO AQUI-->

                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!!Form::label('Cliente:')!!}
                                    {!!Form::label('Cliente:',null,['id' => 'cliente','class'=>'badge badge-pill badge-info'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!!Form::label('Cedula:')!!}
                                    {!!Form::label('Cedula:',null,['id' => 'cedula','class'=>'badge badge-pill badge-info'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!!Form::label('Direccion:')!!}
                                    {!!Form::label('Direccion:',null,['id' => 'direccion','class'=>'badge badge-pill badge-info'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!!Form::label('Fecha:')!!}
                                    {!!Form::label('Fecha:',null,['id' => 'fecha','class'=>'badge badge-pill badge-info'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h4>Descripcion</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th >Cantidad</th>
                                                <th >Descripcion</th>
                                                <th >P/Unitario</th>
                                                <th >Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbdes">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="editar();">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    {!!Html::script("js/fullcalendar/lib/moment.min.js")!!} 
    {!!Html::script("js/fullcalendar/fullcalendar.min.js")!!} 
    {!! $calendar->script() !!}

    <script>
      var calendar;
      var resinfo=new Object();
      var des = new Object();
      $(document).ready(function(){
        //comentatios
          /* $("#calendario").fullCalendar({
              //weekends: false // will hide Saturdays and Sundays
              dayClick: function() {
                  alert('a day has been clicked!');
              }
          }); */
            //calendar = $('#calendario').fullCalendar('getCalendar');
            //$('#calendario').append(calendar[0]);

            /*         $('#calendar').fullCalendar({
              dayClick: function(date, jsEvent, view) {

                alert('Clicked on: ' + date.format());

                alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

                alert('Current view: ' + view.name);

                // change the day's background color just for fun
                $(this).css('background-color', 'red');

              }
            }); */
            /* 
            $('#calendario').fullCalendar('next'); */
            /* $('#calendario').fullCalendar({
              header: { center: 'month,agendaWeek' }, // buttons for switching between views

              views: {
                  
                month: { // name of view
                  titleFormat: 'YYYY, MM, DD'
                  // other view-specific options here
                }
              }
            }); */
            /* $('#calendar').fullCalendar({
              views: {
                basic: {
                  // options apply to basicWeek and basicDay views
                },
                agenda: {
                  // options apply to agendaWeek and agendaDay views
                },
                week: {
                  // options apply to basicWeek and agendaWeek views
                },
                day: {
                  // options apply to basicDay and agendaDay views
                }
              }
            });*/
            /* $('#calendar').fullCalendar({
              defaultView: 'month',
              validRange: {
                start: '2017-05-01',
              }
            }); */
            /* $('#calendar').fullCalendar({
              defaultView: 'month',
              validRange: function(nowDate) {
                calendar=nowDate;
                return {
                  start: nowDate,
                  end: nowDate.clone().add(1, 'months')
                };
              }
            }); */

            //var view = $('#calendar').fullCalendar('getView');
            //$('#calendar').fullCalendar('changeView', 'agendaDay', '2017-06-01');
            /* $('#calendar').fullCalendar({
              header: {
                center: "month,timelineFourDays",
              },
              views: {
                timelineFourDays: {
                  type: 'timeline',
                  duration: { days: 4 }
                }
              } 
            });*/
        //
        var x;
        x={!!$reservaciones!!};
        for(var i=0; i<x.length; i++)
          resinfo[x[i].ID_Reservacion]=x[i];
        des={!!json_encode($des)!!};
      });
      var even;
      function cargardatos(evento)
      {
        even=evento;
        $("#cliente").text(resinfo[evento].Nombre_Contacto);
        $("#cedula").text(resinfo[evento].Cedula_Cliente);
        $("#direccion").text(resinfo[evento].Direccion_Local);
        $("#fecha").text(resinfo[evento].Fecha_Inicio + " - " + resinfo[evento].Fecha_Fin);
        $("#tbdes").empty();
        var total=0;
        if(des[evento])
        {
            for(i=0; i<des[evento].length; i++)
            {
                $("#tbdes").append(
                    '<tr>'+
                        '<td>'+des[evento][i].Cantidad+'</td>'+
                        '<td >'+des[evento][i].Nombre+'</td>'+
                        '<td>'+des[evento][i].P_Unitario+'</td>'+
                        '<td>'+des[evento][i].Total+'</td>'+
                    '</tr>'
                );
                total+=des[evento][i].Total;
            }
            var iva=resinfo[evento].iva;
            if(iva==0)
            {
                $("#tbdes").append(
                    '<tr><td></td><td></td><td><b>Gran Total<b></td><td>'+total+'</td></tr>'
                );
            }
            else
            {
                $("#tbdes").append(
                    '<tr><td></td><td></td><td><b>Sub Total<b></td><td>'+total+'</td></tr>'+
                    '<tr><td></td><td></td><td><b>IVA<b></td><td>'+(total*iva).toFixed(2)+'</td></tr>'+
                    '<tr><td></td><td></td><td><b>Gran Total<b></td><td>'+((total)+(total*iva)).toFixed(2)+'</td></tr>'
                );
            }
        }

        $("#infore").modal('show');
      } 
      
      function editar()
      {
          location.href="/reserva/"+even+"/edit";
      }
    </script>
@stop