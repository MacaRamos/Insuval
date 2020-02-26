<?php

namespace App\Models\SIC;

use App\Models\Articulos\ARTMAEST;
use App\Models\Formulacion\ARTFORMU;
use App\Models\MovimientoInventario\EXISTOCK;
use App\Models\RecetarioMagistral\Receta;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;

class ADSICLIN extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;

    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.ADSICLIN";
    protected $guarded = ['Mb_Epr_cod','SicTip', 'SicFol', 'SicLin'];
    protected $primaryKey = ['Mb_Epr_cod', 'SicTip', 'SicFol', 'SicLin'];
    public $timestamps = false;
    public static $snakeAttributes = false;

    public function articulo()
    {
        return $this->hasOne(ARTMAEST::class, ['Mb_Epr_cod', 'Art_cod'], ['Mb_Epr_cod', 'Art_cod']);
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class, ['Mb_Epr_cod', 'PrincipioActivo', 'SicLin'], ['Mb_Epr_cod', 'Art_cod', 'SicLin']);
    }

    // public function recetas($Art_cod)
    // {
    //     return Receta::where('Mb_Epr_cod', '=', $this->Emp)
    //                  ->where('PrincipioActivo', '=', $Art_cod)
    //                  ->get();
    // }

    public function formulacion()
    {
        return $this->hasMany(ARTFORMU::class, ['Mb_Epr_cod', 'Gc_art1'], ['Mb_Epr_cod', 'Art_cod']);
    }

    public function stock()
    {
        return $this->hasOne(EXISTOCK::class, ['Mb_Epr_cod', 'Ex_art_cod'], ['Mb_Epr_cod', 'Art_cod']);
    }

    public function sic()
    {
        return $this->hasOne(ADSICTRX::class, ['Mb_Epr_cod', 'SicTip', 'SicFol'], ['Mb_Epr_cod', 'SicTip', 'SicFol']);
    }
}
