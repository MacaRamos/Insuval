<?php

namespace App\Models\RecetarioMagistral;

use App\Models\dbFinanzas\AUXILI;
use App\Models\Equipo\Equipo;
use App\Models\Estado\Estado;
use App\Models\FormaFarmaceutica\Preparacion;
use App\Models\Formulacion\ARTFORMU;
use App\Models\Funcionario\Funcionario;
use App\Models\Paciente\Paciente;
use App\Models\Precauciones\Precaucion;
use App\Models\Prescriptor\AUXPRE;
use App\Models\SIC\ADSICTRX;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Receta extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "Receta";
    protected $guarded = ['Rec_codigo', 'Mb_Epr_cod'];
    protected $primaryKey = ['Rec_codigo', 'Mb_Epr_cod'];
    public $timestamps = false;

    public function lineasReceta()
    {
        return $this->hasMany(DETALLERECETA::class, ['Rec_codigo', 'Mb_Epr_cod'], ['Rec_codigo', 'Mb_Epr_cod']);
    }

    public function asistentes()
    {
        return $this->belongsToMany(Funcionario::class, 'RecetaAsistente', ['Rec_codigo','Mb_Epr_cod'], 'Fun_Rut');
    }

    public function equipo()
    {
        return $this->belongsToMany(Equipo::class, 'RecetaEquipo', ['Rec_codigo','Mb_Epr_cod'], 'Equ_codigo');
    }

    public function precaucion()
    {
        return $this->belongsToMany(Precaucion::class, 'RecetaPrecaucion', ['Rec_codigo','Mb_Epr_cod'], 'Cau_codigo');
    }

    public function cliente()
    {
        return $this->hasOne(AUXILI::class, 'Mb_Cod_aux', 'Cliente');
    }

    public function formaFarmaceutica()
    {
        return $this->hasOne(Preparacion::class, 'Pre_codigo', 'Pre_codigo');
    }

    public function estado()
    {
        return $this->hasOne(Estado::class, 'Est_codigo', 'Est_codigo');
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'PacID', 'PacID');
    }

    public function prescriptor()
    {
        return $this->hasOne(AUXPRE::class, 'IdPre', 'IdPre');
    }

    public function sic()
    {
        return $this->hasOne(ADSICTRX::class, ['Mb_Epr_cod', 'SicTip', 'SicFol'], ['Mb_Epr_cod', 'SicTip', 'SicFol']);
    }

    public function formulacion()
    {
        return $this->hasMany(ARTFORMU::class, ['Mb_Epr_cod', 'Gc_art1'], ['Mb_Epr_cod', 'PrincipioActivo']);
    }
}
