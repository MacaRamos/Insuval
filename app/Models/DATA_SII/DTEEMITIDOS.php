<?php

namespace App\Models\DATA_SII;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class DTEEMITIDOS extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $connection = 'DATA_SII';
    protected $table = 'DTEEMITIDOS';
    protected $guarded = ['emisorRut', 'dteTipo', 'dteFolio'];
    protected $primaryKey = ['emisorRut', 'dteTipo', 'dteFolio'];
    //public $timestamps = false;
}
