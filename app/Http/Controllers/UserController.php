<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // Simula la autentifcacion
    public function login(Request $request)
    {
        // Usuarios desde un archivo JSON
        $usuarios = json_decode(file_get_contents(storage_path('usuarios.json')), true);

        foreach ($usuarios as $usuario) {
            if ($usuario['username'] == $request->username && $usuario['password'] == $request->password) {
                // Iniciar sesión y almacenar los datos del usuario
                Session::put('usuario', $usuario);
                return redirect()->route('productos.index');
            }
        }

        // Si la autenticacion da error
        return redirect('/login')->withErrors('Credenciales incorrectas.');
    }

    public function logout()
    {
        // Limpia la sesion del usuario
        Session::forget('usuario');
        return redirect('/login')->with('success', 'Has cerrado sesion correctamente.');
    }
}
