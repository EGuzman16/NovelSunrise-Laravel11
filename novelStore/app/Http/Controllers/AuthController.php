<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log; 

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login-form');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return redirect()
                ->back(fallback: route('auth.login.form'))
                ->withInput()
                ->with('feedback.message', 'Las credenciales ingresadas no coinciden con nuestros registros')
                ->with('feedback.type', 'danger');
        }

        return redirect()
            ->route('novels.index')
            ->with('feedback.message', 'Sesión iniciada con éxito');
    }

    public function logoutProcess(Request $request)
    {
        // Cerrar la sesión.
        auth()->logout();

        // Vacia y comienza de nuevo el inicio de la sesión.
        $request->session()->invalidate();

        // Regenera el token .
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login.form')
            ->with('feedback.message', 'Sesión cerrada con éxito');
    }

    // Método para mostrar el formulario de registro
    public function registerForm()
    {
        return view('auth.register');
    }

    // Método para procesar el registro de usuarios
    public function registerProcess(Request $request)
    {
        Log::info('Iniciando proceso de registro');  

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Log::info('Validación completada'); 

        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            Log::info('Usuario creado: ' . $user->id);  

            Auth::login($user);

            Log::info('Usuario autenticado');  

            return redirect()
                ->route('novels.index')
                ->with('feedback.message', 'Registro exitoso. Sesión iniciada con éxito');
        } catch (\Exception $e) {
            Log::error('Error en el proceso de registro: ' . $e->getMessage()); 
            return redirect()
                ->back()
                ->withInput()
                ->with('feedback.message', 'Error en el proceso de registro. Por favor, inténtelo de nuevo.')
                ->with('feedback.type', 'danger');
        }
    }

    // Métodos para la administración de usuarios
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->role = $request->input('role');
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en el proceso de creación de usuario: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('feedback.message', 'Error en el proceso de creación de usuario. Por favor, inténtelo de nuevo.')
                ->with('feedback.type', 'danger');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->role = $request->input('role');
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en el proceso de actualización de usuario: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('feedback.message', 'Error en el proceso de actualización de usuario. Por favor, inténtelo de nuevo.')
                ->with('feedback.type', 'danger');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en el proceso de eliminación de usuario: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('feedback.message', 'Error en el proceso de eliminación de usuario. Por favor, inténtelo de nuevo.')
                ->with('feedback.type', 'danger');
        }
    }
}