<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reservacion;
use App\Descripcion;
use App\Servicio;
use App\Inventario;
use App\Menu;
use App\DesRe;
use App\invenDes;
use App\menudes;
use App\Http\Requests\AddReserva;
use DB;
class ReservasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $reservas=Reservacion::all();
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
        return view('reservacion.ver',compact('reservas','des'));
    }
    public function edit($id)
    {
        $servicios=Servicio::all();
        $menu=Menu::all();
        $cliente=null;
        $reservacion=Reservacion::find($id);
        $inventario=Inventario::where('Costo_Alquiler','>',0)->get();
        $desmenu=DB::Table('reservacion as re')
            ->join('desres as dr','dr.idReservacion','=','re.ID_Reservacion')
            ->join('descripcion as de','de.IdDescripcion','=','dr.idDescripcion')
            ->join('menudes as md','md.id_descripcion','=','de.IdDescripcion')
            ->join('menu as me','me.id','=','md.id_menu')
            ->Select('me.id','de.Cantidad','me.descripcion','de.P_Unitario','de.Total')
            ->where('re.ID_Reservacion','=',$id)
            ->where('re.deleted_at','=',null)
            ->where('de.deleted_at','=',null)->get();
        //Devuelve lista de la cantidad de articulos reservados y el id del articulo en un rango de fecha
        $inveres=DB::Table('reservacion as re')
            ->join('desres as dr','dr.idReservacion','=','re.ID_Reservacion')
            ->join('descripcion as de','de.IdDescripcion','=','dr.idDescripcion')
            ->join('inven_descri as ind','ind.ID_Descripcion','=','de.idDescripcion')
            ->join('inventario as in','in.ID_Objeto','=','ind.ID_Objeto')
            ->Select('re.ID_Reservacion','in.ID_Objeto','de.Cantidad','de.Nombre','de.P_Unitario','de.Total')
            ->whereBetween('Fecha_Inicio', [$reservacion->Fecha_Inicio, $reservacion->Fecha_Fin])//ingresar las fechas inicio y fin
            ->where('re.deleted_at','=',null)
            ->where('de.deleted_at','=',null)->get();
        $ir=[];
        $descripcion=[];
        //convertimos la lista "inveres" en un arreglo y con la cantidad total a restar a cada articulo
        foreach($inveres as $inR)
        {
            if(array_key_exists($inR->ID_Objeto, $ir))
                $ir[$inR->ID_Objeto]+=$inR->Cantidad;
            else
                $ir[$inR->ID_Objeto]=$inR->Cantidad;
            if($inR->ID_Reservacion==$id)
            {
                array_push($descripcion,$inR);
            }
        }
        $articulo = view('reservacion.tablas.articulos',compact('inventario','ir'));
        return view('reservacion.edit',compact('reservacion','servicios','menu','articulo','descripcion','desmenu'));
    }
    public function update(AddReserva $request,$id)
    {
        //actualizar datos de la reservacion
        $Arreglo=$request['lista'];
        $reservacion=Reservacion::find($id);
        $reservacion['Cedula_Cliente']=$request['Cedula_Cliente'];
        $reservacion['Nombre_Contacto']=$request['Nombre_Contacto'];
        $reservacion['Fecha_Inicio']=$request['Fecha_Inicio'];
        $reservacion['Fecha_Fin']=$request['Fecha_Fin'];
        $reservacion['Direccion_Local']=$request['Direccion_Local'];
        $reservacion['iva']=$Arreglo[count($Arreglo)-1][1];
        $reservacion['rowfac']=$Arreglo[count($Arreglo)-1][3];

        $now = new \DateTime();
        //Obtenemos todas las descripciones de la reservacion
        $desmenu=Descripcion::
              join('desres as dr','descripcion.IdDescripcion','=','dr.idDescripcion')
            ->join('menudes as md','md.id_descripcion','=','descripcion.IdDescripcion')
            ->where('dr.idReservacion','=',$id)
            ->where('md.deleted_at','=',null)
            ->select('descripcion.*','md.id_menu')
            ->get();
        $desarti=Descripcion::
              join('desres as dr','descripcion.IdDescripcion','=','dr.idDescripcion')
            ->join('inven_descri as ind','ind.id_descripcion','=','descripcion.IdDescripcion')
            ->where('dr.idReservacion','=',$id)
            ->where('ind.deleted_at','=',null)
            ->select('descripcion.*','ind.ID_Objeto')
            ->get();
            
        $listamenu=[];
        $listaarti=[];
        foreach($desmenu as $dm)
        {
           $listamenu[$dm->id_menu]=$dm;
           $listamenu[$dm->id_menu]->created_at=$now->format('Y-m-d H:i:s');
           $listamenu[$dm->id_menu]->deleted_at=$now->format('Y-m-d H:i:s');
           $listamenu[$dm->id_menu]->save();
           unset($listamenu[$dm->id_menu]['id_menu']);
        }
        foreach($desarti as $da)
        {
           $listaarti[$da->ID_Objeto]=$da;
           $listaarti[$da->ID_Objeto]->created_at=$now->format('Y-m-d H:i:s');
           $listaarti[$da->ID_Objeto]->deleted_at=$now->format('Y-m-d H:i:s');
           $listaarti[$da->ID_Objeto]->save();
           unset($listaarti[$da->ID_Objeto]['ID_Objeto']);
        }


        //HACER RECORRIDO EN LAS DESCRIPCIONES A ACUALIZAR O EN LAS DESCRIPCIONES NUEVAS Y DEJAR COMO ELIMINADAS LAS INEXISTENTE
        //Podria obtener todos los datos y luego recorrerlos con un ciclo considero que es menos tiempo que dos veces la misma consulta
        //select a todos los elementos de la tabla descripcion asi podriamos actualizarlo directamente
        
        //Hacemos un recorrido en el arreglo que posee toda la descripcion de la factura para poder agregar cada unda de las descripciones
        for($i=0;$i<(count($Arreglo)-1);$i++)//restamos 1 porque hay 1 fila de mas
        {
            $pk=substr($Arreglo[$i][5],0,-4);
            if(substr($Arreglo[$i][5], -4)=="Arti")
            {
                if(array_key_exists($pk, $listaarti))
                {
                    $listaarti[$pk]->Cantidad=$Arreglo[$i][1];
                    $listaarti[$pk]->Nombre=$Arreglo[$i][0]." - dias(".$Arreglo[$i][3].")";
                    $listaarti[$pk]->P_Unitario=$Arreglo[$i][2];
                    $listaarti[$pk]->Total=$Arreglo[$i][4];
                    $listaarti[$pk]->deleted_at=null;
                    $listaarti[$pk]->save();
                }
                else
                {
                    $des=Descripcion::create([
                        'Cantidad'=> $Arreglo[$i][1],
                        'Nombre'=>$Arreglo[$i][0]." - dias(".$Arreglo[$i][3].")",
                        'P_Unitario'=>$Arreglo[$i][2],
                        'Total'=>$Arreglo[$i][4],
                    ]);
                    DesRe::create([
                        'idReservacion'=>$id,
                        'idDescripcion'=>$des['IdDescripcion'],
                    ]);
                    invenDes::create([
                        'ID_Objeto' => substr($Arreglo[$i][5],0,-4),
                        'ID_Descripcion' => $des['IdDescripcion']
                    ]); 
                }
            }
            else
            {
                if(array_key_exists($pk, $listamenu))
                {
                    $listamenu[$pk]->Cantidad=$Arreglo[$i][1];
                    $listamenu[$pk]->Nombre=$Arreglo[$i][0]." - dias(".$Arreglo[$i][3].")";
                    $listamenu[$pk]->P_Unitario=$Arreglo[$i][2];
                    $listamenu[$pk]->Total=$Arreglo[$i][4];
                    $listamenu[$pk]->deleted_at=null;
                    $listamenu[$pk]->save();
                }
                else
                {
                    $des=Descripcion::create([
                        'Cantidad'=> $Arreglo[$i][1],
                        'Nombre'=>$Arreglo[$i][0]." - dias(".$Arreglo[$i][3].")",
                        'P_Unitario'=>$Arreglo[$i][2],
                        'Total'=>$Arreglo[$i][4],
                    ]);
                    DesRe::create([
                        'idReservacion'=>$id,
                        'idDescripcion'=>$des['IdDescripcion'],
                    ]);
                    menudes::create([
                        'id_menu' => substr($Arreglo[$i][5],0,-4),
                        'id_descripcion' => $des['IdDescripcion']
                    ]); 
                }
            }
        }
        $reservacion->save();
        return 1;
 
    }
    public function lista($tipof=null,$valor=null)
    {
        if($tipof=="CC" && $valor!="no")
        {
            $reservas=Reservacion::where('Cedula_Cliente','like',$valor.'%')->get();
            return view('reservacion.recargable.listareservas',compact('reservas'));
        }
        if($tipof=="NC" && $valor!="no")
        {
            $reservas=Reservacion::where('Nombre_Contacto','like',$valor.'%')->get();
            return view('reservacion.recargable.listareservas',compact('reservas'));
        }
        if($tipof=="fechafac" && $valor!="no")
        {
            $reservas=Reservacion::whereBetween('created_at',['2017-10-21','2017-12-21'])->get();
            return view('reservacion.recargable.listareservas',compact('reservas'));
        }
        $reservas=Reservacion::all();
        return view('reservacion.recargable.listareservas',compact('reservas'));
    }
}
