@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Nómina</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('nomina.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="empleado" class="form-label">Empleado</label>
            <input type="text" name="empleado" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" name="lugar" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="hora_entrada" class="form-label">Hora de entrada</label>
            <input type="time" name="hora_entrada" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="hora_salida" class="form-label">Hora de salida</label>
            <input type="time" name="hora_salida" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
@endsection