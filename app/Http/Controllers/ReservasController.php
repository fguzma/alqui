<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\reservacion;
use App\descripcion;
use App\servicio;
use App\inventario;

class ReservasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $reservas=reservacion::paginate(10);
        return view('reservacion.ver',compact('reservas'));
    }
    public function edit($id)
    {
        $reservas=reservacion::find($id);
        $des = \DB::table('descripcion')
            ->select('descripcion.IdDescripcion','Nombre','Cantidad','P_Unitario','Total')
            ->join('desres', 'descripcion.IdDescripcion', '=', 'desres.idDescripcion')
            ->where('desres.idReservacion','=', $id)
            ->get();
        $servicios=servicio::all();
        $inventario=Inventario::all();
        return view('reservacion.edit',['reservas'=>$reservas,'des'=>$des,'servicios'=>$servicios,'inventario'=>$inventario]);
    }
    public function update($id)
    {
        $Arreglo=[""];
        $cadena=$request['puto'];
        $pos=0;

        for ($i=0; $i <strlen($cadena); $i++) {
            if(strcmp($cadena[$i],',')===0)
            {
                $pos++;
                array_push($Arreglo,"");
            }
            else
            {
                $Arreglo[$pos]=$Arreglo[$pos].$cadena[$i];
            }
        }
        if(strcmp($request['accion'],"guarda")==0)
        {
            //Agregamos a la tabla reservacion
            $reserva=reservacion::find($id);
            $reserva->fill($request->all());
            $reserva->save();

            $reservacion=reservacion::all();
            $reservacion=$reservacion->last();
            $pos=0;
            //Hacemos un recorrido en el arreglo que posee toda la descripcion de la factura para poder agregar cada unda de las descripciones
            /*for($i=0;$i<(count($Arreglo)-4)/4;$i++)//restamos 4 porque hay 4 elementos de mas y dividimos entre la cantidad de columnas para q nos de la cantidad de fila
            {
                descripcion::create([
                'Cantidad'=> $Arreglo[$pos+1],
                'Nombre'=>$Arreglo[$pos],
                'P_Unitario'=>$Arreglo[$pos+2],
                'Total'=>$Arreglo[$pos+3],
                ]);

                $des=descripcion::all();
                $des=$des->last();
                $pos+=4;
                desre::create([
                    'idReservacion'=>$reservacion["ID_Reservacion"],
                    'idDescripcion'=>$des['IdDescripcion'],
                ]);
            }*/
            return redirect('/reservacion')->with('message',"Se agrego al trabajador correctamente");//view('personal.create',['message'=>"Se agrego al usuario exitosamente"]);
        }
        else
        {/*
            return $Arreglo;
            $CC=$request['Cedula_Cliente'];
            $NC=$request['Nombre_Contacto'];
            $DL=($request['Direccion_Local']);
            $FI=$request['Fecha_Inicio'];
            $FF=$request['Fecha_Fin'];
            */
            /* return  $request['artifin'];
                $view =  \View::make('reservacion.pdf', compact('CC', 'NC', 'DL','FI', 'FF'))->render();*/
            //$pdf = \App::make('dompdf.wrapper');
            // $pdf->loadHTML($view);
            $pdf=PDF::loadView('reservacion.fac', compact('CC', 'NC', 'DL','FI', 'FF','Arreglo'));
            return $pdf->stream('invoice.pdf');
        }
        $usuario=personal::find($cedula);
        $usuario->fill($request->all());
        $usuario->save();
        return redirect('/personal')->with('message',"Se edito al trabajador exitosamente");//view('personal.create',['message'=>"Se agrego al usuario exitosamente"]);
    }
    public function lista($tipof=null,$valor=null)
    {
        if($tipof=="CC" && $valor!="no")
        {
            $reservas=reservacion::where('Cedula_Cliente','like',$valor.'%')->get();
            return view('reservacion.recargable.listareservas',compact('reservas'));
        }
        if($tipof=="NC" && $valor!="no")
        {
            $reservas=reservacion::where('Nombre_Contacto','like',$valor.'%')->get();
            return view('reservacion.recargable.listareservas',compact('reservas'));
        }
        if($tipof=="fechafac" && $valor!="no")
        {
            $reservas=reservacion::whereBetween('created_at',['2017-10-21','2017-12-21'])->get();
            return view('reservacion.recargable.listareservas',compact('reservas'));
        }
        $reservas=reservacion::all();
        return view('reservacion.recargable.listareservas',compact('reservas'));
    }
}
