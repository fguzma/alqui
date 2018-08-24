<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    protected $table='cargo';
    public $primaryKey='ID_Cargo';
    public $incrementing = true;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'Nombre_Cargo',
    ];
}
