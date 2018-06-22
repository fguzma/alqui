<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descripcion extends Model
{
    protected $table='descripcion';
    public $primaryKey='IdDescripcion';
    public $incrementing = true;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'IdDescripcion','Cantidad',	'Nombre', 'P_Unitario','Total',
    ];
}
