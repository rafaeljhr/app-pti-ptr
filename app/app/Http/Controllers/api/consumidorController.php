<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\consumidor;
use Illuminate\Support\Str;

class consumidorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consumidores = consumidor::all();
        return response()->json($consumidores);
    }

    /**
     * Store a newly created resource in storage.
     *_
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'password' => 'required',
            'telemovel' => 'required',
            'nif' => 'required',
            'morada' => 'required'
        ]);
      
        $newConsumidor = new consumidor([
        'nome' => $request->get('nome'),
        'email' => $request->get('email'),
        'password' => $request->get('password'),
        'telemovel' => $request->get('telemovel'),
        'nif' => $request->get('nif'),
        'morada' => $request->get('morada'),
        'api_token' => Str::random(60)
        ]);
    
        $newConsumidor->save();
    
        return response()->json($newConsumidor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user_json = explode("+", $id);
        $user_id = $user_json[0];
        $get_user_token = $user_json[1];
        
        $consumidor = consumidor::findOrFail($user_id);

        $consumidor_json = json_decode($consumidor->toJson());
        $real_user_token=$consumidor_json->api_token;


        // return response()->json($consumidor);
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
        $consumidor = consumidor::findOrFail($id);

        $request->validate([
            'telefone' => 'required',
            'nome' => 'required',
            'nif' => 'required',
            'morada' => 'required'
        ]);

        $consumidor->telefone = $request->get('telefone');
        $consumidor->nome = $request->get('nome');
        $consumidor->nif = $request->get('nif');
        $consumidor->morada = $request->get('morada');

        $consumidor->save();

        return response()->json($consumidor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consumidor = consumidor::findOrFail($id);
        $consumidor->delete();

        return response()->json($consumidor::all());
    }
}
