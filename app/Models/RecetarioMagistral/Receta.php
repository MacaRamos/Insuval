<?php

namespace App\Models\RecetarioMagistral;

use App\Models\Equipo\Equipo;
use App\Models\Funcionario\RecetaAsistente;
use App\Models\Precauciones\Precaucion;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Receta extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Receta";
    protected $guarded = ['Rec_codigo', 'Mb_Epr_cod'];
    protected $primaryKey = ['Rec_codigo', 'Mb_Epr_cod'];

    public function asistentes()
    {
        return $this->belongsToMany(Receta::class, 'RecetaAsistente', ['Rec_codigo','Mb_Epr_cod'], 'Fun_Rut');
    }

    public function equipo()
    {
        return $this->belongsToMany(Equipo::class, 'RecetaEquipo', ['Rec_codigo','Mb_Epr_cod'], 'Equ_codigo');
    }

    public function precaucion()
    {
        return $this->belongsToMany(Precaucion::class, 'RecetaPrecaucion', ['Rec_codigo','Mb_Epr_cod'], 'Cau_codigo');
    }
}
