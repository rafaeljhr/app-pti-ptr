<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use Illuminate\Http\Request;

class ConsumidorController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Consumidor::all();
    }

    /**
     * Register a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consumidorRegister(Request $request){

        $request->validate([
            'morada'=>'required|string',
            'telefone'=>'required|string',
            'nif'=>'required|string',
            'nome'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        $consumidor = Consumidor::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'nif' => $request->nif,
            'morada' => $request->morada,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $consumidor->createToken('primeirotoken',['consumidor'])-> plainTextToken;

        $response = [
            'consumidor' => $consumidor,
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
        return Consumidor::findOrFail($id);
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

        $consumidor = Consumidor::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $consumidor->id){
            $consumidor->update($request->all());

            return $consumidor;
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
        $consumidor = Consumidor::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $consumidor->id){
            return Consumidor::destroy($id);
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function show_orders($id)
    {
        $consumidor = Consumidor::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $consumidor->id){
            return $consumidor->encomendas;
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }
}
