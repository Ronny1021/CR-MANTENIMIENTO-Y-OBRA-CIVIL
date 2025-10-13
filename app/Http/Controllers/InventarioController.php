<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventarioController extends Controller
{
    /**
     * Muestra la lista paginada de ítems del inventario.
     */
    public function index()
    {
        $datos['inventario'] = Inventario::paginate(5);
        return view('inventario.index', $datos);
    }

    /**
     * Muestra el formulario para crear un nuevo ítem.
     */
    public function create()
    {
        $item = new Inventario(); // objeto vacío para evitar errores en la vista
        return view('inventario.create', compact('item'));
    }

    /**
     * Guarda un nuevo ítem en la base de datos.
     */
    public function store(Request $request)
    {
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
            'required'         => 'El campo :attribute es obligatorio.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min'     => 'La cantidad debe ser al menos 1.',
            'disponibilidad.in'=> 'La disponibilidad debe ser Disponible, En uso o Dañado.',
            'fecha_registro.date' => 'La fecha debe tener un formato válido.',
        ];

        $this->validate($request, $campos, $mensajes);

        $datosItem = $request->except('_token');

        Inventario::create($datosItem);

        return redirect('inventario')->with('mensaje', 'Ítem registrado con éxito');
    }

    /**
     * Muestra los detalles de un ítem específico (no implementado).
     */
    public function show(Inventario $item)
    {
        // Método disponible para futuras funcionalidades
    }

    /**
     * Muestra el formulario para editar un ítem existente.
     */
    public function edit($id)
    {
        $item = Inventario::findOrFail($id);
        return view('inventario.edit', compact('item'));
    }

    /**
     * Actualiza los datos de un ítem en la base de datos.
     */
    public function update(Request $request, $id)
    {
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
            'required'         => 'El campo :attribute es obligatorio.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min'     => 'La cantidad debe ser al menos 1.',
            'disponibilidad.in'=> 'La disponibilidad debe ser Disponible, En uso o Dañado.',
            'fecha_registro.date' => 'La fecha debe tener un formato válido.',
        ];

        $this->validate($request, $campos, $mensajes);

        $datosItem = $request->except(['_token', '_method']);

        Inventario::where('id', '=', $id)->update($datosItem);

        return redirect('inventario')->with('mensaje', 'Ítem actualizado con éxito');
    }

    /**
     * Elimina un ítem del inventario.
     */
    public function destroy($id)
    {
        Inventario::destroy($id);
        return redirect('inventario')->with('mensaje', 'Ítem eliminado');
    }
}