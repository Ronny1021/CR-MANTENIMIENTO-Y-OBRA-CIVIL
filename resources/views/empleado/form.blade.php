<<<<<<< HEAD
<h1 class="mb-4">{{ $modo }} Empleado</h1>
=======
{{-- 
    Este formulario se utiliza tanto para crear como para editar empleados.
    La variable $modo se usa para cambiar dinámicamente entre "Agregar" y "Editar".
--}}

<h1 class="mb-4">{{ $modo }} Empleado</h1>

{{-- 
    Si hay errores de validación (por ejemplo, campos vacíos o formato incorrecto),
    Laravel los guarda en la variable $errors. 
    Este bloque los muestra dentro de una alerta.
--}}
>>>>>>> f97301ce5b5194e465aa077e392a050b7c8bdc17
@if (count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
<<<<<<< HEAD
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>

    </div>

    @endif

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="Nombres" class="form-label">Nombre</label>
            <input type="text" name="Nombres" class="form-control"
                value="{{ isset($empleado->Nombres) ? $empleado->Nombres :old('Nombres') }}" id="Nombres" >
        </div>

        <div class="col-md-6">
            <label for="Apellidos" class="form-label">Apellidos</label>
            <input type="text" name="Apellidos" class="form-control"
                value="{{ isset($empleado->Apellidos) ? $empleado->Apellidos : old('Apellidos')  }}"id="Apellidos">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="Documento" class="form-label">Documento</label>
            <input type="text" name="Documento"  class="form-control"
                value="{{ isset($empleado->Documento) ? $empleado->Documento : old('Documento') }}" id="Documento">
        </div>

        <div class="col-md-6">
            <label for="Correo" class="form-label">Correo</label>
            <input type="email" name="Correo"  class="form-control"
                value="{{ isset($empleado->Correo) ? $empleado->Correo :old('Correo') }}" id="Correo">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="rol" class="form-label">Rol</label>
            <input type="text" name="rol" class="form-control"
                value="{{ isset($empleado->rol) ? $empleado->rol : old('rol')  }}" id="rol" >
        </div>

        <div class="col-md-6">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" name="edad" id="edad" class="form-control"
                value="{{ isset($empleado->edad) ? $empleado->edad :old('edad')  }}" >
        </div>
    </div>

    <div class="mb-3">
        <label for="Foto" class="form-label">Foto</label><br>
        @if (isset($empleado->Foto))
            <img src="{{ asset('storage/' . $empleado->Foto) }}" width="150" class="rounded mb-2" alt="Foto actual">
        @endif
        <input type="file" name="Foto" id="Foto" class="form-control">
    </div>

    <div class="d-flex justify-content-between mt-4">
        <input type="submit" value="{{ $modo }} datos" class="btn btn-success">
        <a href="{{ url('empleado/') }}" class="btn btn-secondary">Regresar</a>
    </div>

    formulario que tendra los datos en comun con create y edit
=======
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{--  PRIMERA FILA: NOMBRES Y APELLIDOS  --}}

<div class="row mb-3">
    <div class="col-md-6">
        <label for="Nombres" class="form-label">Nombre</label>
        {{-- 
            Si el empleado ya existe, muestra su nombre.
            Si no, conserva el valor anterior con old() en caso de error.
        --}}
        <input type="text" name="Nombres" class="form-control"
            value="{{ isset($empleado->Nombres) ? $empleado->Nombres : old('Nombres') }}" id="Nombres">
    </div>

    <div class="col-md-6">
        <label for="Apellidos" class="form-label">Apellidos</label>
        <input type="text" name="Apellidos" class="form-control"
            value="{{ isset($empleado->Apellidos) ? $empleado->Apellidos : old('Apellidos') }}" id="Apellidos">
    </div>
</div>


{{--  SEGUNDA FILA: DOCUMENTO Y CORREO  --}}

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


{{--  TERCERA FILA: ROL Y EDAD  --}}

<div class="row mb-3">
    <div class="col-md-6">
        <label for="rol" class="form-label">Rol</label>
        {{-- Campo para el cargo o puesto del empleado --}}
        <input type="text" name="rol" class="form-control"
            value="{{ isset($empleado->rol) ? $empleado->rol : old('rol') }}" id="rol">
    </div>

    <div class="col-md-6">
        <label for="edad" class="form-label">Edad</label>
        <input type="number" name="edad" id="edad" class="form-control"
            value="{{ isset($empleado->edad) ? $empleado->edad : old('edad') }}">
    </div>
</div>


{{--  FOTO DEL EMPLEADO  --}}

<div class="mb-3">
    <label for="Foto" class="form-label">Foto</label><br>

    {{-- 
        Si el empleado ya tiene una foto guardada, la muestra como vista previa.
        Usa asset('storage/...') para acceder al archivo dentro de storage/app/public.
    --}}
    @if (isset($empleado->Foto))
        <img src="{{ asset('storage/' . $empleado->Foto) }}" width="150" class="rounded mb-2" alt="Foto actual">
    @endif

    {{-- Campo para subir o reemplazar la foto --}}
    <input type="file" name="Foto" id="Foto" class="form-control">
</div>


{{--  BOTONES DE ACCIÓN  --}}

<div class="d-flex justify-content-between mt-4">
    {{-- 
        Botón principal que envía el formulario.
        El texto cambia según el modo: "Agregar datos" o "Editar datos".
    --}}
    <input type="submit" value="{{ $modo }} datos" class="btn btn-success">

    {{-- Botón secundario para volver al listado de empleados --}}
    <a href="{{ url('empleado/') }}" class="btn btn-secondary">Regresar</a>
</div>
>>>>>>> f97301ce5b5194e465aa077e392a050b7c8bdc17
