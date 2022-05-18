<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilizador;
use DataTables;

class ConsumidoresController extends Controller
{
    public function index(Request $Request){
        $consumidores = new Utilizador;
        $consumidores ->setConnection('mysql2');

        $users = $consumidores::where('tipo_de_conta', '1')->get();

        if($Request->ajax()){
            $allData = DataTables::of($users)
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
                $row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editConsumidor">Edit</a>';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
                $row->id.'" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteConsumidor">Delete</a>';
                return $btn;
            })->rawColumns(['action'])
            ->make(true);
            return $allData;

        }
        return view('consumidores', compact('users'));
    } 

    public function store(Request $request){
        $request->validate([
            'email'=>'required|string',
            'primeiro_nome'=>'required|string',
            'ultimo_nome'=>'required|string',
            'password'=>'required|string',
            'telemovel'=>'required|string',
            'nif'=>'required|string',
            'morada'=>'required|string',
            'codigo_postal'=>'required|string',
            'cidade'=>'required|string',
            'pais'=>'required|string',
        ]);
        
        $consumidor = Utilizador::updateOrCreate(['id'=>$request->consumidor_id],
        [
            'email' => $request->email,
            'primeiro_nome' => $request->primeiro_nome,
            'ultimo_nome' => $request->ultimo_nome,
            'password' => bcrypt($request->password),
            'numero_telemovel' => $request->telemovel,
            'numero_contribuinte' => $request->nif,
            'morada' => $request->morada,
            'codigo_postal' => $request->codigo_postal,
            'cidade' => $request->cidade,
            'pais' => $request->pais,
            'tipo_de_conta' => "1"
        ]);

        return response()->json(['success'=>'Consumidor Criado Com Sucesso']);
    }

    public function destroy($id){
        Utilizador::find($id)->delete();
    
        return response()->json(['success'=>'Consumidor Apagado Com Sucesso']);
    }

    public function edit($id){

        $consumidor = Utilizador::find($id);

        return response()->json($consumidor);
    }
}