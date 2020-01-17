<?php

namespace App\Models\MovimientoInventario;

use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class EXISTRXC extends Model
{
    use HasCompositePrimaryKey;
    
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.EXISTRXC";
    protected $guarded = ['MOV_FOLIO','Ex_mov_cod', 'Mb_Epr_cod'];
    protected $primaryKey = ['MOV_FOLIO', 'Ex_mov_cod', 'Mb_Epr_cod'];
    public $timestamps = false;

    public function exisbode()
    {
        return $this->hasOne(EXISBODE::class, 'Bod_cod', 'Bod_destin');
    }
}
