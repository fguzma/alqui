<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ServicioAdd;
use App\Http\Requests\PersonalUpdate;
use App\Servicio;
use Redirect;
use Session;
use DB;

class ServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($msj=null,$nombre="")
    { 
        $servicios=servicio::all();
        if($msj=="2")
        {
            session::flash('message','Servicio editado exitosamente');
            session::flash('tipo','info');
        }
        if($msj=="1")
        {
            session::flash('message','Servicio agregado exitosamente');
            session::flash('tipo','info');
        }
        Session::flash('valor',$nombre);
        return view('servicio.index',compact('servicios'));
    }
    public function store(ServicioAdd $request)
    { 
        Servicio::create([    
            'Nombre'=> $request['Nombre'],
        ]);

        return 1;
    }

    public function destroy($id)
    {
        $servicio=Servicio::find($id);
        $servicio->delete();
        return 1;
    }
    public function edit($id)
    {
         $servicio=Servicio::find($id);//DB::table('cliente')->where('Cedula_Cliente','=',$Cedula_Cliente)->get()
         //dd($cliente->get(0));
         //dd($cliente);
         //return $cliente->Nombre;
         return view('servicio.edit',['servicio'=>$servicio]);
       // return Redirect::to('/editar');
    }
    public function update($id,Request $request)
    {
        $servicio=Servicio::find($id);
        if($servicio['Nombre']!=$request['Nombre'])
        {
            $consulta=servicio::where('Nombre','=',$request['Nombre'])->get();
            if(count($consulta)==0)
            {
                $servicio->fill($request->all());
                $servicio->save();
            }
            else
            {
                return 0;
            }
        }
        return 1;
    }
    public function create()
    {
        return view('servicio.create',['message'=>""]);
    }
    public function lista($value=null)
    {
        $servicios=servicio::where('ID_Servicio','like','ID'.$value.'%')->paginate(10);
        return view('servicio.recargable.listaservicios',compact('servicios'));
    }
}
