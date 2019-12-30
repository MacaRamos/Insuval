<?php

namespace App\Models\SIC;

use Illuminate\Database\Eloquent\Model;

class ADSICLIN extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.ADSICLIN";
    protected $guarded = ['Mb_Epr_cod','SicTip', 'SicFol', 'SicLin'];
}
