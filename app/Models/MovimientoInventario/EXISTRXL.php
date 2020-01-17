<?php

namespace App\Models\MovimientoInventario;

use App\Models\Articulos\ARTMAEST;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;

class EXISTRXL extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.EXISTRXL";
    protected $guarded = ['MOV_FOLIO','Ex_mov_cod', 'Mb_Epr_cod', 'EX_LINEA', 'Art_cod'];
    protected $primaryKey = ['MOV_FOLIO', 'Ex_mov_cod', 'Mb_Epr_cod', 'EX_LINEA', 'Art_cod'];
    public $timestamps = false;

    public function articulo()
    {
        return $this->hasOne(ARTMAEST::class, 'Art_cod', 'Art_cod');
    }
}
