<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'required|string|max:1000',
        ]);

        Contacto::create($request->all());

        return redirect()->route('acerca')->with('success', 'Gracias por tu mensaje. Te contactaremos pronto.');
    }
}