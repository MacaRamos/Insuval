<?php

namespace App\Models\Factura;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class SEDES extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $connection = 'DBFinanzas';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "super_fz.SEDES";
    protected $guarded = ['Mb_Epr_cod', 'Mb_Sedecod'];
    protected $primaryKey = ['Mb_Epr_cod', 'Mb_Sedecod'];
    public $timestamps = false;
}
