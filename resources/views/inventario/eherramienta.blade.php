@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar herramienta</h2>

    @include('inventario.inventarioform', ['modo' => 'Editar'])
</div>
@endsection