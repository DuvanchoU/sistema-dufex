<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Buscar el usuario manualmente
        $usuario = \App\Models\Usuario::where('correo_usuario', $request->email)
            ->where('estado', 'ACTIVO')
            ->first();

        // Verificar si existe y si la contraseña es correcta
        if ($usuario && \Hash::check($request->password, $usuario->contrasena_usuario)) {
            // Autenticar manualmente
            Auth::login($usuario, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Credenciales incorrectas
        throw ValidationException::withMessages([
            'email' => ['Las credenciales no coinciden o el usuario no está activo.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}