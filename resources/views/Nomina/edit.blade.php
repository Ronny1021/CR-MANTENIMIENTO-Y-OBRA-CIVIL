@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Registro de Nómina</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('nomina.update', $nomina->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="empleado" class="form-label">Empleado</label>
            <input type="text" name="empleado" class="form-control" value="{{ $nomina->empleado }}" required>
        </div>

        <div class="mb-3">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" name="lugar" class="form-control" value="{{ $nomina->lugar }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $nomina->fecha }}" required>
        </div>

        <div class="mb-3">
            <label for="hora_entrada" class="form-label">Hora de entrada</label>
            <input type="time" name="hora_entrada" class="form-control" value="{{ $nomina->hora_entrada }}" required>
        </div>

        <div class="mb-3">
            <label for="hora_salida" class="form-label">Hora de salida</label>
            <input type="time" name="hora_salida" class="form-control" value="{{ $nomina->hora_salida }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection