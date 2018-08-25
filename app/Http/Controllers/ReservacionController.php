<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservacion;
use App\Descripcion;
use App\Servicio;
use App\Inventario;
use App\DesRe;
use App\Cliente;
use App\Menu;
use App\invenDes;
use App\menudes;
use App\Http\Requests\AddReserva;
use App\Http\Requests\MenuAdd;
use Redirect;
use PDF;
use DB;

class ReservacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //retornamos todos los servicios, menu y cliente a la vista para agregar una reservacion nueva
    public function index($cedula=null)
    {
        /*Retorna todos los datos de la tabla reservacion e inventario de la BD a index*/
        $servicios=Servicio::all();
        $menu=Menu::all();
        $cliente=null;
        if($cedula!=null)
            $cliente=Cliente::find($cedula);
        return view('Reservacion.index',compact('servicios','cliente','menu'));
    }
    //Guarda la reservacion o genera el pdf de la factura
    public function store(AddReserva $request)
    { 
        if($request['accion'])//Si es guardar
        {
            $Arreglo=$request['lista'];
            //Agregamos a la tabla reservacion
            $reservacion=Reservacion::create([
                'Cedula_Cliente'=>$request['Cedula_Cliente'],    
                'Nombre_Contacto'=> $request['Nombre_Contacto'],
                'Direccion_Local'=>$request['Direccion_Local'],
                'iva'=>$Arreglo[count($Arreglo)-1][1],
                'rowfac'=>$Arreglo[count($Arreglo)-1][3],
                'Fecha_Inicio'=>$request['Fecha_Inicio'],
                'Fecha_Fin'=>$request['Fecha_Fin'],
            ]);
            //Hacemos un recorrido en el arreglo que posee toda la descripcion de la factura para poder agregar cada unda de las descripciones
            for($i=0;$i<(count($Arreglo)-1);$i++)//restamos 1 porque la ultima fila es especial
            {
                $des=Descripcion::create([
                'Cantidad'=> $Arreglo[$i][1],
                'Nombre'=>$Arreglo[$i][0]." - dias(".$Arreglo[$i][3].")",
                'P_Unitario'=>$Arreglo[$i][2],
                'Total'=>$Arreglo[$i][4],
                ]);
                DesRe::create([
                    'idReservacion'=>$reservacion["ID_Reservacion"],
                    'idDescripcion'=>$des['IdDescripcion'],
                ]);
                if(substr($Arreglo[$i][5], -4)=="Arti")
                {
                    invenDes::create([
                        'ID_Objeto' => substr($Arreglo[$i][5],0,-4),
                        'ID_Descripcion' => $des['IdDescripcion']
                    ]); 
                }
                else
                {
                    menudes::create([
                        'id_menu' => substr($Arreglo[$i][5],0,-4),
                        'id_descripcion' => $des['IdDescripcion']
                    ]); 
                }
                //Else y se almancena en la tabla puente entre descripcion y menu
            }
            return 1;
        }
        else
        {
            $x=explode(",", $request["lista"]);//Guardamos como arreglo unidimencional
            $i=0;
            $Arreglo=[];
            $fila=[];
            $CC=$request['Cedula_Cliente'];
            $NC= $request['Nombre_Contacto'];
            $DL=$request['Direccion_Local'];
            $FI=$request['Fecha_Inicio'];
            $FF=$request['Fecha_Fin'];
            $facactual=$request['facactual'];
            foreach($x as $elemento)//Recorremos el arreglo
            {
                if($i==6)//hacemos la agregacion de fila cada 6 elementos
                {
                    array_push($Arreglo,$fila);
                    $fila=[];//inicializamos
                    $i=0;
                }
                if($i!=5)//No almacenamos el id
                    array_push($fila,$elemento);//Arreglo de cada fila
                $i++;
            }
            array_push($Arreglo,$fila);//agregamos la ultima fila que posee 3 elementos
            $pdf=PDF::loadView('Reservacion.fac', compact('CC', 'NC', 'DL','FI', 'FF','Arreglo','facactual'));//cargamos la vista
            $now = new \DateTime();
            return $pdf->stream('factura'.$now->format('Y-m-d_H_i_s').'.pdf');//definimos el nombre por defecto del archivo
        }

    }
    //Guardamos la nueva comida 
    public function menu(MenuAdd $request)
    {    
        if($request->hasFile('path'))
        {
            $now= new \DateTime();//Capturamos el tiempo actual
            //La variable name definira el nombre del archivo almacenado
            $name=$now->format('d-m-Y_H_i_s_').$request->file('path')->getClientOriginalName();
            $s3=\Storage::disk('s3');//Hacemos referencia al disco en la nube
            $s3->put('Menu/'.$name,\File::get($request->file('path')),'public');
            //\Storage::disk('local')->put($name, \File::get($request->file('path')));
            $nuevo = Menu::Create([
                'descripcion'=>$request->get('descripcion'),
                'costo'=>$request->get('costo'),
                'path'=>$name
            ]);
        }
        else
            $nuevo = Menu::Create($request->all());
        if(!$nuevo["path"])
            $nuevo["path"]="vacio.jpg";
         return response()->json($nuevo); 
    }
    //Recarga los articulos del inventario con la cantidad maxima rentada de cada uno
    public function recargaarticulos($FI,$FF)
    {
        $inventario=Inventario::where('Costo_Alquiler','>',0)->get();

        //Devuelve lista de la cantidad de articulos reservados y el id del articulo en un rango de fecha
        $inveres=DB::Table('reservacion as re')
           ->join('desres as dr','dr.idReservacion','=','re.ID_Reservacion')
           ->join('descripcion as de','de.IdDescripcion','=','dr.idDescripcion')
           ->join('inven_descri as ind','ind.ID_Descripcion','=','de.idDescripcion')
           ->join('inventario as in','in.ID_Objeto','=','ind.ID_Objeto')
           ->Select('in.ID_Objeto','de.Cantidad')
           ->whereBetween('Fecha_Inicio', [$FI, $FF])//ingresar las fechas inicio y fin
           ->where('re.deleted_at','=',null)->get();
        $ir=[];
       //convertimos la lista "inveres" en un arreglo y con la cantidad total a restar a cada articulo
        foreach($inveres as $inR)
        {
            if(array_key_exists($inR->ID_Objeto, $ir))
                $ir[$inR->ID_Objeto]+=$inR->Cantidad;
            else
                $ir[$inR->ID_Objeto]=$inR->Cantidad;
        }
        return view('reservacion.tablas.articulos',compact('inventario','ir'));
    }
}
