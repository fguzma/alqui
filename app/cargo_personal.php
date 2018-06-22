<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cargo_personal extends Model
{
    protected $table="cargo_personal";
    public $incrementing = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable=[
        'Cedula_Personal','ID_Cargo'
    ];
}
