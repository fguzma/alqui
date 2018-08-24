<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\personal;
use App\Cargo;
use App\cargo_personal;
use App\Http\Requests\PersonalAdd;
use App\Http\Requests\PersonalUpdate;
use Redirect;
use Session;
use DB;

class PersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($msj=null,$cedula=null)
    { 
        
        $personal=personal::all();
        if($msj=="2")
        {
            session::flash('message','Personal editado exitosamente');
            session::flash('tipo','info');
        }
        if($msj=="1")
        {
            session::flash('message','Personal agregado exitosamente');
            session::flash('tipo','info');
        }
        session::flash('valor',$cedula);
        $Cargos=Cargo::all();
        return view('personal.index',compact('personal','Cargos'));
    }
    public function create()
    {
        $Cargo=Cargo::all();
        return view('personal.create',['message'=>"",'Cargos'=>$Cargo]);
    }
    public function store(PersonalAdd $request)
    { 
        personal::create([
            'Cedula_Personal'=>$request['Cedula_Personal'],    
            'Nombre'=> $request['Nombre'],
            'Apellido'=>$request['Apellido'],
            'Direccion'=>($request['Direccion']),
            'Fecha_Nac'=> $request['Fecha_Nac'],
        ]);
        
        return 1;
    }
    //Agrega un conjunto de cargos al nuevo personal
    public function agregarcargo(Request $listacargo)
    {
        foreach($listacargo->get("listacargo") as $lc)
        {
            cargo_personal::create([
                'Cedula_Personal'=>$listacargo->get('cedula'),    
                'ID_Cargo'=> $lc[1],
            ]);
        }
        return 1;
    }
    public function destroy($id)
    {
        $usuario=personal::find($id);
        $usuario->delete();
        return 1;
    }
    //Actualiza los datos del personal
    public function update($cedula,PersonalUpdate $request)
    {
        $usuario=personal::find($cedula);
        if($usuario['Cedula_Personal']!=$request['Cedula_Personal'])
        {
            $consulta=personal::Where('Cedula_Personal','=',$request['Cedula_Personal'])->get();
            if(count($consulta)==0)
            {
                $usuario['Cedula_Personal']=$request['Cedula_Personal'];
                $usuario['Nombre']=$request['Nombre'];
                $usuario['Apellido']=$request['Apellido'];
                $usuario['Direccion']=$request['Direccion'];
                $usuario['Fecha_Nac']=$request['Fecha_Nac'];
                $usuario->save();
            }
            else
                return 0;
        }
        else
        {
            $usuario['Nombre']=$request['Nombre'];
            $usuario['Apellido']=$request['Apellido'];
            $usuario['Direccion']=$request['Direccion'];
            $usuario['Fecha_Nac']=$request['Fecha_Nac'];
            $usuario->save();
        }
        return 1;
    }
    //Actualiza agregando o eliminando cargos al personal
    public function actualizarcargos(Request $listacargo)
    {
        $cadena="";
        $now = new \DateTime();
        //TODOS LOS CARGOS RELACIONADOS A LA PERSONA SON PUESTOS EN UN ESTADO "ELIMINADO"
        DB::table('cargo_personal')
        ->where('Cedula_Personal','=',$listacargo->get("cedula"))
        ->update(array('deleted_at'=>$now->format('Y-m-d H:i:s')));
        foreach($listacargo->get("listacargo") as $lc)
        {
            
            $consulta=DB::table('cargo_personal')->where('Cedula_Personal','=',$listacargo->get("cedula"))
            ->where("ID_Cargo",'=',$lc[0])->get();
            //SI EL CARGO EXISTE 
            if(count($consulta)==0)
            {
                cargo_personal::create([
                    'Cedula_Personal'=>$listacargo->get('cedula'),    
                    'ID_Cargo'=> $lc[0],
                ]);
            }
            else
            {
                $consulta=DB::table('cargo_personal')
                ->where('Cedula_Personal','=',$listacargo->get("cedula"))
                ->where("ID_Cargo",'=',$lc[0])
                ->update(array('deleted_at'=>null));
            }
        }
        return 1;
    }
    public function show($cedula)
    {
        $personal=personal::find($cedula);
        if($personal!=null)
        {
            return response()->json(
                $personal->toArray()
            );
        }
    }
    //retorna los ID  de los cargos para poder llenar las checkbox
    public function cargos($id=null)
    {
        $idcargos=DB::table('cargo')->select("cargo.ID_Cargo")
         ->join('cargo_personal',"cargo_personal.ID_Cargo",'=',"cargo.ID_Cargo")
         ->where("cargo_personal.Cedula_Personal",'=',$id)
         ->where("cargo_personal.deleted_at","=",null)->get();
         return $idcargos;
        return response()->json($idcargos);
    }
}
