<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\Encomenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsumidorController
{

    public function tipo_conta(){
        return DB::table('tipo_de_conta')->where('nome', 'consumidor')->value('id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = Utilizador::where('tipo_de_conta', $this->tipo_conta())->get();

        return response()->json([
            'Consumidores' => $users,
            'status' => 200,
        ]);
    }

    /**
     * Register a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consumidorRegister(Request $request){

        $request->validate([
            'email'=>'required|string',
            'password'=>'required|string',
            'nome'=>'required|string',
            'apelido'=>'required|string',
            'telemovel'=>'required|string',
            'nif'=>'required|string',
            'codigo_postal'=>'required|string',
            'morada'=>'required|string',
            'cidade'=>'required|string',
            'pais'=>'required|string',
        ]);

        $consumidor = Utilizador::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'primeiro_nome' => $request->nome,
            'ultimo_nome' => $request->apelido,
            'numero_telemovel' => $request->telemovel,
            'numero_contribuinte' => $request->nif,
            'morada' => $request->morada,
            'codigo_postal' => $request->codigo_postal,
            'cidade' => $request->cidade,
            'pais' => $request->pais,
            'tipo_de_conta' => $this->tipo_conta(),
        ]);

        $token = $consumidor->createToken('primeirotoken',['consumidor'])-> plainTextToken;

        return response()->json([
            'consumidor' => $consumidor,
            'token' => $token,
            'status' => 201,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Utilizador::where('tipo_de_conta', $this->tipo_conta()) ->where('id', $id)->get();

        if($user->isEmpty()){

            return response()->json([
                'consumidor' => $user,
                'erro' => 'Não Encontrado',
                'detalhes' => "Consumidor com o ID $id não foi encontrado",
                'status' => 404,
            ]);
        }

        return response()->json([
            'consumidor' => $user,
            'status' => 200,
        ], 200);
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
        $consumidor = Utilizador::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $consumidor->id and $consumidor->tipo_de_conta == $this->tipo_conta()){
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
        $consumidor = Utilizador::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $consumidor->id and $consumidor->tipo_de_conta == $this->tipo_conta()){
            return Utilizador::destroy($id);
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
        $consumidor = Utilizador::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $consumidor->id and $consumidor->tipo_de_conta == $this->tipo_conta()){

            return response()->json([
                'encomendas' => $consumidor->encomendas,
                'status' => 200,
            ], 200);
        }

        $response = [
            'erro' => 'Não Autorizado',
            'detalhes' => 'O token fornecido não possui permissões para aceder ao recurso',
            'status' => 403
        ];

        return response($response, 403);
    }
}
