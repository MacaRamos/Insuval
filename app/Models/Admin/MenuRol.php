<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MenuRol extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = 'MenuRol';
    protected $timestamps = false;
    protected $primaryKey = ['Rol_codigo', 'Men_id'];
