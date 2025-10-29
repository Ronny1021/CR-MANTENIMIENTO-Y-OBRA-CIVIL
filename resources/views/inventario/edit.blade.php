@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{ url('/inventario/')}}" method="POST" enctype="multipart/form-data">
@csrf


    @include('inventario.inventarioform', ['modo' => 'Editar'])
</form>
</div>
@endsection

