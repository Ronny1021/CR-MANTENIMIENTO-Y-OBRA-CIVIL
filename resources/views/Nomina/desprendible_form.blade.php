{{-- Extiende la plantilla principal de la aplicación --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8 bg-gray-50 min-h-screen">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-8 border-b-2 border-indigo-500 pb-2">Generar Desprendible de Nómina</h1>

    {{-- Contenedor de errores de validación --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 shadow-md" role="alert">
            <strong class="font-bold">¡Error de Validación!</strong>
            <span class="block sm:inline">Por favor revisa los campos:</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de Generación del Desprendible --}}
    {{-- La acción apunta a la ruta POST que ejecuta el método generarDesprendiblePDF --}}
    <form action="{{ route('desprendible.pdf') }}" method="POST" class="bg-white p-6 md:p-10 rounded-xl shadow-2xl border border-gray-200">
        @csrf
        
        <div class="mb-6">
            <label for="empleado_id" class="block text-gray-700 font-semibold mb-2 text-lg">Seleccione un empleado</label>
            <select name="empleado_id" id="empleado_id" 
                    class="w-full border-gray-300 rounded-lg shadow-inner p-3 text-gray-800 
                           focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150" 
                    required>
                <option value="">-- Seleccione --</option>
                @foreach ($empleados as $empleado)
                    {{-- Asumo que tu modelo Empleado tiene un campo 'Nombres' y 'id' --}}
                    <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                        {{ $empleado->Nombres }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Campo de Fecha de Inicio --}}
            <div>
                <label for="fecha_inicio" class="block text-gray-700 font-semibold mb-2 text-lg">Fecha de Inicio del Periodo</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" 
                       class="w-full border-gray-300 rounded-lg shadow-inner p-3 text-gray-800 
                              focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150" 
                       required>
            </div>

            {{-- Campo de Fecha Fin --}}
            <div>
                <label for="fecha_fin" class="block text-gray-700 font-semibold mb-2 text-lg">Fecha de Fin del Periodo</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" 
                       class="w-full border-gray-300 rounded-lg shadow-inner p-3 text-gray-800 
                              focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150" 
                       required>
            </div>
        </div>

        <div class="flex justify-center">
            <button type="submit" 
                    class="px-8 py-3 bg-indigo-600 text-white font-bold text-lg rounded-full shadow-lg hover:bg-indigo-700 
                           transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                Generar Desprendible
            </button>
        </div>
    </form>
</div>
@endsection