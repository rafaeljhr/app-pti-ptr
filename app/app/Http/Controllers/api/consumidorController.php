<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\consumidor;

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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'telefone' => 'required|max:9',
            'nome' => 'required|max: 200',
            'nif' => 'required|max: 9',
            'morada' => 'required|max: 200'

          ]);
      
        $newConsumidor = new consumidor([
        'telefone' => $request->get('telefone'),
        'nome' => $request->get('nome'),
        'nif' => $request->get('nif'),
        'morada' => $request->get('morada')
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
        $consumidor = consumidor::findOrFail($id);
        return response()->json($consumidor);
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
            'telefone' => 'required|max:9',
            'nome' => 'required|max: 200',
            'nif' => 'required|max: 9',
            'morada' => 'required|max: 200'
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
