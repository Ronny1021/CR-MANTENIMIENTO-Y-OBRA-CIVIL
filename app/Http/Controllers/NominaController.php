<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nomina;
use App\Models\Empleado;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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

        if ($salida->lt($entrada)) {
            $salida->addDay(); // Turno nocturno
        }

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

        if ($salida->lt($entrada)) {
            $salida->addDay(); // Turno nocturno
        }

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

    public function certificadoForm()
    {
        $empleados = Empleado::orderBy('Nombres')->get();
        return view('nomina.certificado_form', compact('empleados'));
    }

    public function generarCertificadoPDF(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
        ]);

        $empleado = Empleado::findOrFail($request->empleado_id);
        $totalHoras = Nomina::where('empleado_id', $empleado->id)->sum('horas_trabajadas');
        $fechaActual = now()->translatedFormat('d \d\e F \d\e Y');

        $data = [
            'empleado' => $empleado,
            'totalHoras' => $totalHoras,
            'fechaActual' => $fechaActual,
            'empresa' => 'CR MANTENIMIENTO Y OBRACIVIL',
        ];

        $pdf = Pdf::loadView('nomina.certificado_pdf', $data);
        return $pdf->stream('certificado_laboral.pdf');
    }



public function desprendibleForm()
    {
        $empleados = Empleado::orderBy('Nombres')->get();
        return view('nomina.desprendible_form', compact('empleados'));
    }

    public function generardesprendible(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
        ]);

        $empleado = Empleado::findOrFail($request->empleado_id);
        $totalHoras = Nomina::where('empleado_id', $empleado->id)->sum('horas_trabajadas');
        $fechaActual = now()->translatedFormat('d \d\e F \d\e Y');

        $data = [
            'empleado' => $empleado,
            'totalHoras' => $totalHoras,
            'fechaActual' => $fechaActual,
            'empresa' => 'CR MANTENIMIENTO Y OBRACIVIL',
        ];

        $pdf = Pdf::loadView('nomina.desprendible_pdf', $data);
        return $pdf->stream('certificado_laboral.pdf');
    }

}