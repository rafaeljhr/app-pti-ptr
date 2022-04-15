<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportadora;

class TransportadoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transportadora::all();
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

        $transportadora = Transportadora::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'nif' => $request->nif,
            'morada' => $request->morada,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $transportadora->createToken('primeirotoken',['transportadora'])-> plainTextToken;

        $response = [
            'transportadora' => $transportadora,
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
        return Transportadora::findOrFail($id);
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
        $transportadora = Transportadora::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $transportadora->id){

            $transportadora->update($request->all());
            
            return $transportadora;
        }
        
        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para atualizar o recurso',
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
        $transportadora = Transportadora::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $transportadora->id){
            return Transportadora::destroy($id);
        } 

        
        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para apagar o recurso',
            'status' => 403
        ];

        return response($response, 403);
    }

    public function show_all_bases($id)
    {
        $user_id = auth()->user()->id;

        if ($user_id == $transportadora->id){
            $transportadora = Transportadora::findOrFail($id);

            return $transportadora->base_transportadora;
        }

        
        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }
}
