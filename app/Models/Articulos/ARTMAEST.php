<?php

namespace App\Models\Articulos;

use Illuminate\Database\Eloquent\Model;

class ARTMAEST extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.ARTMAEST";
    protected $guarded = ['Mb_Epr_cod','Art_cod'];
}
