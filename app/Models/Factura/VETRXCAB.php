<?php

namespace App\Models\Factura;

use App\Models\dbFinanzas\AUXILI;
use App\Models\dbFinanzas\DIRECC;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class VETRXCAB extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_gc.VETRXCAB";
    protected $guarded = ['Mb_Epr_cod', 'Ve_bol_nro', 'Ve_bol_dep', 've_bol_tip'];
    protected $primaryKey = ['Mb_Epr_cod', 'Ve_bol_nro', 'Ve_bol_dep', 've_bol_tip'];
    public $timestamps = false;

    public function cliente()
    {
        return $this->hasOne(AUXILI::class, 'Mb_Cod_aux', 'Ve_Cod_Cli');
    }

    public function direccion($Ve_Cod_Cli, $ve_trx_dfa)
    {        
        return DIRECC::where('Mb_Cod_Aux', '=', $Ve_Cod_Cli)->where('Mb_cor_dir', '=', $ve_trx_dfa)->first();
    }
}
