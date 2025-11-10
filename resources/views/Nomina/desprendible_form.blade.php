@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8 bg-gradient-to-br from-gray-50 to-white shadow-lg rounded-xl min-h-screen">
    <h1 class="text-4xl font-extrabold text-indigo-700 mb-8 border-b-4 border-indigo-500 pb-3 tracking-wide">
        Generar Desprendible de Nómina
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 shadow-md animate-pulse" role="alert">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                     d="M6 18L18 6M6 6l12 12"/></svg>
                <strong class="font-bold">¡Error de Validación!</strong>
            </div>
            <p class="mt-2">Por favor revisa los campos:</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('desprendible.pdf') }}" method="POST"
          class="bg-white p-8 md:p-10 rounded-2xl shadow-xl border border-gray-300 space-y-6">
        @csrf

        <div>
            <label for="empleado_id" class="block text-gray-700 font-semibold mb-2 text-lg">Seleccione un empleado</label>
            <select name="empleado_id" id="empleado_id"
                    class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 bg-white shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition duration-200"
                    required>
                <option value="">-- Seleccione --</option>
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                        {{ $empleado->Nombres }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fecha_inicio" class="block text-gray-700 font-semibold mb-2 text-lg">Fecha de Inicio del Periodo</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}"
                       class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 bg-white shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition duration-200"
                       required>
            </div>

            <div>
                <label for="fecha_fin" class="block text-gray-700 font-semibold mb-2 text-lg">Fecha de Fin del Periodo</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}"
                       class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 bg-white shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition duration-200"
                       required>
            </div>
        </div>

        <div class="flex justify-center pt-4">
            <button type="submit"
                    class="px-10 py-4 bg-indigo-600 text-white font-bold text-lg rounded-full shadow-md
                           hover:bg-indigo-700 hover:scale-105 transform transition duration-300 ease-in-out
                           focus:outline-none focus:ring-4 focus:ring-indigo-400 focus:ring-opacity-50">
                Generar Desprendible
            </button>
        </div>
    </form>
</div>
@endsection