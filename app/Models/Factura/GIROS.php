<?php

namespace App\Models\Factura;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class GIROS extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $connection = 'DBFinanzas';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_fz.GIROS";
    protected $guarded = ['Mb_Giro_co'];
    protected $primaryKey = 'Mb_Giro_co';
    public $timestamps = false;
}
