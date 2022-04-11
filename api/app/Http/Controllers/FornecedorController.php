<?php

namespace App\Http\Controllers;

use App\Models\fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return fornecedor::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){

        $request->validate([
            'morada'=>'required|string',
            'telefone'=>'required|string',
            'nif'=>'required|string',
            'nome'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        $fornecedor = fornecedor::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'nif' => $request->nif,
            'morada' => $request->morada,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $fornecedor->createToken('primeirotoken',['fornecedor'])-> plainTextToken;

        $response = [
            'fornecedor' => $fornecedor,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return fornecedor::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $fornecedor = fornecedor::findOrFail($id);

            $fornecedor->update($request->all());
    
            return $fornecedor;
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            return fornecedor::destroy($id);
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_inventory($id)
    {
        $fornecedor = fornecedor::findOrFail($id);

        return $fornecedor->produto;
    }

    public function show_all_warehouses($id)
    {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $fornecedor = fornecedor::findOrFail($id);

            return $fornecedor->armazem;
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);

    }
}
