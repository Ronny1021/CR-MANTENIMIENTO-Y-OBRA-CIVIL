@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inventario de Herramientas</h2>

    @if(session('mensaje'))
        <div class="alert alert-success">{{ session('mensaje') }}</div>
    @endif

    <a href="{{ url('inventario/create') }}" class="btn btn-primary mb-3">Agregar herramienta</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Disponibilidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventario as $item)
            <tr>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->tipo_herramienta }}</td>
                <td>{{ $item->categoria }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->unidad_medida }}</td>
                <td>{{ $item->disponibilidad }}</td>
                <td>
                    <a href="{{ url('/inventario/'.$item->id.'/edit') }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ url('/inventario/'.$item->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar herramienta?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $inventario->links() }}
</div>
@endsection