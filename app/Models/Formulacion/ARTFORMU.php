<?php

namespace App\Models\Formulacion;

use App\Models\Articulos\ARTMAEST;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class ARTFORMU extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.ARTFORMU";
    protected $guarded = ['Mb_Epr_cod','Gc_tipo', 'Gc_art1', 'Gc_art2'];
    protected $primaryKey = ['Mb_Epr_cod','Gc_tipo', 'Gc_art1', 'Gc_art2'];

    public function nombreFormulacion()
    {
        return $this->hasOne(ARTMAEST::class, ['Mb_Epr_cod', 'Art_cod'], ['Mb_Epr_cod', 'Gc_art2']);
    }
}
