<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    protected $table='inventario';
    public $primaryKey='ID_Objeto';
    public $incrementing = true;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'ID_Objeto','ID_Servicio','Estado','Cantidad','Nombre','Costo_Alquiler','Costo_Objeto','Disponibilidad','CantRentados',
    ];
}
