<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nomina;
use Carbon\Carbon;

class NominaController extends Controller
{
    public function index()
    {
        $nominas = Nomina::orderBy('fecha', 'desc')->get();
        return view('nomina.index', compact('nominas'));
    }

    public function create()
    {
        return view('nomina.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado' => 'required|string|max:255',
            'lugar' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ]);

        $entrada = Carbon::createFromFormat('H:i', $request->hora_entrada);
        $salida = Carbon::createFromFormat('H:i', $request->hora_salida);
        $horas = $salida->diffInMinutes($entrada) / 60;

        Nomina::create([
            'empleado' => $request->empleado,
            'lugar' => $request->lugar,
            'fecha' => $request->fecha,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'horas_trabajadas' => round($horas, 2),
        ]);

        return redirect()->route('nomina.index')->with('success', 'Registro guardado correctamente');
    }
}