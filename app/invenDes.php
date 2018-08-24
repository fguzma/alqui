<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invenDes extends Model
{
    protected $table='inven_descri';
    protected $fillable = [
        'ID_Objeto','ID_Descripcion',
    ];
}
