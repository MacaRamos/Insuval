<?php

namespace App\Models\Estado;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Estado";
    protected $guarded = ['Est_codigo', 'Est_descripcion'];
    protected $primaryKey = 'Est_codigo';
}
