<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'Nombres',
        'Apellidos',
        'Documento',
        'Correo',
        'rol',
        'edad',
        'Foto'
    ];
}
