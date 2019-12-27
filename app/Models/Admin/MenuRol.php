<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MenuRol extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = 'menuRol';
    protected $fillable = ['Rol_nombre'];// campos que se guardan en la base de datos
    protected $guarded = ['Rol_codigo'];
    protected $timestamps = true;
}
