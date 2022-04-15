<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Base_Transportadora;

class Base_TransportadoraController extends Controller
{
    public function create_base(Request $request, $id){

        $user_id = auth()->user()->id;

        if ($user_id == $id){
            $request->validate([
                'morada'=>'required|string',
                'telefone'=>'required|string',
            ]);
    
            $base = Base_Transportadora::create([
                'id_transportadora' => $user_id,
                'morada' => $request->morada,
                'telefone' => $request->telefone,
            ]);
    
            $response = [
                'Base' => $base,
            ];

            return response($response, 201);
        } 

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function show_base($id, $id_base){
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $base = Base_Transportadora::findOrFail($id_base);

            if ($base->id_transportadora == $user_id){
                return $base;
            }  
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function update_base(Request $request, $id, $id_base) {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $base = Base_Transportadora::findOrFail($id_base);

            if ($base->id_transportadora == $user_id){

                $base->update($request->all());

                return $base;
            }  
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function destroy_base($id, $id_base) {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $base = Base_Transportadora::findOrFail($id_base);

            if ($base->id_transportadora == $user_id){
                return Base_Transportadora::destroy($id_base);
            }  
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }
}
