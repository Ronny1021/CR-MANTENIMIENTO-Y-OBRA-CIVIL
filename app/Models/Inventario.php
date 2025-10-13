<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    //
    protected $fillable = [
    'tipo_herramienta',
    'nombre',
    'categoria',
    'unidad_medida',
    'cantidad',
    'estado',
    'disponibilidad',
    'fecha_registro'
];
}
