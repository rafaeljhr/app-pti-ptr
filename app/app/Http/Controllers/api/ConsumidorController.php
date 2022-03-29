<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use Illuminate\Http\Request;

class ConsumidorController extends Controller
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
            'nome'=>'required|string',
            'telemovel'=>'required|string',
            'nif'=>'required|string',
            'morada'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        $consumidor = Consumidor::create([
            'nome' => $request->nome,
            'telemovel' => $request->telemovel,
            'nif' => $request->nif,
            'morada' => $request->morada,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $consumidor->createToken('primeirotoken',['fornecedor'])-> plainTextToken;

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

        $consumidor->update($request->all());

        return $consumidor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        return Consumidor::destroy($id);
    }
}
