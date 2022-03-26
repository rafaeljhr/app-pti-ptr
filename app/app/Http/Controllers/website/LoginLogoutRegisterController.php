<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\consumidor;
use App\Models\fornecedor;
use App\Models\Transportadora;
use Illuminate\Support\Str;

class LoginLogoutRegisterController extends Controller
{

    // Get an existing consumidor/transportadora/fornecedor
    public function login(Request $request)
    {
        // $consumidores = consumidor::all();
        // return response()->json($consumidores);

        // $request->get('telefone');

        return $request->input();
    }



    // Delete a consumidor/transportadora/fornecedor
    public function logout()
    {

        // AQUI É DAR WIPE À SESSÃO E FAZER REDIRECT PARA A INDEX.HTML
    }



    // Register a consumidor/transportadora/fornecedor
    public function register(Request $request)

    {
        // $request->validate([
        //     'nome' => 'required',
        //     'email' => 'required',
        //     'password' => 'required',
        //     'telemovel' => 'required',
        //     'nif' => 'required',
        //     'morada' => 'required'
        // ]);
      
        // $newConsumidor = new consumidor([
        // 'nome' => $request->get('nome'),
        // 'email' => $request->get('email'),
        // 'password' => $request->get('password'),
        // 'telemovel' => $request->get('telemovel'),
        // 'nif' => $request->get('nif'),
        // 'morada' => $request->get('morada'),
        // 'api_token' => Str::random(60)
        // ]);
    
        // $newConsumidor->save();
    
        // return response()->json($newConsumidor);

        return $request->input();
    }



    // Update the information of a consumidor/transportadora/fornecedor
    public function update(Request $request, $id)
    {
        $consumidor = consumidor::findOrFail($id);

        $request->validate([
            'telefone' => 'required',
            'nome' => 'required',
            'nif' => 'required',
            'morada' => 'required'
        ]);

        $consumidor->telefone = $request->get('telefone');
        $consumidor->nome = $request->get('nome');
        $consumidor->nif = $request->get('nif');
        $consumidor->morada = $request->get('morada');

        $consumidor->save();

        return response()->json($consumidor);
    }



    // Delete a consumidor/transportadora/fornecedor
    public function delete(Request $request, $id)
    {
        $consumidor = consumidor::findOrFail($id);
        $consumidor->delete();

        return response()->json($consumidor::all());
    }


    
}
