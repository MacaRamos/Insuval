<?php

namespace App\Models\Funcionario;

use App\Models\RecetarioMagistral\Receta;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;

class RecetaAsistente extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RecetaAsistente";
    protected $guarded = ['Rec_codigo', 'Mb_Epr_cod','Fun_rut'];
    protected $primaryKey = ['Rec_codigo', 'Mb_Epr_cod','Fun_rut'];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'Fun_rut', 'Fun_rut');
    }
}
