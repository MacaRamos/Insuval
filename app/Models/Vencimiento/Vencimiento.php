<?php

namespace App\Models\Vencimiento;

use Illuminate\Database\Eloquent\Model;

class Vencimiento extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "VENCIMIENTO";
    protected $guarded = ['Ven_codigo','Ven_cantidad', 'Ven_tipo'];
    protected $primaryKey = 'Ven_codigo';
    public $timestamps = false;
}
