<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
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
        return Fornecedor::all();
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
            'telemovel'=>'required|string',
            'nif'=>'required|string',
            'nome'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        $fornecedor = Fornecedor::create([
            'nome' => $request->nome,
            'telemovel' => $request->telemovel,
            'nif' => $request->nif,
            'morada_fiscal' => $request->morada,
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
        return Fornecedor::findOrFail($id);
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
        $fornecedor = Fornecedor::findOrFail($id);

        $fornecedor->update($request->all());

        return $fornecedor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Fornecedor::destroy($id);
    }
}
