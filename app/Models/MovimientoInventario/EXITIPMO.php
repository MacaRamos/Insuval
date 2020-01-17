<?php

namespace App\Models\MovimientoInventario;

use Illuminate\Database\Eloquent\Model;

class EXITIPMO extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.EXITIPMO";
    protected $guarded = ['Ex_mov_cod'];
    protected $primaryKey = 'Ex_mov_cod';
}
