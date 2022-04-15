<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Armazem;
use App\Models\Produto;
use Carbon\Carbon;

class ArmazemController extends Controller{
    
    public function create_warehouse(Request $request, $id){

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
            'detalhes' => 'O token fornecido não possui permissões para criar recursos',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function show_warehouse($id, $id_warehouse){
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $armazem = Armazem::findOrFail($id_warehouse);

            if ($armazem->id_fornecedor == $user_id){
                return response($armazem, 200);
            }  
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function update_warehouse(Request $request, $id, $id_warehouse) {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $armazem = Armazem::findOrFail($id_warehouse);

            if ($armazem->id_fornecedor == $user_id){

                $armazem->update($request->all());

                return response($armazem, 200);
            }  
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para atualizar o recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function destroy_warehouse($id, $id_warehouse) {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $armazem = Armazem::findOrFail($id_warehouse);

            if ($armazem->id_fornecedor == $user_id){
                return Armazem::destroy($id_warehouse);
            }  
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para apagar o recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function warehouse_inventory($id, $id_warehouse){

        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $armazem = Armazem::findOrFail($id_warehouse);

            if ($armazem->id_fornecedor == $user_id){

                return response($armazem->produto, 200);
            }  
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function store_warehouse(Request $request, $id, $id_warehouse){

        $user_id = auth()->user()->id;

        if ($user_id == $id){

            $armazem = Armazem::findOrFail($id_warehouse);

            if ($armazem->id_fornecedor == $user_id){

                $request->validate([
                    'nome'=>'required|string',
                    'preco'=>'required|string',
                    'categoria'=>'required|string',
                    'subcategoria'=>'required|string',
                    'informacao'=>'nullable|string',
                    'Data_de_Producao'=>'required|string',
                    'Poluicao_por_dia'=>'required|string',
                ]);

                $todayDate = Carbon::now()->format('Y-m-d');
                $Data_Producao = Carbon::parse($request->Data_de_Producao)->format('Y/m/d'); 

                $produto = Produto::create([
                    'nome' => $request->nome,
                    'preco' => $request->preco,
                    'nome_categoria' => $request->categoria,
                    'nome_subcategoria' => $request->subcategoria,
                    'info_arbitraria' => $request->informacao,
                    'data_producao_do_produto' => $Data_Producao,
                    'poluicao_gerada_por_dia' => $request->Poluicao_por_dia,
                    'id_armazem' => $id_warehouse,
                    'id_fornecedor' => $user_id,
                    'data_insercao_no_site' => $todayDate,
                ]);
        
                $response = [
                    'Produto' => $produto,
                ];

                return response($response, 201);

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