<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Armazem;

class ArmazensController extends Controller
{

    public function armazemRegister(Request $request)
    {

        $request->validate([
            'id_fornecedor'=>'required|integer',
            'morada'=>'required|string',
            'nome'=>'required|string',
            'recursos_consumidos_por_dia'=>'required|string',
        ]);

        $newArmazem = Armazem::create([
            'id_fornecedor' => $request->get('id_fornecedor'),
            'morada' => $request->get('morada'),
            'nome' => session()->get('nome'),
            'recursos_consumidos_por_dia' => $request->get('recursos_consumidos_por_dia'),
        ]);

        // adding the product to the session

        $atributos_armazem = array();

        $armazem_id = $newArmazem->id;
        $armazem_id_fornecedor = $newArmazem->id_fornecedor;
        $armazem_morada = $newArmazem->morada;
        $armazem_nome = $newArmazem->nome;
        $armazem_recursos_consumidos_por_dia = $newArmazem->recursos_consumidos_por_dia;

        array_push($atributos_armazem, $armazem_id);
        array_push($atributos_armazem, $armazem_id_fornecedor);
        array_push($atributos_armazem, $armazem_morada);
        array_push($atributos_armazem, $armazem_nome);
        array_push($atributos_armazem, $armazem_recursos_consumidos_por_dia);

        if(!(session()->has('armazens'))){
            $all_fornecedor_armazens = session()->get('all_fornecedor_armazens');
            array_push($all_fornecedor_armazens, $atributos_armazem);
        } else {
            $all_armazens = array();
            array_push($all_armazens, $atributos_armazem);
            session()->put('armazens', $all_armazens);
        }

    }


    public function armazemDelete($id){

        $produto = Armazem::where('id', $id)->first();
        $produto->delete();

    }

}