@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Registros de asistencia</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- Ventana que muestra el nuevo registro de asistencia  --}}

        <a href="{{ route('nomina.create') }}" class="btn btn-success mb-3">Nuevo Registro</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empleado</th>
                    <th>Lugar</th>
                    <th>Fecha</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Horas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nominas as $nomina)
                    <tr>
                        <td>{{ $nomina->id }}</td>
                        <td>
                            @if ($nomina->empleado && $nomina->empleado->Foto)
                                <img src="{{ asset('storage/' . $nomina->empleado->Foto) }}"
                                    alt="Foto de {{ $nomina->empleado->Nombres }}" width="50" height="50"
                                    style="object-fit: cover; border-radius: 50%; margin-bottom: 5px;">
                            @endif
                            <div>
                                <strong>{{ $nomina->empleado->Nombres }} {{ $nomina->empleado->Apellidos }}</strong><br>
                                <small>{{ $nomina->empleado->Documento }}</small>
                            </div>
                        </td>
                        <td>{{ $nomina->lugar }}</td>
                        <td>{{ \Carbon\Carbon::parse($nomina->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $nomina->hora_entrada }}</td>
                        <td>{{ $nomina->hora_salida }}</td>
                        <td>{{ $nomina->horas_trabajadas }}</td>
                        <td>
                            <a href="{{ route('nomina.edit', $nomina->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('nomina.destroy', $nomina->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar este registro?')">Eliminar</button>
                            </form>

                            <div class="login-image">
                                <img src="{{ asset('images/imagefooter (2).png') }}" alt="Imagen decorativa">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Contenido de la ventana asistencia  --}}
    </div>
@endsection
