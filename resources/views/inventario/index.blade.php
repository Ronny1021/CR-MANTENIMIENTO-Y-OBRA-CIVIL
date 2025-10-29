@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Mensaje de éxito --}}
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('mensaje') }}
        </div>
    @endif

    {{-- Filtro por disponibilidad --}}
    <form method="GET" action="{{ url('inventario') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="disponibilidad" class="form-select">
                    <option value="">-- Filtrar por disponibilidad --</option>
                    <option value="Disponible" {{ request('disponibilidad') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="En uso" {{ request('disponibilidad') == 'En uso' ? 'selected' : '' }}>En uso</option>
                    <option value="Dañado" {{ request('disponibilidad') == 'Dañado' ? 'selected' : '' }}>Dañado</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ url('inventario/pdf?disponibilidad=' . request('disponibilidad')) }}" class="btn btn-outline-danger">Descargar PDF</a>
            </div>
        </div>
    </form>

    {{-- Botón para registrar nueva herramienta --}}
    <a href="{{ url('inventario/create') }}" class="btn btn-success mb-3">Registrar nueva herramienta</a>

    {{-- Tabla de inventario --}}
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
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
            @if($inventario && $inventario->count())
                @foreach ($inventario as $item)
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->tipo_herramienta }}</td>
                        <td>{{ $item->categoria }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ $item->unidad_medida }}</td>
                        <td>{{ $item->disponibilidad }}</td>
                        <td class="text-center">
                            <a href="{{ url('/inventario/' . $item->id . '/edit') }}" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                            <form action="{{ url('/inventario/' . $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('¿Quieres borrar esta herramienta?')" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay herramientas registradas.</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-end text-muted">
                    Total: {{ method_exists($inventario, 'total') ? $inventario->total() : ($inventario ? $inventario->count() : 0) }} herramientas
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- Paginación con filtros persistentes --}}
    {!! $inventario->appends(['disponibilidad' => request('disponibilidad')])->links() !!}
</div>
@endsection