<?php

namespace App\Models\Precauciones;

use Illuminate\Database\Eloquent\Model;

class Precaucion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Precauciones";
    protected $guarded = ['Cau_codigo'];
    protected $primaryKey = 'Cau_codigo';
}
