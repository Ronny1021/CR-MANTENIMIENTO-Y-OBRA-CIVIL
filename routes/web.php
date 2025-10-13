<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\EmpleadoController;


Route::get('/', function () {
    return view('auth.login');
});


Route::get('/empleado', function () {
    return view('empleado.index');
});

route::get('empleado/create',[EmpleadoController::class,'create']);

route::resource('empleado', EmpleadoController::class)-> middleware('auth');
Auth::routes();

Route::resource('inventario', InventarioController::class)->middleware('auth');

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'],  function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});

