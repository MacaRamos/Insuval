<?php

namespace App\Models\Seguridad;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class TECAJTRX extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_gc.TECAJTRX";
    protected $guarded = ['Seg_usuari', 'Te_Caja_nu', 'Te_Caj_Cod'];
    protected $primaryKey = ['Seg_usuari', 'Te_Caja_nu', 'Te_Caj_Cod'];
    public $timestamps = false;
}
