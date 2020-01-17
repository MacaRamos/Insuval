<?php

namespace App\Models\MovimientoInventario;

use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class EXISMOVC extends Model
{
    use HasCompositePrimaryKey;
    
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.EXISMOVC";
    protected $guarded = ['Mb_Epr_cod', 'Ex_mov_cod'];
    protected $primaryKey = ['Mb_Epr_cod', 'Ex_mov_cod'];
    public $timestamps = false;
}
