<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $dateFormat = 'y-m-d h:i:s';
    protected $table = "Menu";
    protected $fillable = ['Men_nombre', 'Men_url', 'Men_icono'];
    protected $guarded = ['Men_id'];
}
