<?php

namespace App\Models\Funcionario;

use App\Models\RecetarioMagistral\Receta;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Funcionario";
    protected $guarded = ['Fun_rut', 'Fun_nombre', 'Fun_apellido', 'Fun_tipo'];
    protected $primaryKey = 'Fun_rut';
    public $timestamps = false;
}
