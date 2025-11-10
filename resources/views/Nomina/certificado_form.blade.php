@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- El wrapper hereda el fondo animado gracias a @extend body en app.scss -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card login-card mt-5">
                <div class="login-title">Generar Certificado laboral (PDF)</div>
                
                {{-- Formulario que apunta a la ruta de generación de PDF --}}
                 <form action="{{ route('certificados.pdf') }}" method="POST" target="_blank">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="empleado_id" class="form-label">Seleccione un empleado:</label>
                        <select 
                            class="form-select @error('empleado_id') is-invalid @enderror" 
                            id="empleado_id" 
                            name="empleado_id" 
                            required
                        >
                            <option value="">-- Seleccione --</option>
                            {{-- Asegúrate de que $empleados sea una colección pasada desde el controlador --}}
                            @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id }}">
                                    {{ $empleado->Nombres }} {{ $empleado->Apellidos }} ({{ $empleado->Documento }})
                                </option>
                            @endforeach
                        </select>
                        @error('empleado_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Generar Certificado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection