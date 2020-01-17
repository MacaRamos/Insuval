<?php

namespace App\Models\SIC;

use App\Models\Cliente\CLIDEFIN;
use App\Models\dbFinanzas\AUXILI;
use App\Models\dbFinanzas\DIRECC;
use App\Models\Paciente\Paciente;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;

class ADSICTRX extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.ADSICTRX";
    protected $guarded = ['Mb_Epr_cod','SicTip', 'SicFol'];
    protected $primaryKey = ['Mb_Epr_cod', 'SicTip', 'SicFol'];
    public $timestamps = false;

    public function lineasSIC()
    {
        return $this->hasMany(ADSICLIN::class, ['Mb_Epr_cod', 'SicTip', 'SicFol'], ['Mb_Epr_cod', 'SicTip', 'SicFol']);
    }

    public function cliente()
    {
        return $this->hasOne(AUXILI::class, 'Mb_Cod_aux', 'Ve_Cod_Cli');
    }

    public function clidefin()
    {
        return $this->hasOne(CLIDEFIN::class, ['Mb_Epr_cod', 'Ve_Cod_Cli'], ['Mb_Epr_cod','Ve_Cod_Cli']);
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'PacID', 'Ve_cod_pac');
    }    
    
    public function direccion()
    {
        return $this->hasOne(DIRECC::class, ['Mb_Cod_Aux', 'Mb_cor_dir'], ['Ve_Cod_Cli', 'Sicdircli']);
    }
}

