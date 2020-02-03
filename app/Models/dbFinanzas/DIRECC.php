<?php

namespace App\Models\dbFinanzas;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class DIRECC extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $connection = 'DBFinanzas';
    protected $table = 'super_fz.DIRECC';
    protected $guarded = ['Mb_Cod_Aux', 'Mb_cor_dir'];
    protected $primaryKey = ['Mb_Cod_Aux', 'Mb_cor_dir'];
    public $timestamps = false;

    public function region($Mb_reg_cli, $Mb_Ciu_Aux)
    {
        return REGION::Where('Mb_region', '=', $Mb_reg_cli)->where('Mb_ciudad', '=', $Mb_Ciu_Aux)->first();
    }
}
