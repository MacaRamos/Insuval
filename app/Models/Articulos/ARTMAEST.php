<?php

namespace App\Models\Articulos;

use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;

class ARTMAEST extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;

    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.ARTMAEST";
    protected $guarded = ['Mb_Epr_cod','Art_cod'];
    protected $primaryKey = ['Mb_Epr_cod','Art_cod'];
    public $timestamps = false;
}
