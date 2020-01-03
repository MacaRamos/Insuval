<?php

namespace App\Models\Prescriptor;

use Illuminate\Database\Eloquent\Model;

class AUXPRE extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "AUXPRE";
    protected $guarded = ['IdPre','RUTPre', 'DVPre'];
    protected $primaryKey = 'IdPre';
}
