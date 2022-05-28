<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Encomenda;
use App\Models\Estado_encomenda;

class EncomendaController extends Controller
{

    public static function encomendasDoUtilizador()
    {

        //return $request;

        $encomendas = Encomenda::where('id_consumidor', session()->get('user_id'))->orderBy('data_realizada', 'DESC')->get();

        $all_encomendas = array();
    

        foreach($encomendas as $encomenda) {

            $encomenda_id = $encomenda->id;
            $encomenda_preco = $encomenda->preco;
            $encomenda_morada = $encomenda->morada;
            $encomenda_codigo_postal = $encomenda->codigo_postal;
            $encomenda_cidade = $encomenda->cidade;
            $encomenda_pais = $encomenda->pais;
            $encomenda_quantidade = $encomenda->quantidade;
            $encomenda_data_realizada = $encomenda->data_realizada;
            $encomenda_data_finalizada = $encomenda->data_finalizada;
            $encomenda_id_consumidor = $encomenda->id_consumidor;
            $encomenda_id_produto = $encomenda->id_produto;
            $encomenda_id_transportadora = $encomenda->id_transportadora;
            $encomenda_id_fornecedor = $encomenda->id_fornecedor;
            $encomenda_estado_encomenda = $encomenda->estado_encomenda;

            $atributos_encomenda = [
                "encomenda_id" => $encomenda_id,
                "encomenda_preco" => $encomenda_preco,
                "encomenda_morada" => $encomenda_morada,
                "encomenda_codigo_postal" => $encomenda_codigo_postal,
                "encomenda_cidade" => $encomenda_cidade,
                "encomenda_pais" => $encomenda_pais,
                "encomenda_quantidade" => $encomenda_quantidade,
                "encomenda_data_realizada" => $encomenda_data_realizada,
                "encomenda_data_finalizada" => $encomenda_data_finalizada,
                "encomenda_id_consumidor" => $encomenda_id_consumidor,
                "encomenda_id_produto" => $encomenda_id_produto,
                "encomenda_id_transportadora" => $encomenda_id_transportadora,
                "encomenda_id_fornecedor" => $encomenda_id_fornecedor,
                "encomenda_estado_encomenda" => $encomenda_estado_encomenda,
            ];

            array_push($all_encomendas, $atributos_encomenda);

        }

        session()->put('all_encomendas', $all_encomendas);

    }

}