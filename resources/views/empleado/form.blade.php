{{-- Título dinámico según el modo (Agregar o Editar) --}}
<h1 class="mb-4">{{ $modo }} Empleado</h1>

{{-- Si hay errores de validación, Laravel los guarda en $errors. Este bloque los muestra en una alerta. --}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- PRIMERA FILA: Nombres y Apellidos --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label for="Nombres" class="form-label">Nombre</label>
        <input type="text" name="Nombres" class="form-control"
            value="{{ isset($empleado->Nombres) ? $empleado->Nombres : old('Nombres') }}" id="Nombres">
    </div>
    <div class="col-md-6">
        <label for="Apellidos" class="form-label">Apellidos</label>
        <input type="text" name="Apellidos" class="form-control"
            value="{{ isset($empleado->Apellidos) ? $empleado->Apellidos : old('Apellidos') }}" id="Apellidos">
    </div>
</div>

{{-- SEGUNDA FILA: Documento y Correo --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label for="Documento" class="form-label">Documento</label>
        <input type="text" name="Documento" class="form-control"
            value="{{ isset($empleado->Documento) ? $empleado->Documento : old('Documento') }}" id="Documento">
    </div>
    <div class="col-md-6">
        <label for="Correo" class="form-label">Correo</label>
        <input type="email" name="Correo" class="form-control"
            value="{{ isset($empleado->Correo) ? $empleado->Correo : old('Correo') }}" id="Correo">
    </div>
</div>

{{-- TERCERA FILA: Rol y Edad --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label for="rol" class="form-label">Rol</label>
        <input type="text" name="rol" class="form-control"
            value="{{ isset($empleado->rol) ? $empleado->rol : old('rol') }}" id="rol">
    </div>
    <div class="col-md-6">
        <label for="edad" class="form-label">Edad</label>
        <input type="number" name="edad" id="edad" class="form-control"
            value="{{ isset($empleado->edad) ? $empleado->edad : old('edad') }}">
    </div>
</div>

{{-- FOTO DEL EMPLEADO --}}
<div class="mb-3">
    <label for="Foto" class="form-label">Foto</label><br>
    @if (isset($empleado->Foto))
        <img src="{{ asset('storage/' . $empleado->Foto) }}" width="150" class="rounded mb-2" alt="Foto actual">
    @endif
    <input type="file" name="Foto" id="Foto" class="form-control">
</div>

{{-- BOTONES DE ACCIÓN --}}
<div class="d-flex justify-content-between mt-4">
    <input type="submit" value="{{ $modo }} datos" class="btn btn-success">
    <a href="{{ url('empleado/') }}" class="btn btn-secondary">Regresar</a>
</div>

