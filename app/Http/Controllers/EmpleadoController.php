<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Muestra la lista paginada de empleados.
     */
    public function index()
    {
        $datos['empleados'] = Empleado::paginate(1);
        return view('empleado.index', $datos);
    }

    /**
     * Muestra el formulario para crear un nuevo empleado.
     */
    public function create()
    {
        $empleado = new Empleado(); // crea un objeto vacío para evitar errores en la vista
        return view('empleado.create', compact('empleado'));
    }

    /**
     * Guarda un nuevo empleado en la base de datos.
     */
public function store(Request $request)
{
    // Reglas de validación con verificación de duplicados
    $campos = [
        'Nombres'   => 'required|string|max:100',
        'Apellidos' => 'required|string|max:100',
        'Documento' => 'required|string|max:100|unique:empleados,Documento',
        'Correo'    => 'required|email|max:100|unique:empleados,Correo',
        'rol'       => 'required|string|max:100',
        'edad'      => 'required|integer|min:0|max:100',
        'Foto'      => 'required|image|mimes:jpg,png,jpeg|max:10000',
    ];

    // Mensajes personalizados en español
    $mensajes = [
        'required'         => 'El campo :attribute es obligatorio.',
        'Documento.unique' => 'Ya existe un empleado con este documento.',
        'Correo.unique'    => 'Ya existe un empleado con este correo.',
        'Foto.required'    => 'La foto es obligatoria.',
        'Foto.image'       => 'La foto debe ser una imagen válida.',
        'Foto.mimes'       => 'La foto debe estar en formato JPG, PNG o JPEG.',
        'Correo.email'     => 'El correo debe tener un formato válido.',
        'edad.integer'     => 'La edad debe ser un número entero.',
        'edad.min'         => 'La edad no puede ser negativa.',
        'edad.max'         => 'La edad no puede superar los 100 años.',
    ];

    // Validar los datos
    $this->validate($request, $campos, $mensajes);

    // Extraer datos del formulario
    $datosEmpleado = $request->except('_token');

    // Procesar la imagen si se subió
    if ($request->hasFile('Foto')) {
        $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
    }

    // Guardar el empleado en la base de datos
    Empleado::create($datosEmpleado);

    // Redirigir con mensaje de éxito
    return redirect('empleado')->with('mensaje', 'Empleado agregado con éxito');
}

    /**
     * Muestra los detalles de un empleado específico (no implementado).
     */
    public function show(Empleado $empleado)
    {
        // Método disponible para futuras funcionalidades
    }

    /**
     * Muestra el formulario para editar un empleado existente.
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Actualiza los datos de un empleado en la base de datos.
     */
public function update(Request $request, $id)
{
    // Reglas de validación con exclusión del ID actual
    $campos = [
        'Nombres'   => 'required|string|max:100',
        'Apellidos' => 'required|string|max:100',
        'Documento' => 'required|string|max:100|unique:empleados,Documento,' . $id,
        'Correo'    => 'required|email|max:100|unique:empleados,Correo,' . $id,
        'rol'       => 'required|string|max:100',
        'edad'      => 'required|integer|min:0|max:100',
        'Foto'      => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
    ];

    // Mensajes personalizados en español
    $mensajes = [
        'required'         => 'El campo :attribute es obligatorio.',
        'Documento.unique' => 'Otro empleado ya tiene este documento.',
        'Correo.unique'    => 'Otro empleado ya tiene este correo.',
        'Foto.image'       => 'La foto debe ser una imagen válida.',
        'Foto.mimes'       => 'La foto debe estar en formato JPG, PNG o JPEG.',
        'Correo.email'     => 'El correo debe tener un formato válido.',
        'edad.integer'     => 'La edad debe ser un número entero.',
        'edad.min'         => 'La edad no puede ser negativa.',
        'edad.max'         => 'La edad no puede superar los 100 años.',
    ];

    // Validar los datos
    $this->validate($request, $campos, $mensajes);

    // Extraer datos del formulario
    $datosEmpleado = $request->except(['_token', '_method']);

    // Si se sube una nueva foto, elimina la anterior y guarda la nueva
    if ($request->hasFile('Foto')) {
        $empleado = Empleado::findOrFail($id);
        Storage::delete('public/' . $empleado->Foto);
        $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
    }

    // Actualiza el registro en la base de datos
    Empleado::where('id', '=', $id)->update($datosEmpleado);

    // Redirige al listado con mensaje de éxito
    return redirect('empleado')->with('mensaje', 'Empleado actualizado con éxito');
}

    /**
     * Elimina un empleado de la base de datos.
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);

        // Si tiene una foto, la elimina del almacenamiento
        if (Storage::delete('public/' . $empleado->Foto)) {
            Empleado::destroy($id);
        }

        // Redirige al listado con un mensaje de confirmación
        return redirect('empleado')->with('mensaje', 'Empleado borrado');
    }
}
