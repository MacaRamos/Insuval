<?php

namespace App\Models\SIC;

use App\Models\Articulos\ARTMAEST;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;

class ADSICLIN extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;

    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.ADSICLIN";
    protected $guarded = ['Mb_Epr_cod','SicTip', 'SicFol', 'SicLin'];
    protected $primaryKey = ['Mb_Epr_cod', 'SicTip', 'SicFol', 'SicLin'];

    public function articulo()
    {
        return $this->hasOne(ARTMAEST::class, ['Mb_Epr_cod', 'Art_cod'], ['Mb_Epr_cod', 'Art_cod']);
    }
}
