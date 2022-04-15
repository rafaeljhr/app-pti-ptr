<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consumidor;
use App\Models\Transportadora;
use App\Models\Fornecedor;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $fields = $request->validate([
            'email'=>'required|string',
            'password'=>'required|string',
            'tipo_conta'=>'required|string',
        ]);

        if ($fields['tipo_conta'] == 'consumidor'){
            $user = Consumidor::where('email', $fields['email'])->first();
        }elseif ($fields['tipo_conta'] == 'transportadora'){
            $user = Transportadora::where('email', $fields['email'])->first();
        }elseif ($fields['tipo_conta'] == 'fornecedor'){
            $user = Fornecedor::where('email', $fields['email'])->first();
        }else{
            $response = [
                'erro' => 'Tipo de conta inválido',
                'detalhes' => 'É necessário que o tipo de conta seja um destes valores {consumidor, transportadora, fornecedor}.',
                'status' => 403
            ];
    
            return response($response, 403);
        }

        if (!$user || !Hash::check($fields['password'], $user->password)){
            $response = [
                'erro' => 'Credenciais inválidas',
                'detalhes' => 'Email ou password incorretos',
                'status' => 401,
            ];
    
            return response($response, 401);
        }

        $token = $user->createToken('segundoToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }
}
