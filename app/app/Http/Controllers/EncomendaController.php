<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Encomenda;
use App\Models\Estado_encomenda;
use App\Models\Produto;
use App\Models\Utilizador;
use App\Models\Notificacao;
use DateTime;

class EncomendaController extends Controller
{

    public static function atualizar_encomendas_que_ja_nao_podem_ser_canceladas()
    {
        $encomendas = Encomenda::where('id_consumidor', session()->get('user_id'))->get();
    
        // atualizar o estado de encomendas que ja n podem ser canceladas
        foreach($encomendas as $encomenda) {

            if ($encomenda->estado_encomenda == "Cancelamento disponível") {

                $atual = new DateTime();
                $hoje = strtotime($atual->format('Y-m-d H:i:s'));
                $data_encomenda = strtotime($encomenda->data_realizada);
                $totalSecondsDiff = abs($data_encomenda-$hoje);
                $totalHoursDiff   = $totalSecondsDiff/60/60; // to see if >= 24
                if ($totalHoursDiff>=24){
                    $encomenda2 = Encomenda::where('id', $encomenda->id)->first();
                    $encomenda2->estado_encomenda = "Em processamento pelo fornecedor";
                    $encomenda2->save();

                    // notificacao de estado ao consumidor
                    $notificacao_consumidor = Notificacao::create([
                        'id_utilizador' => $encomenda->id_consumidor,
                        'mensagem' => "A sua encomenda Nº ".$encomenda->id." encontra-se em processamento pelo fornecedor!",
                        'estado' => 1,
                    ]);


                    // notificacao de estado ao fornecedor
                    $notificacao_fornecedor = Notificacao::create([
                        'id_utilizador' => $encomenda->id_fornecedor,
                        'mensagem' => "Uma nova encomenda de Nº identificador ".$encomenda->id." aguarda processamento!",
                        'estado' => 1,
                    ]);

                    // notificacao de estado a transportadora
                    $notificacao_transportadora = Notificacao::create([
                        'id_utilizador' => $encomenda->id_transportadora,
                        'mensagem' => "Uma nova encomenda de Nº identificador ".$encomenda->id." foi-lhe atribuída para futura entrega!",
                        'estado' => 1,
                    ]);


                    if (session()->get('userType') == "consumidor") {
                        $atributos_notificacao = [
                            "notificacao_id" => $notificacao_consumidor->id,
                            "notificacao_id_utilizador" => $notificacao_consumidor->id_utilizador,
                            "notificacao_mensagem" => $notificacao_consumidor->mensagem,
                            "notificacao_estado" => $notificacao_consumidor->estado,
                        ];


                    } else if (session()->get('userType') == "fornecedor") {
                        $atributos_notificacao = [
                            "notificacao_id" => $notificacao_fornecedor->id,
                            "notificacao_id_utilizador" => $notificacao_fornecedor->id_utilizador,
                            "notificacao_mensagem" => $notificacao_fornecedor->mensagem,
                            "notificacao_estado" => $notificacao_fornecedor->estado,
                        ];


                    } else if (session()->get('userType') == "transportadora") {
                        $atributos_notificacao = [
                            "notificacao_id" => $notificacao_transportadora->id,
                            "notificacao_id_utilizador" => $notificacao_transportadora->id_utilizador,
                            "notificacao_mensagem" => $notificacao_transportadora->mensagem,
                            "notificacao_estado" => $notificacao_transportadora->estado,
                        ];

                    }
                    
                    session()->push('notificacoes', $atributos_notificacao);

                }
            }
        }
    }


