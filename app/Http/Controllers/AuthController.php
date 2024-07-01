<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="Login",
     *      tags={"Auth"},
     *      summary="Login user",
     *      description="Login User",
    *      @OA\RequestBody(
    *          required=true,
    *          description="Login User",
    *          @OA\JsonContent(
    *              @OA\Property(property="email", type="string", format="email", example="test@example.com"),
    *              @OA\Property(property="password", type="string", example="123546")
    *          )
    *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
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
