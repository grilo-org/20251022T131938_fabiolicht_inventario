<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller; // Importe a classe Controller correta
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Gera um token de acesso para o usuário
            $token = $user->createToken('authToken')->plainTextToken;

              // Salva o token no banco de dados
              $user->api_token = $token;
              $user->save();

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Acesso negado revise suas Credênciais'], 401);
        }
    }
}
