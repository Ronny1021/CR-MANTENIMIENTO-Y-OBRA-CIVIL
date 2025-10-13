<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    public function index() {
        $datos['empleados'] = Empleado::paginate(1);
        return view('empleado.index', $datos);
    }

    public function create() {
        $empleado = new Empleado();
        return view('empleado.create', compact('empleado'));
    }

    public function store(Request $request) {
        $campos = [
            'Nombres'   => 'required|string|max:100',
            'Apellidos' => 'required|string|max:100',
            'Documento' => 'required|string|max:100|unique:empleados,Documento',
            'Correo'    => 'required|email|max:100|unique:empleados,Correo',
            'rol'       => 'required|string|max:100',
            'edad'      => 'required|integer|min:0|max:100',
            'Foto'      => 'required|image|mimes:jpg,png,jpeg|max:10000',
        ];

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

        $this->validate($request, $campos, $mensajes);

        $datosEmpleado = $request->except('_token');
        if ($request->hasFile('Foto')) {
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        Empleado::create($datosEmpleado);
        return redirect('empleado')->with('mensaje', 'Empleado agregado con éxito');
    }

    public function show(Empleado $empleado) {
        // Placeholder
    }

    public function edit($id) {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    public function update(Request $request, $id) {
        $campos = [
            'Nombres'   => 'required|string|max:100',
            'Apellidos' => 'required|string|max:100',
            'Documento' => 'required|string|max:100|unique:empleados,Documento,' . $id,
            'Correo'    => 'required|email|max:100|unique:empleados,Correo,' . $id,
            'rol'       => 'required|string|max:100',
            'edad'      => 'required|integer|min:0|max:100',
            'Foto'      => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
        ];

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

        $this->validate($request, $campos, $mensajes);
        $datosEmpleado = $request->except(['_token', '_method']);

        if ($request->hasFile('Foto')) {
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/' . $empleado->Foto);
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        Empleado::where('id', '=', $id)->update($datosEmpleado);
        return redirect('empleado')->with('mensaje', 'Empleado actualizado con éxito');
    }

    public function destroy($id) {
        $empleado = Empleado::findOrFail($id);
        if (Storage::delete('public/' . $empleado->Foto)) {
            Empleado::destroy($id);
        }
        return redirect('empleado')->with('mensaje', 'Empleado borrado');
    }
}
