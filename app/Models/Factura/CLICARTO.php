<?php

namespace App\Models\Factura;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class CLICARTO extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_gc.CLICARTO";
    protected $guarded = ['Mb_Epr_cod', 'Ve_Cod_Cli', 'Ve_doc_tip', 'Ve_pag_nro', 'Ve_pag_cuo'];
    protected $primaryKey = ['Mb_Epr_cod', 'Ve_Cod_Cli', 'Ve_doc_tip', 'Ve_pag_nro', 'Ve_pag_cuo'];
    public $timestamps = false;
}
