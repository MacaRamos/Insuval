<?php

namespace App\Models\dbFinanzas;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class REGION extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $connection = 'DBFinanzas';
    protected $table = 'super_fz.REGION';
    protected $guarded = ['Mb_region', 'Mb_ciudad'];
    protected $primaryKey = ['Mb_region', 'Mb_ciudad'];
    public $timestamps = false;
}
