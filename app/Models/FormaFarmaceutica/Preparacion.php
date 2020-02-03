<?php

namespace App\Models\FormaFarmaceutica;

use Illuminate\Database\Eloquent\Model;

class Preparacion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Preparacion";
    protected $guarded = ['Pre_codigo'];
    protected $primaryKey = 'Pre_codigo';
    public $timestamps = false;
}
