@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar herramienta</h2>

    @include('inventario.inventarioform', ['modo' => 'Crear'])
</div>
@endsection