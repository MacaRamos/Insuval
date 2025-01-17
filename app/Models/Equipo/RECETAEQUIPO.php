<?php

namespace App\Models\Equipo;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class RECETAEQUIPO extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RECETAEQUIPO";
    protected $guarded = ['Rec_codigo', 'Mb_Epr_cod', 'Equ_codigo'];
    protected $primaryKey = ['Rec_codigo', 'Mb_Epr_cod', 'Equ_codigo'];
    public $timestamps = false;
}
