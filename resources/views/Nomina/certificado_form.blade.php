@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Generar Certificado Laboral</h2>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario para seleccionar empleado --}}
    <form action="{{ route('certificados.pdf') }}" method="POST" target="_blank">
        @csrf

        <div class="mb-3">
            <label for="empleado_id" class="form-label">Seleccione un empleado</label>
            <select name="empleado_id" id="empleado_id" class="form-control" required>
                <option value="">-- Seleccione --</option>
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado->id }}">
                        {{ $empleado->Nombres }} {{ $empleado->Apellidos }} ({{ $empleado->Documento }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Generar Certificado</button>
    </form>
         <div class="login-image">
  <img src="{{ asset('images/imagefooter (2).png') }}" alt="Imagen decorativa">
</div>
@endsection