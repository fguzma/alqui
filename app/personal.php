<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class personal extends Model
{
    protected $table='personal';
    public $primaryKey='Cedula_Personal';
    public $incrementing = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'Cedula_Personal', 'Nombre', 'Apellido', 'Direccion', 'Fecha_Nac',
    ];
}
