<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{   
    //Fazer depois
    public function create_product(Request $request, $id){

        $user_id = auth()->user()->id;

        if ($user_id == $id){
            $request->validate([
                'morada'=>'required|string',
            ]);
    
            $armazem = Armazem::create([
                'id_fornecedor' => $user_id,
                'morada' => $request->morada,
            ]);
    
            $response = [
                'Armazem' => $armazem,
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

    public function show_product($id, $id_product){
    
        $produto = Produto::findOrFail($id_product);

        if ($produto->id_fornecedor == $id){
            return $produto;
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);

    }

    public function destroy_product($id, $id_product) {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $produto = Produto::findOrFail($id_product);

            if ($produto->id_fornecedor == $user_id){
                return Produto::destroy($id_product);
            }  
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function update_product(Request $request, $id, $id_product) {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $produto = Produto::findOrFail($id_product);

            if ($produto->id_fornecedor == $user_id){

                $produto->update($request->all());

                return $produto;
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