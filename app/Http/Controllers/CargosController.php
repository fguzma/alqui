<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;
use App\cargo_personal;
use App\personal;
use App\Http\Requests\CargoAdd;
use Redirect;
use Session;

class CargosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($msj=null,$nombre="")
    {
        $cargos=cargo::all();
        if($msj=="2")
        {
            session::flash('message','Cargo editado exitosamente');
            session::flash('tipo','info');
        }
        if($msj=="1")
        {
            session::flash('message','Cargo agregado exitosamente');
            session::flash('tipo','info');
        }
        Session::flash('valor',$nombre);
        return view('cargo.index',compact('cargos'));
    }
    public function create()
    {
        $Cargos=Cargo::all();
        $personal=personal::all();
        return view("cargo.create", compact('Cargos','personal'));
    }
    public function store(CargoAdd $request)
    {
        cargo::create([
            'Nombre_Cargo'=>$request['Nombre_Cargo'],
        ]);
        session::flash('message','El cargo se ha guardado correctamente');
        return 1;
    }
    public function guardar( Request $listapersonal)
    {
        $cadena="";
        $arreglo=[];
        foreach($listapersonal->get("listacargos") as $lc)
        {
            foreach($listapersonal->get("listapersonal") as $lp)
            {
                $query=cargo_personal::where('Cedula_Personal','=',$lp[2])->where('ID_Cargo','=',$lc[1])->get();
                if(count($query)==0)
                {
                    cargo_personal::create([
                        'Cedula_Personal'=>$lp[2],    
                        'ID_Cargo'=> $lc[1],
                    ]);
                }
                else
                {
                    array_push($arreglo,$lp[0]." ".$lp[1]." ya tenia asignado el cargo de ".$lc[0]);
                }
            }
        }
        if(count($arreglo)>0)
        {
            return response()->json(
                $arreglo
            );
        }
        else
            return 1;
    }
    public function recargarlista()
    {
        $Cargos=Cargo::all();
        return view('cargo.listacargo.listacargo',compact('Cargos'));
    }
    public function destroy($id)
    {
        $cargo=cargo::find($id);
        $cargo->delete();
        return 1;

    }
    public function edit($id)
    {
        $cargo=cargo::find($id);
        return view('cargo.edit',compact('cargo'));
    }
    public function update($id,CargoAdd $request)
    {
        $cargo=cargo::find($id);
        if($cargo['Nombre_Cargo']!=$request['Nombre_Cargo'])
        {
            $consulta=cargo::where('Nombre_Cargo','=',$request['Nombre_Cargo'])->get();
            if(count($consulta)==0)
            {
                $cargo->fill($request->all());
                $cargo->save();
            }
            else
            {
                return 0;
            }
        }
        return 1;
    }
    public function lista($value=null)
    {
        $cargos=cargo::where('Nombre_Cargo','like',$value.'%')->paginate(10);
        return view('cargo.listacargo.listacindex',compact('cargos'));
    }
}
