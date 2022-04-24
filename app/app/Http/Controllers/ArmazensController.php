<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Armazem;

class ArmazensController extends Controller
{

    public function armazemRegister(Request $request)
    {
        // return $request->input();

        $request->validate([
            'nome'=>'required|string',
            'morada'=>'required|string',
        ]);

        $filename = "images/default_armazem.jpg";

        if($request->file('path_imagem_armazem')){

            $allowedMimeTypes = ['image/jpeg', 'image/jpg','image/gif','image/png'];
            $contentType = $request->file('path_imagem_armazem')->getClientMimeType();

            if(!in_array($contentType, $allowedMimeTypes) ){
                return response()->json('error: Not an image submited in the form');
            }

            $file= $request->file('path_imagem_armazem');
            $filename= date('YmdHi').$file->getClientOriginalName();

            if (!$file-> move(public_path('images/users_images/'), $filename)) {
                return 'Error saving the file';
            }

            $filename = 'images/users_images/' . $filename;
            
        }


        $newArmazem = Armazem::create([
            'id_fornecedor' => session()->get('user_id'),
            'morada' => $request->get('morada'),
            'nome' => $request->get('nome'),
            'path_imagem' => $filename,
        ]);

        (new ArmazensController)->getAllArmazens(); // put all armazens of fornecedor in session

        return redirect('/inventory');

    }


    public function getAllArmazens()
    {
        $fornecedor_armazens = Armazem::where('id_fornecedor', session()->get('user_id'))->get();

        $all_fornecedor_armazens = array();

        foreach($fornecedor_armazens as $armazem) {

            $atributos_armazem = array();

            $armazem_id = $armazem->id;
            $armazem_id_fornecedor = $armazem->id_fornecedor;
            $armazem_morada = $armazem->morada;
            $armazem_nome = $armazem->nome;
            $armazem_path_imagem = $armazem->path_imagem;

            array_push($atributos_armazem, $armazem_id);
            array_push($atributos_armazem, $armazem_id_fornecedor);
            array_push($atributos_armazem, $armazem_morada);
            array_push($atributos_armazem, $armazem_nome);
            array_push($atributos_armazem, $armazem_path_imagem);


            array_push($all_fornecedor_armazens, $atributos_armazem);
        }

        session()->put('armazens', $all_fornecedor_armazens);
    }


    public function armazemDelete($id){

        $produto = Armazem::where('id', $id)->first();
        $produto->delete();

    }

}