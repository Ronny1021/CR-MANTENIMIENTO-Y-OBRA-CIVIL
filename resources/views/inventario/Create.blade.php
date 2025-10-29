@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar nueva herramienta</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/inventario') }}" method="POST">
        @csrf

        @include('inventario.form', ['modo' => 'Registrar'])

    </form>
</div>
@endsection