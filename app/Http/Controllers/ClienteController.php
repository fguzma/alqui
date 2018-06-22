<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\clienteAdd;
use App\Http\Requests\clienteUpdate;
use App\Cliente;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Redirect;
use Session;
use DB;
use DataTables;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($msj=null,$cedula="")
    { 
        $clientes=Cliente::all();
        if($msj=="2")
        {
            session::flash('message','Cliente editado exitosamente');
            session::flash('tipo','info');
        }
        if($msj=="1")
        {
            session::flash('message','Cliente agregado exitosamente');
            session::flash('tipo','info');
        }
        Session::flash('valor',$cedula);
        return view('cliente.index',compact('clientes'));
    }
    public function store(clienteAdd $request)
    { 
            Cliente::create([
            'Cedula_Cliente'=>$request['Cedula_Cliente'],    
            'Nombre'=> $request['Nombre']." ",
            'Apellido'=>$request['Apellido'],
            'Edad'=>($request['Edad']),
            'Sexo'=> $request['Sexo'],
        ]);
        return 1;
        //return redirect('/vercliente'.'/'.$request['Cedula_Cliente']);
    }

    public function destroy($id)
    {
        $usuario=cliente::find($id);
        $usuario->delete();
        return 1;
    }
    public function edit($Cedula_Cliente)
    {
         $cliente=Cliente::find($Cedula_Cliente);//DB::table('cliente')->where('Cedula_Cliente','=',$Cedula_Cliente)->get()
         //dd($cliente->get(0));
         //dd($cliente);
         //return $cliente->Nombre;
         return view('cliente.edit',['cliente'=>$cliente]);
       // return Redirect::to('/editar');
    }
    public function update($cedula,clienteUpdate $request)
    {
        $usuario=cliente::find($cedula);
        if($usuario['Cedula_Cliente']!=$request['Cedula_Cliente'])
        {
            $consulta=cliente::Where('Cedula_Cliente','=',$request['Cedula_Cliente'])->get();
            if(count($consulta)==0)
            {
                $usuario['Cedula_Cliente']=$request['Cedula_Cliente'];
                $usuario['Nombre']=$request['Nombre'];
                $usuario['Apellido']=$request['Apellido'];
                $usuario['Edad']=$request['Edad'];
                $usuario['Sexo']=$request['Sexo'];
                $usuario->save();
            }
            else
                return 0;
        }
        else
        {
            $usuario['Nombre']=$request['Nombre'];
            $usuario['Apellido']=$request['Apellido'];
            $usuario['Edad']=$request['Edad'];
            $usuario['Sexo']=$request['Sexo'];
            $usuario->save();
        }
        return 1;
    }
    public function create()
    {
        return view('cliente.create',['message'=>""]);
    }
    public function show($id)
    {
        $cliente=cliente::find($id);
        if($cliente!=null)
        {
            return response()->json(
                $cliente->toArray()
            );
        }
    }
    public function lista()
    {
        return DataTables::eloquent(Cliente::query())->make(true);
        return view($vista,compact('clientes'));
    }
    public function prueba()
    {
        return view('cliente.create',['message'=>""]);
    }
            
    public function agregado($valor=null)
    {
        $clientes=Cliente::paginate(10);
        return view('cliente.index',compact('clientes','valor'));
    }

}
