<?php

namespace App\Models\Prescriptor;

use Illuminate\Database\Eloquent\Model;

class Prescriptor extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Prescriptores";
    protected $guarded = ['PreID','PreRUT', 'PreDV'];
    protected $primaryKey = 'PreID';
}
