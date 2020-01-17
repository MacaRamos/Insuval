<?php

namespace App\Models\MovimientoInventario;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class EXISTOCK extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.EXISTOCK";
    protected $guarded = ['Mb_Epr_cod','Ex_art_cod', 'Ex_bod_cod', 'Ex_ubi_cod'];
    protected $primaryKey = ['Mb_Epr_cod','Ex_art_cod', 'Ex_bod_cod', 'Ex_ubi_cod'];
    public $timestamps = false;
}
