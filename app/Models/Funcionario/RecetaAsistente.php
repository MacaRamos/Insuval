<?php

namespace App\Models\Funcionario;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class RECETAASISTENTE extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RECETAASISTENTE";
    protected $guarded = ['Rec_codigo', 'Mb_Epr_cod','Fun_rut'];
    protected $primaryKey = ['Rec_codigo', 'Mb_Epr_cod','Fun_rut'];
    public $timestamps = false;
}
