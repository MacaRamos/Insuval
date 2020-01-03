<?php

namespace App\Models\Funcionario;

use App\Models\RecetarioMagistral\Receta;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Funcionario";
    protected $guarded = ['Fun_rut'];
    protected $primaryKey = 'Fun_rut';

    public function asistentes()
    {
        return $this->belongsToMany(Receta::class, 'recetaasistente', ['Rec_codigo','Mb_Epr_cod'], 'Fun_Rut');
    }
}
