<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menudes extends Model
{
    protected $table='menudes';
    protected $fillable = [
        'id_menu','id_descripcion',
    ];
}
