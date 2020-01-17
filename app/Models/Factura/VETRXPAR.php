<?php

namespace App\Models\Factura;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class VETRXPAR extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_gc.VETRXPAR";
    protected $guarded = ['Mb_Epr_cod', 'Mb_sedecod', 'gc_caja_co'];
    protected $primaryKey = ['Mb_Epr_cod', 'Mb_sedecod', 'gc_caja_co'];
    public $timestamps = false;
}
