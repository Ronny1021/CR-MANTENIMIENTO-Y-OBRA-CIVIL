<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nomina;
use App\Models\Empleado;
use Carbon\Carbon;

class NominaController extends Controller
{
    public function index()
    {
        $nominas = Nomina::with('empleado')->orderBy('fecha', 'desc')->get();
        return view('nomina.index', compact('nominas'));
    }

    public function create()
    {
        $empleados = Empleado::orderBy('Nombres')->get();
        return view('nomina.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $mensajes = [
            'required' => 'El campo :attribute es obligatorio.',
            'date' => 'El campo :attribute debe tener una fecha válida.',
            'date_format' => 'El campo :attribute debe tener el formato HH:mm.',
            'after' => 'La hora de salida debe ser posterior a la hora de entrada.',
            'exists' => 'El empleado seleccionado no es válido.',
        ];

        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'lugar' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ], $mensajes);

        $entrada = Carbon::createFromFormat('H:i', $request->hora_entrada);
        $salida = Carbon::createFromFormat('H:i', $request->hora_salida);
        $horas = $salida->diffInMinutes($entrada) / 60;

        Nomina::create([
            'empleado_id' => $request->empleado_id,
            'lugar' => $request->lugar,
            'fecha' => $request->fecha,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'horas_trabajadas' => round($horas, 2),
        ]);

        return redirect()->route('nomina.index')->with('success', 'Registro guardado correctamente');
    }

    public function edit($id)
    {
        $nomina = Nomina::findOrFail($id);
        $empleados = Empleado::orderBy('Nombres')->get();

        return view('nomina.edit', compact('nomina', 'empleados'));
    }

    public function update(Request $request, $id)
    {
        $mensajes = [
            'required' => 'El campo :attribute es obligatorio.',
            'date' => 'El campo :attribute debe tener una fecha válida.',
            'date_format' => 'El campo :attribute entrada debe de ser inferior a la de salida.',
            'after' => 'La hora de salida debe ser posterior a la hora de entrada.',
            'exists' => 'El empleado seleccionado no es válido.',
        ];

        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'lugar' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ], $mensajes);

        $entrada = Carbon::createFromFormat('H:i', $request->hora_entrada);
        $salida = Carbon::createFromFormat('H:i', $request->hora_salida);
        $horas = $salida->diffInMinutes($entrada) / 60;

        $nomina = Nomina::findOrFail($id);
        $nomina->update([
            'empleado_id' => $request->empleado_id,
            'lugar' => $request->lugar,
            'fecha' => $request->fecha,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'horas_trabajadas' => round($horas, 2),
        ]);

        return redirect()->route('nomina.index')->with('success', 'Registro actualizado correctamente');
    }
}
