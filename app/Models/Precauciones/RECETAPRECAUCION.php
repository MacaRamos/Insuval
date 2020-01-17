<?php

namespace App\Models\Precauciones;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class RECETAPRECAUCION extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RECETAPRECAUCION";
    protected $guarded = ['Rec_codigo', 'Mb_Epr_cod','Cau_codigo'];
    protected $primaryKey = ['Rec_codigo', 'Mb_Epr_cod','Cau_codigo'];
    public $timestamps = false;
}
