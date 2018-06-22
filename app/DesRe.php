<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesRe extends Model
{
    protected $table='desres';
    protected $fillable = [
        'idDescripcion','idReservacion',
    ];
}
