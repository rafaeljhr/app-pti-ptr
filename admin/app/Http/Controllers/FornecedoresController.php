<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilizador;
use Illuminate\Support\Facades\DB;
use DataTables;

class FornecedoresController extends Controller
{
    public function tipo_conta(){
        return DB::table('tipo_de_conta')->where('nome', 'fornecedor')->value('id');
    }


    public function index(Request $Request){
        $user = new Utilizador;
        $user ->setConnection('mysql2');

        $users = $user::where('tipo_de_conta', $this->tipo_conta())->get();

        if($Request->ajax()){
            $allData = DataTables::of($users)
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
                $row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editFornecedor">Edit</a>';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
                $row->id.'" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteFornecedor">Delete</a>';
                return $btn;
            })->rawColumns(['action'])
            ->make(true);
            return $allData;

        }
        return view('fornecedores', compact('users'));
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
        
        $user = Utilizador::updateOrCreate(['id'=>$request->fornecedor_id],
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
            'tipo_de_conta' => $this->tipo_conta()
        ]);

        return response()->json(['success'=>'Fornecedor Criado Com Sucesso']);
    }

    public function destroy($id){
        Utilizador::find($id)->delete();
    
        return response()->json(['success'=>'Fornecedor Apagado Com Sucesso']);
    }

    public function edit($id){

        $user = Utilizador::find($id);

        return response()->json($user);
    }
}