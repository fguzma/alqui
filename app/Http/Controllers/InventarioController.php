<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticuloAdd;
use App\Http\Requests\ArticuloUpdate;
use App\Inventario;
use App\Servicio;
use Session;
use DB;
class InventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($msj=null,$filtro=null,$nombre="")
    { 
        
        $inventario=DB::table('inventario')
        ->join('servicio','servicio.ID_Servicio','=','inventario.ID_Servicio')
        ->select('inventario.ID_Objeto','inventario.Nombre','inventario.Cantidad','inventario.Estado','inventario.Costo_Alquiler','inventario.Costo_Objeto','servicio.Nombre as servicio')
        ->where('inventario.deleted_at','=',null)
        ->get();
        if($msj=="1")
        {
            session::flash('message','Articulo agregado exitosamente');
            session::flash('tipo','info');
        }
        Session::flash('valor',$nombre);
        $servicios=Servicio::all();
        return view('inventario.index',compact('inventario','servicios'));
    }
    public function create()
    {
        $servicios=Servicio::all();
        return view('inventario.create',['message'=>"",'servicios'=>$servicios]);
    }
    public function store(ArticuloAdd $request)
    { 
        Inventario::create([
            'ID_Servicio'=>$request['ID_Servicio'],    
            'Nombre'=> $request['Nombre'],    
            'Estado'=> "Bueno",
            'Cantidad'=>$request['Cantidad'],
            'Costo_Alquiler'=>($request['Costo_Alquiler']),
            'Costo_Objeto'=> $request['Costo_Objeto'],
        ]);

        return response()->json(
                ['exito' => 'bien']
            );
    }

    public function destroy($id)
    {
        $articulo=Inventario::find($id);
        $articulo->delete();
        return 1;
    }

    public function update($id,ArticuloUpdate $request)
    {
        $articulo=Inventario::find($id);
        if($articulo['Nombre']==$request['Nombre'])
        {
            $articulo->fill($request->all());
            $articulo->save();
        }
        else
        {
            $consulta=Inventario::where('nombre','=',$request['Nombre'])->get();
            if(count($consulta)==0)
            {
                $articulo->fill($request->all());
                $articulo->save();
            }
            else
                return 0;
        }
        return 1;
    }

}