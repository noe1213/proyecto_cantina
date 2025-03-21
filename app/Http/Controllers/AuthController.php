<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;



class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Método para mostrar el formulario de login de usuarios
    public function showLoginForm()
    {
        return view('login'); // Vista para el login de usuarios
    }

    // Método para manejar el inicio de sesión de usuarios
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'email' => 'required|email', // Campo "email" en lugar de "correo"
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Intentar autenticar al usuario usando el guard 'web' (predeterminado)
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Autenticación exitosa
            return response()->json(['success' => true, 'redirect' => route('catalogo')]);
        } else {
            // Autenticación fallida
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }
    }

    // Método para cerrar sesión de usuarios
    public function logout(Request $request)
    {
        Auth::logout(); // Cerrar sesión del guard "web" (predeterminado)

        // Invalidar la sesión actual
        $request->session()->invalidate();

        // Regenerar el token de sesión
        $request->session()->regenerateToken();

        // Redirigir al usuario a la página de login
        return redirect()->route('login');
    }
}
