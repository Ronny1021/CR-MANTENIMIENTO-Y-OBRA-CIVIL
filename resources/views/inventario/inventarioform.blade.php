<form action="{{ $modo == 'Crear' ? url('/inventario') : url('/inventario/'.$item->id) }}" method="POST">
    @csrf
    @if($modo == 'Editar')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ old('nombre', $item->nombre) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Tipo de herramienta:</label>
        <input type="text" name="tipo_herramienta" value="{{ old('tipo_herramienta', $item->tipo_herramienta) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Categoría:</label>
        <input type="text" name="categoria" value="{{ old('categoria', $item->categoria) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Cantidad:</label>
        <input type="number" name="cantidad" value="{{ old('cantidad', $item->cantidad) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Unidad de medida:</label>
        <input type="text" name="unidad_medida" value="{{ old('unidad_medida', $item->unidad_medida) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Disponibilidad:</label>
        <select name="disponibilidad" class="form-control">
            <option value="Disponible" {{ old('disponibilidad', $item->disponibilidad) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="En uso" {{ old('disponibilidad', $item->disponibilidad) == 'En uso' ? 'selected' : '' }}>En uso</option>
            <option value="Dañado" {{ old('disponibilidad', $item->disponibilidad) == 'Dañado' ? 'selected' : '' }}>Dañado</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">{{ $modo == 'Crear' ? 'Registrar' : 'Actualizar' }}</button>
    <a href="{{ url('/inventario') }}" class="btn btn-secondary">Cancelar</a>
</form>