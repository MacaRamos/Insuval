<?php

namespace App\Models\Equipo;

use Illuminate\Database\Eloquent\Model;


class Equipo extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Equipo";
    protected $guarded = ['Equ_codigo'];
    protected $primaryKey = 'Equ_codigo';
}
