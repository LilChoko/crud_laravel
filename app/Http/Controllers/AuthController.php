<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de tener el modelo User

class AuthController extends Controller
{
    // Mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('login');
    }

    // Procesar el inicio de sesión
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Verificar si el usuario existe en la base de datos
        $user = User::where('email', $credentials['email'])->first();

        if ($user && password_verify($credentials['password'], $user->password)) {
            // Autenticación exitosa, almacenar en la sesión
            session(['user_id' => $user->id]);
            return redirect()->route('home');
        }

        // Autenticación fallida, redirigir con error
        return redirect()->back()->with('error', 'Credenciales incorrectas.');
    }

    // Cerrar sesión
    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('login');
    }
}
