<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ArticuloAdd;
use App\Http\Requests\ArticuloUpdate;
use App\Inventario;
use App\Servicio;
use Redirect;
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
        ->select('inventario.ID_Objeto','inventario.Nombre','inventario.Cantidad','inventario.Estado','inventario.Costo_Alquiler','inventario.Costo_Objeto','inventario.Disponibilidad','servicio.Nombre as servicio')
        ->where('inventario.deleted_at','=',null)
        ->get();
        if($msj=="1")
        {
            session::flash('message','Articulo agregado exitosamente');
            session::flash('tipo','info');
        }
        Session::flash('valor',$nombre);
        $servicios=servicio::all();
        return view('inventario.index',compact('inventario','servicios'));
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
            'Disponibilidad'=> $request['options'],
        ]);

        $servicios=Servicio::all();
        Session::flash('message','Articulo Agregado correctamente');
        Session::flash('tipo','info');
        return response()->json(
                ['exito' => 'bien']
            );
        //return view('inventario.create',['message'=>"Se agrego al usuario exitosamente",'servicios'=>$servicios]);
    }

    public function destroy($id)
    {
        $articulo=Inventario::find($id);
        $articulo->delete();
        return 1;
    }
    public function edit($id)
    {
         $articulo=Inventario::find($id);//DB::table('cliente')->where('Cedula_Cliente','=',$Cedula_Cliente)->get()
         //dd($cliente->get(0));
         //dd($cliente);
         //return $cliente->Nombre;
         $servicios=Servicio::all();
         return view('inventario.edit',['articulo'=>$articulo,'servicios'=>$servicios]);
       // return Redirect::to('/editar');
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
            $consulta=inventario::where('nombre','=',$request['Nombre'])->get();
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
    public function create()
    {
        $servicios=Servicio::all();
        return view('inventario.create',['message'=>"",'servicios'=>$servicios]);
    }
    public function lista($idservicio=null,$nombreArt=null)
    {
        if($idservicio!="0" && $nombreArt=="0")
        {
            $inventario=DB::table('inventario')
            ->join('servicio','servicio.ID_Servicio','=','inventario.ID_Servicio')
            ->select('inventario.ID_Objeto','inventario.Nombre','inventario.Cantidad','inventario.Estado','inventario.Costo_Alquiler','inventario.Costo_Objeto','inventario.Disponibilidad','servicio.Nombre as servicio')
            ->where('inventario.ID_Servicio','=',$idservicio)->get();
        }
        if($idservicio=="0" && $nombreArt!="0")
        {
            $inventario=DB::table('inventario')
            ->join('servicio','servicio.ID_Servicio','=','inventario.ID_Servicio')
            ->select('inventario.ID_Objeto','inventario.Nombre','inventario.Cantidad','inventario.Estado','inventario.Costo_Alquiler','inventario.Costo_Objeto','inventario.Disponibilidad','servicio.Nombre as servicio')
            ->where('inventario.Nombre','like',$nombreArt.'%')->get();
        }
        if($idservicio!="0" && $nombreArt!="0")
        {   
           $inventario=DB::table('inventario')
            ->join('servicio','servicio.ID_Servicio','=','inventario.ID_Servicio')
            ->select('inventario.ID_Objeto','inventario.Nombre','inventario.Cantidad','inventario.Estado','inventario.Costo_Alquiler','inventario.Costo_Objeto','inventario.Disponibilidad','servicio.Nombre as servicio')
            ->where('inventario.Nombre','like',$nombreArt.'%')->where('inventario.ID_Servicio','=',$idservicio)->get();
        }
        if($idservicio=="0" && $nombreArt=="0")
        {
           $inventario=$inventario=DB::table('inventario')
            ->join('servicio','servicio.ID_Servicio','=','inventario.ID_Servicio')
            ->select('inventario.ID_Objeto','inventario.Nombre','inventario.Cantidad','inventario.Estado','inventario.Costo_Alquiler','inventario.Costo_Objeto','inventario.Disponibilidad','servicio.Nombre as servicio')
            ->paginate(10);
        }
        return view('inventario.recargable.listainventario',compact('inventario'));
    }

    public function mensaje($val=null)
    {
        if($val=="msj")
            return view('alert.mensaje');
        else
            return view('inventario.errores');
            
    }
}