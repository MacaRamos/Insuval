<?php

namespace App\Models\RecetarioMagistral;

use Illuminate\Database\Eloquent\Model;

class IDRECETA extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "IDRECETA";
    protected $guarded = ['Id_codigo', 'Id_tipo', 'Id_numero', 'Id_ano', 'Id_RM'];
    protected $primaryKey = 'Id_codigo';
    public $timestamps = false;
}
