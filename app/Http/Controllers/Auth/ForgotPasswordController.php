<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\PHPMailerService;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Este correo no está registrado.']);
        }

        $token = Str::random(64);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $link = url("/password/reset/{$token}?email={$request->email}");

        $mailer = new PHPMailerService(config('mail.mailer_config'));
        $resultado = $mailer->enviarCorreo(
            $request->email,
            'Restablecer contraseña',
            "<p>Hola {$user->name},</p><p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p><p><a href='{$link}'>Restablecer contraseña</a></p><p>Si no solicitaste esto, puedes ignorar este mensaje.</p>"
        );

        if ($resultado['success']) {
            return back()->with('status', 'Te hemos enviado un correo con el enlace para restablecer tu contraseña.');
        } else {
            return back()->withErrors(['email' => 'No se pudo enviar el correo. Intenta más tarde.']);
        }
    }
}
