<?php

namespace App\Models\SIC;

use Illuminate\Database\Eloquent\Model;

class ADSICTRX extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.ADSICTRX";
    protected $guarded = ['Mb_Epr_cod','SicTip', 'SicFol'];

    public function lineasSIC()
    {
        return $this->hasMany(ADSICLIN::class, 'Mb_epr_cod', 'Mb_epr_cod', 'SicTip', 'SicTip', 'SicFol', 'SicFol');
    }
}

