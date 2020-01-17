<?php

namespace App\Models\dbFinanzas;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class DIRECC extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $connection = 'DBFinanzas';
    protected $table = 'super_fz.DIRECC';
    protected $guarded = ['Mb_Cod_Aux', 'Mb_cor_dir'];
    protected $primaryKey = ['Mb_Cod_Aux', 'Mb_cor_dir'];
    public $timestamps = false;
}
