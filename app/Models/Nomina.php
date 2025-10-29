<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    protected $table = 'nominas';

    protected $fillable = [
        'empleado_id',
        'lugar',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'horas_trabajadas',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}