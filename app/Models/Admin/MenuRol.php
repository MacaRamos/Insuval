<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MenuRol extends Model
{
    protected $table = 'menuRol';
    protected $fillable = ['Men_nombre', 'Men_url', 'Men_icono'];// campos que se guardan en la base de datos
    protected $guarded = ['Men_id'];
    protected $timestamps = false;
}
