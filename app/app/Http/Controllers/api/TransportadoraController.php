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
            'telemovel'=>'required|string',
            'nif'=>'required|string',
            'nome'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        $transportadora = Transportadora::create([
            'nome' => $request->nome,
            'telemovel' => $request->telemovel,
            'nif' => $request->nif,
            'morada_fiscal' => $request->morada,
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

        $transportadora->update($request->all());

        return $transportadora;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Transportadora::destroy($id);
    }
}
