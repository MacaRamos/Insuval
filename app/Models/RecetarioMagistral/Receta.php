<?php

namespace App\Models\RecetarioMagistral;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $dateFormat = 'y-m-d h:i:s';
    protected $table = 'receta';
}
