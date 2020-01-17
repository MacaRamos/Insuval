<?php

namespace App\Models\Cliente;

use App\Models\MedioPago\VEFPADEF;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class CLIDEFIN extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_gc.CLIDEFIN";
    protected $guarded = ['Mb_Epr_cod', 'Ve_Cod_Cli'];
    protected $primaryKey = ['Mb_Epr_cod', 'Ve_Cod_Cli'];
    public $timestamps = false;

    public function formaPago()
    {
        return $this->hasOne(VEFPADEF::class, ['Mb_Epr_cod', 'Ve_tcod_pa'], ['Mb_Epr_cod', 'Ve_cli_cod']);
    }
}
