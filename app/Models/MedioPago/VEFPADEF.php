<?php

namespace App\Models\MedioPago;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class VEFPADEF extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_gc.VEFPADEF";
    protected $guarded = ['Mb_Epr_cod', 'Ve_tcod_pa'];
    protected $primaryKey = ['Mb_Epr_cod', 'Ve_tcod_pa'];
    public $timestamps = false;
}
