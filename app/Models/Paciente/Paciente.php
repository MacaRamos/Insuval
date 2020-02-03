<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Pacientes";
    protected $guarded = ['PacID','PacRUT', 'PacDV'];
    protected $primaryKey = 'PacID';
    public $timestamps = false;
}
