<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nomina;
use App\Models\Empleado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class NominaController extends Controller
{
    /**
     * Muestra el listado de registros de nómina.
     */
    public function index()
    {
        $nominas = Nomina::with('empleado')->orderBy('fecha', 'desc')->get();
        return view('nomina.index', compact('nominas'));
    }

    /**
     * Muestra el formulario para crear un nuevo registro de nómina.
     */
    public function create()
    {
        // Se asume que el campo es 'Nombres' en tu modelo Empleado.
        $empleados = Empleado::orderBy('Nombres')->get();
        return view('nomina.create', compact('empleados'));
    }

    /**
     * Guarda un nuevo registro de nómina.
     */
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

    /**
     * Muestra el formulario para editar un registro de nómina.
     */
    public function edit($id)
    {
        $nomina = Nomina::findOrFail($id);
        $empleados = Empleado::orderBy('Nombres')->get();

        return view('nomina.edit', compact('nomina', 'empleados'));
    }

    /**
     * Actualiza un registro de nómina existente.
     */
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

    /**
     * Muestra el formulario para generar el certificado laboral.
     */
    public function certificadoForm()
    {
        $empleados = Empleado::orderBy('Nombres')->get();
        return view('nomina.certificado_form', compact('empleados'));
    }

    /**
     * Genera el Certificado Laboral en formato PDF.
     */
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


    /**
     * Muestra el formulario para generar el desprendible de nómina.
     */
    public function desprendibleForm()
    {
        // Se asume que el campo es 'Nombres' en tu modelo Empleado.
        $empleados = Empleado::orderBy('Nombres')->get();
        return view('nomina.desprendible_form', compact('empleados'));
    }

    /**
     * Genera el Desprendible de Nómina en formato PDF.
     * * CORRECCIÓN: Se cambió el nombre del método de 'generardesprendible' a 
     * 'generarDesprendiblePDF' para seguir convenciones de Laravel y coincidir 
     * con la ruta.
     */
    public function generarDesprendiblePDF(Request $request)
    {
        $mensajes = [
            'required' => 'El campo :attribute es obligatorio.',
            'exists' => 'El empleado seleccionado no es válido.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.'
        ];

        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ], $mensajes);

        $empleado = Empleado::findOrFail($request->empleado_id);
        $usuario = Auth::user();

        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;

        $registrosNomina = Nomina::where('empleado_id', $empleado->id)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();

        $desprendible = [
            'empresa' => [
                'nombre' => 'CR MANTENIMIENTO Y OBRACIVIL',
                'nit' => '256.820.100-2',
                'direccion' => 'Carrera 1 # 1-1, Cali/Valle Del Cauca',
            ],
            'empleado' => [
                'nombres' => $empleado->Nombres,
                'cedula' => $empleado->Cedula,
                'cargo' => $empleado->Cargo,
                'salario_base' => $empleado->salario_basico,
                'banco' => $empleado->Banco,
                'cuenta' => $empleado->Cuenta,
            ],
            'periodo' => [
                'inicio' => $fechaInicio,
                'fin' => $fechaFin,
            ],
            'generado_por' => $usuario->name ?? 'Usuario no identificado',
            'fecha_generacion' => Carbon::now()->format('d/m/Y H:i'),

            'devengos' => [
                ['concepto' => 'Salario Básico (Periodo)', 'valor' => 750000],
                ['concepto' => 'Horas Extra Nocturnas', 'valor' => 125000],
            ],
            'deducciones' => [
                ['concepto' => 'Salud', 'valor' => 30000],
                ['concepto' => 'Pensión', 'valor' => 30000],
            ],
        ];

        $pdf = Pdf::loadView('nomina.desprendible_pdf', compact('desprendible'));
        return $pdf->stream('desprendible_nomina_' . $empleado->id . '_' . Carbon::now()->format('Ymd') . '.pdf');
    }
}
