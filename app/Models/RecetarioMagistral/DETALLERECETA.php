<?php

namespace App\Models\RecetarioMagistral;

use App\Models\Articulos\ARTMAEST;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class DETALLERECETA extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "DetalleReceta";
    protected $guarded = ['Rec_codigo', 'Mb_Epr_cod', 'Drec_item'];
    protected $primaryKey = ['Rec_codigo', 'Mb_Epr_cod', 'Drec_item'];
    public $timestamps = false;

    public function articulo()
    {
        return $this->hasOne(ARTMAEST::class, ['Mb_Epr_cod', 'Art_cod'], ['Mb_Epr_cod', 'Art_cod']);
    }
}
