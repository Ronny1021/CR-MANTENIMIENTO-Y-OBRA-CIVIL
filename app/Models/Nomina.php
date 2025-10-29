<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    protected $table = 'nominas'; // Asegura que no intente buscar 'nominees'
    protected $fillable = [
        'empleado',
        'lugar',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'horas_trabajadas',
    ];
}