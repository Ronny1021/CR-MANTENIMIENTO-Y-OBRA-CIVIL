<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarioController extends Controller
{
    public function index(Request $request) {
        $query = Inventario::query();

        if ($request->filled('disponibilidad')) {
            $query->where('disponibilidad', $request->disponibilidad);
        }

        $inventario = $query->paginate(5);
        return view('inventario.index', compact('inventario'));
    }

    public function create() {
        $item = new Inventario();
        return view('inventario.create', compact('item'));
    }

    public function store(Request $request) {
        $campos = [
            'nombre'           => 'required|string|max:100',
            'tipo_herramienta' => 'required|string|max:100',
            'categoria'        => 'nullable|string|max:100',
            'unidad_medida'    => 'required|string|max:50',
            'cantidad'         => 'required|integer|min:1',
            'estado'           => 'nullable|string|max:100',
            'disponibilidad'   => 'required|in:Disponible,En uso,Dañado',
            'fecha_registro'   => 'required|date',
        ];

        $mensajes = [
            'required'            => 'El campo :attribute es obligatorio.',
            'cantidad.integer'    => 'La cantidad debe ser un número entero.',
            'cantidad.min'        => 'La cantidad debe ser al menos 1.',
            'disponibilidad.in'   => 'La disponibilidad debe ser Disponible, En uso o Dañado.',
            'fecha_registro.date' => 'La fecha debe tener un formato válido.',
        ];

        $this->validate($request, $campos, $mensajes);

        $datosItem = $request->except('_token');
        $datosItem['fecha_registro'] = date('Y-m-d H:i:s', strtotime($request->fecha_registro));

        Inventario::create($datosItem);
        return redirect('inventario')->with('mensaje', 'Ítem registrado con éxito');
    }

    public function show(Inventario $item) {
        // Placeholder
    }

    public function edit($id) {
        $item = Inventario::findOrFail($id);
        return view('inventario.edit', compact('item'));
    }

    public function update(Request $request, $id) {
        $campos = [
            'nombre'           => 'required|string|max:100',
            'tipo_herramienta' => 'required|string|max:100',
            'categoria'        => 'nullable|string|max:100',
            'unidad_medida'    => 'required|string|max:50',
            'cantidad'         => 'required|integer|min:1',
            'estado'           => 'nullable|string|max:100',
            'disponibilidad'   => 'required|in:Disponible,En uso,Dañado',
            'fecha_registro'   => 'required|date',
        ];

        $mensajes = [
            'required'            => 'El campo :attribute es obligatorio.',
            'cantidad.integer'    => 'La cantidad debe ser un número entero.',
            'cantidad.min'        => 'La cantidad debe ser al menos 1.',
            'disponibilidad.in'   => 'La disponibilidad debe ser Disponible, En uso o Dañado.',
            'fecha_registro.date' => 'La fecha debe tener un formato válido.',
        ];

        $this->validate($request, $campos, $mensajes);

        $datosItem = $request->except(['_token', '_method']);
        $datosItem['fecha_registro'] = date('Y-m-d H:i:s', strtotime($request->fecha_registro));

        Inventario::where('id', '=', $id)->update($datosItem);
    }


public function exportarPDF(Request $request)
{
    $query = Inventario::query();


    $inventario = $query->get() ?? collect(); // ← garantiza que no sea null

    return Pdf::loadView('inventario.pdf', compact('inventario'))->stream('inventario.pdf');
}

}