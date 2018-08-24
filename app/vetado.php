<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vetado extends Model
{
    protected $table='vetado';
    public $primaryKey='ID_Vetado';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [	
        'IdPersonal', 'IdCliente', 'descripcion',
    ];

}
