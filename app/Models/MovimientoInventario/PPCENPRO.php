<?php

namespace App\Models\MovimientoInventario;

use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class PPCENPRO extends Model
{
    use HasCompositePrimaryKey;
    
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.PPCENPRO";
    protected $guarded = ['pp_epr_cod', 'pp_cen_id'];
    protected $primaryKey = ['pp_epr_cod', 'pp_cen_id'];
}
