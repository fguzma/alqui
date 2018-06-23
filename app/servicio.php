<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class servicio extends Model
{
    protected $table='servicio';
    public $primaryKey='ID_Servicio';
    public $incrementing = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'ID_Servicio','Nombre',
    ];
}
