<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Utilizador;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{

    public function tipo_conta(){
        return DB::table('tipo_de_conta')->where('nome', 'fornecedor')->value('id');
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
            'Fornecedores' => $users,
            'status' => 200,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){

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

        $user = Utilizador::create([
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

        $token = $user->createToken('primeirotoken',['fornecedor'])-> plainTextToken;

        return response()->json([
            'fornecedor' => $user,
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
                'fornecedor' => $user,
                'erro' => 'Não Encontrado',
                'detalhes' => "Fornecedor com o ID $id não foi encontrado",
                'status' => 404,
            ]);
        }

        return response()->json([
            'fornecedor' => $user,
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
        $user = Utilizador::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $user->id and $user->tipo_de_conta == $this->tipo_conta()){
            $user->update($request->all());

            return $user;
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
        $user = Utilizador::findOrFail($id);

        $user_id = auth()->user()->id;

        if ($user_id == $user->id and $user->tipo_de_conta == $this->tipo_conta()){
            return Utilizador::destroy($id);
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
        $fornecedor = Utilizador::findOrFail($id);

        return $fornecedor->produto;
    }

    public function show_all_warehouses($id)
    {
        $user_id = auth()->user()->id;

        if ($user_id == $id) {
            $fornecedor = Utilizador::findOrFail($id);

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
