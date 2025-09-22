<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    // Registro
    public function register(Request $request)
    {
        Log::info('Intentando registrar un usuario', $request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        \Log::info('Intentando login', [
            'email' => $request->email,
            'password' => $request->password
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (!$token = \Auth::attempt($credentials)) {
            \Log::error('Fallo en login', ['credentials' => $credentials]);
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
    
        \Log::info('Login exitoso', ['user' => \Auth::user()]);
    
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    
}
