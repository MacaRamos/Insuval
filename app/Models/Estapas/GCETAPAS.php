<?php

namespace App\Models\Estapas;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class GCETAPAS extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "super_gc.GCETAPAS";
    protected $guarded = ['Proc_id', 'Proc_Nombr',];
    protected $primaryKey = 'Proc_id';
    public $timestamps = false;
}
