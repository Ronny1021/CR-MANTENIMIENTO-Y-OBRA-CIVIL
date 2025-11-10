<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactoController;


////////////////////////////////////////

// Rutas de autenticación
Auth::routes();

// Ruta raíz: redirige al login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
});


/////////////////////////////////

// Ruta principal después de iniciar sesión
Route::get('/home', [EmpleadoController::class, 'index'])->name('home')->middleware('auth');

//  Ruta pública para recuperación de contraseña
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/acerca', function () {
    if (Auth::check()) {
        return redirect()->route('empleado.index'); // o cualquier otra ruta para usuarios autenticados
    }
    return view('acerca');
})->name('acerca');

Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');



/////////////////////////////

// Grupo de rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Certificados laborales
    Route::get('/certificados', [NominaController::class, 'certificadoForm'])->name('certificados.form');
    Route::post('/certificados/pdf', [NominaController::class, 'generarCertificadoPDF'])->name('certificados.pdf');

    // Nomina
    Route::resource('nomina', NominaController::class);

    // Empleado
    Route::get('empleado/create', [EmpleadoController::class, 'create']);
    Route::resource('empleado', EmpleadoController::class);

    // Inventario
    Route::get('inventario/pdf', [InventarioController::class, 'exportarPDF'])->name('inventario.pdf');
    Route::resource('inventario', InventarioController::class);

    //Desprendibles
    Route::get('/desprendible', [NominaController::class, 'desprendibleForm'])->name('desprendible.form');
    Route::post('/certificados/pdf', [NominaController::class, 'generardesprendible.pdf'])->name('desprendible.pdf');
});