    public static function encomendasDoUtilizador()
    {

        $encomendas = Encomenda::where('id_consumidor', session()->get('user_id'))->orderBy('data_realizada', 'DESC')->get();

        $all_encomendas = array();

        foreach($encomendas as $encomenda) {
            $encomenda_id = $encomenda->id;
            $encomenda_preco = $encomenda->preco;
            $encomenda_preco_transporte = $encomenda->preco_transporte;
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
                "encomenda_preco_transporte" => $encomenda_preco_transporte,
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



    public static function encomenda_infos($id)
    {

        $encomenda = Encomenda::where('id', $id)->first();
        $atributos_encomenda = [
            "encomenda_id" => $encomenda->id,
            "encomenda_preco" => $encomenda->preco,
            "encomenda_preco_transporte" => $encomenda->preco_transporte,
            "encomenda_morada" => $encomenda->morada,
            "encomenda_codigo_postal" => $encomenda->codigo_postal,
            "encomenda_cidade" => $encomenda->cidade,
            "encomenda_pais" => $encomenda->pais,
            "encomenda_quantidade" => $encomenda->quantidade,
            "encomenda_data_realizada" => $encomenda->data_realizada,
            "encomenda_data_finalizada" => $encomenda->data_finalizada,
            "encomenda_id_consumidor" => $encomenda->id_consumidor,
            "encomenda_id_produto" => $encomenda->id_produto,
            "encomenda_id_transportadora" => $encomenda->id_transportadora,
            "encomenda_id_fornecedor" => $encomenda->id_fornecedor,
            "encomenda_estado_encomenda" => $encomenda->estado_encomenda,
        ];

        $produto = Produto::where('id', $encomenda->id_produto)->first();
        $atributos_produto = [
            "produto_id" => $produto->id,
            "produto_nome" => $produto->nome,
            "produto_preco" => $produto->preco,
            "produto_id_armazem" => $produto->id_armazem,
            "produto_id_fornecedor" => $produto->id_fornecedor,
            "produto_quantidade" => $produto->quantidade,
            "produto_nome_categoria" => $produto->nome_categoria,
            "produto_path_imagem" => $produto->path_imagem,
            "produto_nome_subcategoria" => $produto->nome_subcategoria,
            "produto_informacoes_adicionais" => $produto->informacoes_adicionais,
            "produto_data_producao_do_produto" => $produto->data_producao_do_produto,
            "produto_data_insercao_no_site" => $produto->data_insercao_no_site,
            "produto_kwh_consumidos_por_dia" => $produto->kwh_consumidos_por_dia_no_armazem,
            "estado" => $produto->pronto_a_vender,
        ];


        $fornecedor = Utilizador::where('id', $encomenda->id_fornecedor)->first();
        $atributos_fornecedor = [
            "fornecedor_id" => $fornecedor->id,
            "fornecedor_email" => $fornecedor->email,
            "fornecedor_primeiro_nome" => $fornecedor->primeiro_nome,
            "fornecedor_ultimo_nome" => $fornecedor->ultimo_nome,
            "fornecedor_path_imagem" => $fornecedor->path_imagem,
            "fornecedor_numero_telemovel" => $fornecedor->numero_telemovel,
            "fornecedor_numero_contribuinte" => $fornecedor->numero_contribuinte,
            "fornecedor_morada" => $fornecedor->morada,
            "fornecedor_codigo_postal" => $fornecedor->codigo_postal,
            "fornecedor_cidade" => $fornecedor->cidade,
            "fornecedor_pais" => $fornecedor->pais,
        ];

        $transportadora = Utilizador::where('id', $encomenda->id_transportadora)->first();
        $atributos_transportadora = [
            "transportadora_id" => $transportadora->id,
            "transportadora_email" => $transportadora->email,
            "transportadora_primeiro_nome" => $transportadora->primeiro_nome,
            "transportadora_ultimo_nome" => $transportadora->ultimo_nome,
            "transportadora_path_imagem" => $transportadora->path_imagem,
            "transportadora_numero_telemovel" => $transportadora->numero_telemovel,
            "transportadora_numero_contribuinte" => $transportadora->numero_contribuinte,
            "transportadora_morada" => $transportadora->morada,
            "transportadora_codigo_postal" => $transportadora->codigo_postal,
            "transportadora_cidade" => $transportadora->cidade,
            "ftransportadora_pais" => $transportadora->pais,
        ];

        session()->put('encomenda', $atributos_encomenda);
        session()->put('encomenda_produto', $atributos_produto);
        session()->put('encomenda_fornecedor', $atributos_fornecedor);
        session()->put('encomenda_transportadora', $atributos_transportadora);

        return redirect('/encomenda');



    }


    public function cancelar_encomenda()
    {
        $encomenda = Encomenda::where('id', session()->get('encomenda')['encomenda_id'])->first();

        $produto = Produto::where('id', session()->get('encomenda')['encomenda_id_produto'])->first();

        $nova_quantidade = $produto->quantidade + $encomenda->quantidade;
        $produto->quantidade = $nova_quantidade;
        $produto->save();

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A sua encomenda Nº ".$encomenda->id." foi cancelada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);


        $encomenda->delete();

        session()->forget('encomenda');
        session()->forget('encomenda_produto');
        session()->forget('encomenda_fornecedor');
        session()->forget('encomenda_transportadora');


        

        return redirect('/encomendas');
    }

}