<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservacion extends Model
{
    protected $table='reservacion';
    public $primaryKey='ID_Reservacion';
    public $incrementing = true;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'ID_Reservacion','Cedula_Cliente','Nombre_Contacto','Fecha_Inicio','Fecha_Fin','Direccion_Local',
    ];
}
