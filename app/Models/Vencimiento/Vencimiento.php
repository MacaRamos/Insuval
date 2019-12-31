<?php

namespace App\Models\Vencimiento;

use Illuminate\Database\Eloquent\Model;

class Vencimiento extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Vencimiento";
    protected $guarded = ['Ven_codigo','Ven_cantidad', 'Ven_tipo'];
    protected $primaryKey = 'Ven_codigo';
}
