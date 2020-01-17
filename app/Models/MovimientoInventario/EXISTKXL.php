<?php

namespace App\Models\MovimientoInventario;

use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class EXISTKXL extends Model
{
    use HasCompositePrimaryKey;
    
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.EXISTKXL";
    protected $guarded = ['Mb_Epr_cod','Ex_bod_cod', 'Ex_art_cod', 'Ex_nro_lot', 'Ex_prv_cod'];
    protected $primaryKey = ['Mb_Epr_cod','Ex_bod_cod', 'Ex_art_cod', 'Ex_nro_lot', 'Ex_prv_cod'];
    public $timestamps = false;
}
