<?php

namespace App\Models\dbFinanzas;

use Illuminate\Database\Eloquent\Model;

class AUXILI extends Model
{
    protected $connection = 'DBFinanzas';
    protected $table = 'super_fz.AUXILI';
    protected $guarded = 'Mb_Cod_aux';
    protected $primaryKey = 'Mb_Cod_aux';
}
