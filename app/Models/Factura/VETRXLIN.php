<?php

namespace App\Models\Factura;

use App\Models\Articulos\ARTMAEST;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class VETRXLIN extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_gc.VETRXLIN";
    protected $guarded = ['Mb_Epr_cod', 'Ve_bol_nro', 'Ve_bol_dep', 've_bol_tip', 've_bol_nli'];
    protected $primaryKey = ['Mb_Epr_cod', 'Ve_bol_nro', 'Ve_bol_dep', 've_bol_tips', 've_bol_nli'];
    public $timestamps = false;

    public function articulo()
    {
        return $this->hasOne(ARTMAEST::class, ['Mb_Epr_cod', 'Art_cod'], ['Mb_Epr_cod', 'Ve_bol_art']);
    }
}
