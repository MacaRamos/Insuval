<?php

namespace App\Models\dbFinanzas;

use App\Models\Factura\GIROS;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class AUXILI extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $connection = 'DBFinanzas';
    protected $table = 'super_fz.AUXILI';
    protected $guarded = ['Mb_Cod_aux'];
    protected $primaryKey = 'Mb_Cod_aux';

    public function giro()
    {
        return $this->hasOne(GIROS::class, 'Mb_Giro_co', 'Mb_Giro_co');
    }
}
