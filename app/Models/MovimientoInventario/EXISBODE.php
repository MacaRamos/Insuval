<?php

namespace App\Models\MovimientoInventario;

use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class EXISBODE extends Model
{
    use HasCompositePrimaryKey;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.EXISBODE";
    protected $guarded = ['Mb_Epr_cod', 'Bod_cod'];
    protected $primaryKey = ['Mb_Epr_cod', 'Bod_cod'];
}
