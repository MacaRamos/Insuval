<?php

namespace App\Models\Precauciones;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class RECETAPRECAUCION extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RecetaPrecaucion";
    protected $guarded = ['Rec_codigo', 'Mb_Epr_cod', 'Cau_codigo'];
    protected $primaryKey = ['Rec_codigo', 'Mb_Epr_cod', 'Cau_codigo'];
    public $timestamps = false;

    public function precaucion()
    {
        return $this->hasMany(Precaucion::class, 'Cau_codigo', 'Cau_codigo');
    }
}
