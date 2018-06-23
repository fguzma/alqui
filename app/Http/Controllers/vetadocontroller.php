<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\personal;
use App\cliente;
use App\vetado;
use App\Http\Requests\VetadoAdd;
use DB;

class vetadocontroller extends Controller
{
    public function index($tipo='cliente',$view="vetado.indexc",$cedu=null)
    {
        if($tipo=="cliente")
        {
            $vetados=vetado::select('cliente.Nombre','cliente.Apellido','cliente.Cedula_Cliente','vetado.descripcion','vetado.ID_Vetado')
            ->join('cliente','cliente.Cedula_Cliente','=','vetado.IdCliente')
            ->where('IdCliente','like',$cedu.'%')->get();
        }
        if($tipo=="personal")
        {
            $vetados=vetado::select('personal.Nombre','personal.Apellido','personal.Cedula_Personal','vetado.descripcion','vetado.ID_Vetado')
            ->join('personal','personal.Cedula_Personal','=','vetado.IdPersonal')
            ->where('IdPersonal','like',$cedu.'%')->get();
        }
        return view($view,compact('vetados'));
    }
    public function create()
    {
        
    }
    public function store()
    {
        
    }
    public function edit($id)
    {
        /*$cliente=cliente::find($id);
        return "que paso?";
        return response()->json(
            $cliente->toArray()
        );*/
    }
    public function update($cedu,request $datos)//Actualizar la descripcion del vetado
    {
        if($datos['descripcion']!="")
        {
            if($datos['tipo']=="cliente")
            {
                $vetado=vetado::where('IdCliente','=',$cedu)->get();
                $vetado[0]['descripcion']=$datos['descripcion'];
                $vetado[0]->save();
            }
            if($datos['tipo']=='personal')
            {
                $vetado=vetado::where('IdPersonal','=',$cedu)->get();
                $vetado[0]['descripcion']=$datos['descripcion'];
                $vetado[0]->save();
            }
            return 1;
        }
        else
            return 'error';

    }
    
    public function listapersonal($view="vetado.createp")
    {
        $arreglo=[];
        $personalvetado=vetado::where('IdPersonal','!=',null)->get();//obtenemos la lista de clientes vetados
        foreach($personalvetado as $pv)//recorremos la lista con el fin de:
        {
            array_push($arreglo,$pv['IdPersonal']);//almacenar las cedulas de clientes en un arreglo
        }
        //ejecutamos una consulta diciendo que tomara todos los registros menos los que esten contenidos en el arreglo
        $personal = DB::table('personal')
                    ->where('deleted_at','=',null)
                    ->whereNotIn('Cedula_Personal', $arreglo)->get();
        return view($view,compact('personal'));
    }
    public function listacliente($view="vetado.createc")
    {
        $arreglo=[];
        $clientevetado=vetado::where('IdCliente','!=',null)->get();//obtenemos la lista de clientes vetados
        foreach($clientevetado as $cv)//recorremos la lista con el fin de:
        {
            array_push($arreglo,$cv['IdCliente']);//almacenar las cedulas de clientes en un arreglo
        }
        //ejecutamos una consulta diciendo que tomara todos los registros menos los que esten contenidos en el arreglo
        $clientes = DB::table('cliente')
                    ->where('deleted_at','=',null)
                    ->whereNotIn('Cedula_Cliente', $arreglo)->get();
        return view($view,compact('clientes'));
    }
    public function vetar(VetadoAdd $datos)
    {
        if($datos->get("tipo")=="cliente")
        {

            $consulta=vetado::where('IdCliente','=',$datos->get("La_cedula_del_cliente"))->orwhere('IdPersonal','=',$datos->get("La_cedula_del_cliente"))->get();
            if(count($consulta)==0)
            {
                vetado::create([
                    'IdPersonal'=>null,
                    'IdCliente'=>$datos->get("La_cedula_del_cliente"),
                    'descripcion'=>"Cliente: ".$datos->get("descripcion"),
                ]);
                return 1;
            }
            else
            {
                $consulta[0]['IdCliente']=$datos->get("La_cedula_del_cliente");
                $consulta[0]['descripcion'].="\nCliente: ".$datos->get("descripcion");
                $consulta[0]->save();
                return 1;
            }
        }
        else
        {
            $consulta=vetado::where('IdCliente','=',$datos->get("La_cedula_del_personal"))->orwhere('IdPersonal','=',$datos->get("La_cedula_del_personal"))->get();
            /*return $consulta[0]['descripcion'];*/
            if(count($consulta)==0)
            {
                vetado::create([
                    'IdPersonal'=>$datos->get("La_cedula_del_personal"),
                    'IdCliente'=>null,
                    'descripcion'=>"Personal: ".$datos->get("descripcion"),
                ]);
                return 1;
            }
            else
            {
                $consulta[0]['IdPersonal']=$datos->get("La_cedula_del_personal");
                $consulta[0]['descripcion'].="\nPersonal: ".$datos->get("descripcion");
                $consulta[0]->save();
                return 1;
            }
        }
        return "error";
    }

    public function descripcion($tipo="cliente",$cedu=null)
    {
        if($tipo=="cliente")
        {
            $vetado=vetado::select('cliente.Nombre','cliente.Apellido','cliente.Cedula_Cliente','cliente.Edad','cliente.Sexo','vetado.descripcion','vetado.ID_Vetado')
            ->join('cliente','cliente.Cedula_Cliente','=','vetado.IdCliente')
            ->where('IdCliente','=',$cedu)->get();
        }
        if($tipo=="personal")
        {
            $vetado=vetado::select('personal.Nombre','personal.Apellido','personal.Cedula_Personal','personal.Direccion','personal.Fecha_Nac','vetado.descripcion','vetado.ID_Vetado')
            ->join('personal','personal.Cedula_Personal','=','vetado.IdPersonal')
            ->where('IdPersonal','=',$cedu)->get();
        }
        return $vetado[0];
    }
    public function destroy($cedu,request $datos)
    {
        if($datos['tipo']=='cliente')
        {
            $vetado=vetado::where('IdCliente','=',$cedu)->get();
            $vetado[0]->delete();
        }
        if($datos['tipo']=='personal')
        {
            $vetado=vetado::where('IdPersonal','=',$cedu)->get();
            $vetado[0]->delete();
        }
        return 1;
    }
    
}
