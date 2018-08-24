<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Http\Requests\clienteAdd;
use App\Http\Requests\clienteUpdate;
use Session;
use DB;

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
    public function create()
    {
        return view('cliente.create',['message'=>""]);
    }
    public function store(clienteAdd $request)
    { 
            Cliente::create([
            'Cedula_Cliente'=>$request['Cedula_Cliente'],    
            'Nombre'=> $request['Nombre']." ",
            'Apellido'=>$request['Apellido'],
            'Edad'=>($request['Edad']),
            'Sexo'=> $request['Sexo'],
            'Direccion'=> $request['Direccion'],
        ]);
        return 1;
    }

    public function destroy($id)
    {
        $usuario=Cliente::find($id);
        $usuario->delete();
        return 1;
    }
    public function update($cedula,clienteUpdate $request)
    {
        $usuario=Cliente::find($cedula);
        if($usuario['Cedula_Cliente']!=$request['Cedula_Cliente'])
        {
            $consulta=Cliente::Where('Cedula_Cliente','=',$request['Cedula_Cliente'])->get();
            if(count($consulta)==0)
            {
                $usuario['Cedula_Cliente']=$request['Cedula_Cliente'];
                $usuario['Nombre']=$request['Nombre'];
                $usuario['Apellido']=$request['Apellido'];
                $usuario['Edad']=$request['Edad'];
                $usuario['Sexo']=$request['Sexo'];
                $usuario['Direccion']=$request['Direccion'];
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
            $usuario['Direccion']=$request['Direccion'];
            $usuario->save();
        }
        return 1;
    }
    public function show($id)
    {
        $cliente=Cliente::find($id);
        if($cliente!=null)
        {
            return response()->json(
                $cliente->toArray()
            );
        }
    }



}
