<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Buscar o usuário pelo e-mail
        $user = User::where('email', $request->email)->first();
    
        // Verificar se o usuário existe e a senha está correta
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }
    
        // Gerar um token de API para o usuário
        $token = $user->createToken('token-name')->plainTextToken;
    
        // Retornar o token como resposta
        return response()->json(['token' => $token]);
    }
}
