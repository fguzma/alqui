<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Http\Requests\MenuAdd;
use App\Http\Requests\MenuUpdate;

class MenuController extends Controller
{
    public function index()
    {
        $menu=Menu::all();
        return view('menu.index',compact('menu'));
    }
    public function create()
    {
        return view('menu.create');
    }
    public function store(MenuAdd $request)
    {
        if($request->hasFile('path'))
        {
            $now= new \DateTime();//Capturamos el tiempo actual
            //La variable name definira el nombre del archivo almacenado
            $name=$now->format('d-m-Y_H_i_s_').$request->file('path')->getClientOriginalName();
            $s3=\Storage::disk('s3');//Hacemos referencia al disco en la nube
            $s3->put('Menu/'.$name,\File::get($request->file('path')),'public');
            //\Storage::disk('local')->put($name, \File::get($request->file('path')));
            Menu::Create([
                'descripcion'=>$request->get('descripcion'),
                'costo'=>$request->get('costo'),
                'path'=>$name
            ]);
        }
        else
            Menu::Create($request->all());

        return 1;
    }
    public function update($id,MenuUpdate $request)
    {
        $comida=Menu::find($id);
        if($request->get('sinimagen')!=null)
        {
            $comida['descripcion']=$request->get('descripcion');
            $comida['costo']=$request->get('costo');
            $comida['path']="vacio.jpg";
            $comida->save();
            return response()->json(
                "vacio.jpg"
            );
        }
        if($request->hasFile('path'))
        {    
            $now= new \DateTime();//Capturamos el tiempo actual
            $name=$now->format('d-m-Y_H_i_s_').$request->file('path')->getClientOriginalName();//La variable name definira el nombre del archivo almacenado
            $s3=\Storage::disk('s3');//Hacemos referencia al disco en la nube
            $s3->put('Menu/'.$name,\File::get($request->file('path')),'public');
            $comida['descripcion']=$request->get('descripcion');
            $comida['costo']=$request->get('costo');
            $comida['path']=$name;
            $comida->save();
            return response()->json(
                $name
            );
        }
        else
        {
            $comida['descripcion']=$request->get('descripcion');
            $comida['costo']=$request->get('costo');
            $comida->save();
            return 1;
        }
/*         $comida["costo"]=$request['costo'];
        $comida["descripcion"]=$request['descripcion'];
        $comida["path"]=$request['path']; */
    }
    public function destroy($id)
    {
        $comida=Menu::find($id);
        if($comida['path']!="vacio.jpg")
        {
            if(\Storage::disk('s3')->exists("Menu/".$comida['path'])){
                \Storage::disk('s3')->delete("Menu/".$comida['path']);
            }
        }
        $comida->delete();
        return 1;
    }
}
