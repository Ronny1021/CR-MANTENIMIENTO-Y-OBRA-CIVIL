<div class="row mb-3">
    <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
            value="{{ old('nombre', $item->nombre ?? '') }}">
    </div>

    <div class="col-md-6">
        <label for="tipo_herramienta" class="form-label">Tipo</label>
        <input type="text" name="tipo_herramienta" id="tipo_herramienta" class="form-control"
            value="{{ old('tipo_herramienta', $item->tipo_herramienta ?? '') }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="categoria" class="form-label">Categoría</label>
        <input type="text" name="categoria" id="categoria" class="form-control"
            value="{{ old('categoria', $item->categoria ?? '') }}">
    </div>

    <div class="col-md-6">
        <label for="unidad_medida" class="form-label">Unidad de medida</label>
        <input type="text" name="unidad_medida" id="unidad_medida" class="form-control"
            value="{{ old('unidad_medida', $item->unidad_medida ?? '') }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" class="form-control"
            value="{{ old('cantidad', $item->cantidad ?? '') }}">
    </div>

    <div class="col-md-6">
        <label for="estado" class="form-label">Estado</label>
        <input type="text" name="estado" id="estado" class="form-control"
            value="{{ old('estado', $item->estado ?? '') }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="disponibilidad" class="form-label">Disponibilidad</label>
        <select name="disponibilidad" id="disponibilidad" class="form-select">
            <option value="">-- Seleccionar --</option>
            <option value="Disponible" {{ old('disponibilidad', $item->disponibilidad ?? '') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="En uso" {{ old('disponibilidad', $item->disponibilidad ?? '') == 'En uso' ? 'selected' : '' }}>En uso</option>
            <option value="Dañado" {{ old('disponibilidad', $item->disponibilidad ?? '') == 'Dañado' ? 'selected' : '' }}>Dañado</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="fecha_registro" class="form-label">Fecha de registro</label>
        <input type="datetime-local" name="fecha_registro" id="fecha_registro" class="form-control"
            value="{{ old('fecha_registro', isset($item->fecha_registro) ? \Carbon\Carbon::parse($item->fecha_registro)->format('Y-m-d\TH:i') : '') }}">
    </div>
</div>

<div class="d-flex justify-content-between mt-4">
    <input type="submit" value="{{ $modo }} herramienta" class="btn btn-success">
    <a href="{{ url('inventario') }}" class="btn btn-secondary">Regresar</a>
</div>