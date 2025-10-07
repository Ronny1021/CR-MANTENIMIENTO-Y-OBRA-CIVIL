{{-- Extiende el layout principal de la aplicación --}}
@extends('layouts.app')

{{-- Sección principal de contenido --}}
@section('content')
<div class="container">

    {{-- Verifica si hay un mensaje en la sesión y lo muestra como alerta --}}
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('mensaje') }}
        </div>
    @endif

    {{-- Botón para ir al formulario de creación de un nuevo empleado --}}
    <a href="{{url('empleado/create')}}" class="btn btn-success">Registro Nuevo empleado </a>
<br/>
<br/>
    {{-- Tabla que muestra la lista de empleados --}}
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Documento</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Edad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Recorre la colección de empleados y muestra cada uno en una fila --}}
            @foreach ($empleados as $empleado)
                <tr>
                    {{-- ID del empleado --}}
                    <td class="text-center">{{ $empleado->id }}</td>

                    {{-- Foto del empleado cargada desde el almacenamiento --}}
                    <td class="text-center">
                        {{ asset(Foto) }}"
                             width="130" height="170"
                             class="rounded shadow-sm border border-secondary"
                             style="object-fit: cover;"
                             alt="Foto del empleado">
                    </td>

                    {{-- Datos personales del empleado --}}
                    <td>{{ $empleado->Nombres }}</td>
                    <td>{{ $empleado->Apellidos }}</td>
                    <td>{{ $empleado->Documento }}</td>
                    <td>{{ $empleado->Correo }}</td>
                    <td>{{ $empleado->rol }}</td>
                    <td class="text-center">{{ $empleado->edad }}</td>

                    {{-- Botones de acción: editar y eliminar --}}
                    <td class="text-center">
                        {{-- Botón para editar el empleado --}}
                        {{ url(id . '/edit') }}"
                           class="btn btn-sm btn-outline-primary me-1">Editar</a>

                        {{-- Formulario para eliminar el empleado --}}
                        <form action="{{ url('/empleado/' . $        method="POST"
                              class="d-inline"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <input type="submit"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('¿Quieres borrar este empleado?')"
                                   value="Borrar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

        {{-- Pie de tabla con el total de empleados --}}
        <tfoot>
            <tr>
                <td colspan="9" class="text-end text-muted">
                    Total: {{ $empleados->total() }} empleados
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- Enlaces de paginación generados automáticamente por Laravel --}}
    {!! $empleados->links() !!}
</div>
@endsection