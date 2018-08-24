<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservacion;
use Calendar;
use DB;
class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
        $reservaciones=Reservacion::select('ID_Reservacion','Cedula_Cliente','Nombre_Contacto','Direccion_Local','Fecha_Inicio','Fecha_Fin','iva')->get();
        $events = [];
        foreach($reservaciones as $re)
        {
            $events[] = Calendar::event(
                $re->Nombre_Contacto, //event title
                true, //full day event?
                new \DateTime($re->Fecha_Inicio), //start time (you can also use Carbon instead of DateTime)
                new \DateTime($re->Fecha_Fin), //end time (you can also use Carbon instead of DateTime)
                $re->ID_Reservacion
            );
        } 

        $calendar = Calendar::addEvents($events,['color'=>'#FFC300']) //add an array with addEvents
            ->setOptions([ //set fullcalendar options
                'firstDay' => 1,
                'selectable' => true
                //'selectHelper' => true,
                //'eventLimit' => true
            ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                'eventClick' => 'function(event, jsEvent, view) {
                    cargardatos(event.id);
                    $("#infore").modal("show");
                }'
            ]);

        $descripcion=DB::Table('reservacion as re')
            ->join('desres as dr','dr.idReservacion','=','re.ID_Reservacion')
            ->join('descripcion as de','de.IdDescripcion','=','dr.idDescripcion')
            ->Select('re.ID_Reservacion','de.Nombre','de.Cantidad','de.P_Unitario','de.Total')
            ->where('re.deleted_at','=',null)
            ->where('de.deleted_at','=',null)->get();
        $des=[];
        foreach($descripcion as $d)
        {
            if(array_key_exists($d->ID_Reservacion, $des))
                array_push($des[$d->ID_Reservacion],$d);
            else
                $des[$d->ID_Reservacion]=[$d];
        };
        return view('calendario.index', compact('calendar','reservaciones','des'));
    }
}
