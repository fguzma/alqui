<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Menu extends Model
{
    protected $table='menu';
    public $primaryKey='id';
    public $incrementing = true;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'descripcion', 'path', 'costo',
    ];
/*     public function setPathAttribute($path){
        if(!empty($path))
        {
            $now= new \DateTime();//Capturamos el tiempo actual
            //Al atributo path le conctenamos la fecha actual para hacerlo unico
            $this->attributes['path'] = $now->format('d-m-Y_H_i_s').$path->getClientOriginalName();
            $name=$now->format('d-m-Y_H_i_s').$path->getClientOriginalName();//La variable name definira el nombre del archivo almacenado
            \Storage::disk('local')->put($name, \File::get($path));//Guardamos de forma local
        }
    } */
}