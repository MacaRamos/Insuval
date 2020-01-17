<?php

namespace App\Models\Factura;

use Illuminate\Database\Eloquent\Model;

class EMPRES extends Model
{
    protected $connection = 'DBFinanzas';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = 'super_fz.EMPRES';
    protected $guarded = ['Mb_Epr_cod'];
    protected $primaryKey = 'Mb_Epr_cod';
    public $timestamps = false;
}