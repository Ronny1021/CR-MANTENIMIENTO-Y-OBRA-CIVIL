@extends('layouts.app')
 
@section('content')
<div class="container">
 
 
 
@if(@Session::has('mensaje'))
   <div class="alert alert-success" role="alert">
    {{Session::get('mensaje')}}
@endif
 
   </div>
 
 
<a href="{{url('empleado/create')}}" class="btn btn-success">Registro Nuevo empleado </a>
<br/>
<br/>
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
        @foreach ($empleados as $empleado)
            <tr>
                <td class="text-center">{{ $empleado->id }}</td>
                <td class="text-center">
                    <img class="img-thumbnail img-fluid" src="{{ asset('storage/' . $empleado->Foto) }}"
                         width="130" height="170"
                         class="rounded shadow-sm border border-secondary"
                         style="object-fit: cover;"
                         alt="Foto del empleado">
                </td>
                <td>{{ $empleado->Nombres }}</td>
                <td>{{ $empleado->Apellidos }}</td>
                <td>{{ $empleado->Documento }}</td>
                <td>{{ $empleado->Correo }}</td>
                <td>{{ $empleado->rol }}</td>
                <td class="text-center">{{ $empleado->edad }}</td>
                <td class="text-center">
                    <a href="{{ url('/empleado/' . $empleado->id . '/edit') }}" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                    <form action="{{ url('/empleado/' . $empleado->id) }}" class="d-inline" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Quieres borrar este empleado?')" value="Borrar">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9" class="text-end text-muted">Total: {{ $empleados->total() }} empleados</td>
        </tr>
    </tfoot>
</table>
{!!$empleados->links()!!}
</div>
@endsection