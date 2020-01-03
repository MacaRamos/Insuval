<?php

namespace App\Models\Envase;

use Illuminate\Database\Eloquent\Model;

class Envase extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Envase";
    protected $guarded = ['Env_codigo'];
    protected $primaryKey = 'Env_codigo';
}
