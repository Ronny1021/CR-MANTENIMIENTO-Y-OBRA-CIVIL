<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    protected $fillable = [
        'nombre',
        'tipo_herramienta',
        'categoria',
        'cantidad',
        'unidad_medida',
        'disponibilidad',
        'fecha_registro',
    ];
}
