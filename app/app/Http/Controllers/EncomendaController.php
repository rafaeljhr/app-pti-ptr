<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Encomenda;
use App\Models\Estado_encomenda;
use App\Models\Produto;
use App\Models\Armazem;
use App\Models\Base;
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
                        'mensagem' => "A sua encomenda nº ".$encomenda->id." encontra-se em processamento pelo fornecedor!",
                        'estado' => 1,
                    ]);


                    // notificacao de estado ao fornecedor
                    $notificacao_fornecedor = Notificacao::create([
                        'id_utilizador' => $encomenda->id_fornecedor,
                        'mensagem' => "Uma nova encomenda de nº ".$encomenda->id." aguarda processamento!",
                        'estado' => 1,
                    ]);

                    // notificacao de estado a transportadora
                    $notificacao_transportadora = Notificacao::create([
                        'id_utilizador' => $encomenda->id_transportadora,
                        'mensagem' => "Uma nova encomenda de nº ".$encomenda->id." foi-lhe atribuída para futura entrega!",
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

        if (session()->get('userType') == "consumidor") {
            $encomendas = Encomenda::where('id_consumidor', session()->get('user_id'))->orderBy('data_realizada', 'DESC')->get();
        } else if (session()->get('userType') == "fornecedor") {
            $encomendas = Encomenda::where('id_fornecedor', session()->get('user_id'))->where('estado_encomenda', '!=', 'Cancelamento disponível')->orderBy('data_realizada', 'DESC')->get();
        } else if (session()->get('userType') == "transportadora") {
            $encomendas = Encomenda::where('id_transportadora', session()->get('user_id'))->where('estado_encomenda', '!=', 'Cancelamento disponível')->orderBy('data_realizada', 'DESC')->get();
        }

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

            $consumidor = Utilizador::where('id', $encomenda->id_consumidor)->first();
            $encomenda_consumidor_nome = $consumidor->primeiro_nome . " " . $consumidor->ultimo_nome;

            $encomenda_id_produto = $encomenda->id_produto;
            $encomenda_id_transportadora = $encomenda->id_transportadora;
            

            $transportadora = Utilizador::where('id', $encomenda->id_transportadora)->first();
            $encomenda_transportadora_nome = $transportadora->primeiro_nome . " " . $transportadora->ultimo_nome;

            $encomenda_id_base = $encomenda->id_base;

            $encomenda_id_fornecedor = $encomenda->id_fornecedor;

            $fornecedor = Utilizador::where('id', $encomenda->id_fornecedor)->first();
            $encomenda_fornecedor_nome = $fornecedor->primeiro_nome . " " . $fornecedor->ultimo_nome;

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
                "encomenda_consumidor_nome" => $encomenda_consumidor_nome,
                "encomenda_id_produto" => $encomenda_id_produto,
                "encomenda_id_transportadora" => $encomenda_id_transportadora,
                "encomenda_id_base" => $encomenda_id_base,
                "encomenda_transportadora_nome" => $encomenda_transportadora_nome,
                "encomenda_id_fornecedor" => $encomenda_id_fornecedor,
                "encomenda_fornecedor_nome" => $encomenda_fornecedor_nome,
                "encomenda_estado_encomenda" => $encomenda_estado_encomenda,
            ];

            array_push($all_encomendas, $atributos_encomenda);

        }

        session()->put('all_encomendas', $all_encomendas);

        $estados = Estado_encomenda::all();

        $all_estados_encomenda = array();

        foreach($estados as $estado) {
            $estado_nome = $estado->nome;

            $atributos_estado = [
                "estado_nome" => $estado_nome,
            ];

            array_push($all_estados_encomenda, $atributos_estado);

        }

        session()->put('all_estados', $all_estados_encomenda);

    }



    public static function encomenda_infos($id)
    {

        $encomenda = Encomenda::where('id', $id)->first();

        $consumidor = Utilizador::where('id', $encomenda->id_consumidor)->first();
        $encomenda_consumidor_nome = $consumidor->primeiro_nome . " " . $consumidor->ultimo_nome;
        $transportadora = Utilizador::where('id', $encomenda->id_transportadora)->first();
        $encomenda_transportadora_nome = $transportadora->primeiro_nome . " " . $transportadora->ultimo_nome;
        $fornecedor = Utilizador::where('id', $encomenda->id_fornecedor)->first();
        $encomenda_fornecedor_nome = $fornecedor->primeiro_nome . " " . $fornecedor->ultimo_nome;

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
            "encomenda_consumidor_nome" => $encomenda_consumidor_nome,
            "encomenda_id_produto" => $encomenda->id_produto,
            "encomenda_id_transportadora" => $encomenda->id_transportadora,
            "encomenda_transportadora_nome" => $encomenda_transportadora_nome,
            "encomenda_id_fornecedor" => $encomenda->id_fornecedor,
            "encomenda_fornecedor_nome" => $encomenda_fornecedor_nome,
            "encomenda_id_base" => $encomenda->id_base,
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

        $armazem = Armazem::where('id', $produto->id_armazem)->first();
        $atributos_armazem = [
            "armazem_id" => $armazem->id,
            "armazem_id_fornecedor" => $armazem->id_fornecedor,
            "armazem_morada" => $armazem->morada,
            "armazem_nome" => $armazem->nome,
            "armazem_path_imagem" => $armazem->path_imagem,
            "armazem_codigo_postal"=> $armazem->codigo_postal,
            "armazem_cidade"=> $armazem->cidade,
            "armazem_pais"=> $armazem->pais,
        ];


        $consumidor = Utilizador::where('id', $encomenda->id_consumidor)->first();
        $atributos_consumidor = [
            "consumidor_id" => $consumidor->id,
            "consumidor_email" => $consumidor->email,
            "consumidor_primeiro_nome" => $consumidor->primeiro_nome,
            "consumidor_ultimo_nome" => $consumidor->ultimo_nome,
            "consumidor_path_imagem" => $consumidor->path_imagem,
            "consumidor_numero_telemovel" => $consumidor->numero_telemovel,
            "consumidor_numero_contribuinte" => $consumidor->numero_contribuinte,
            "consumidor_morada" => $consumidor->morada,
            "consumidor_codigo_postal" => $consumidor->codigo_postal,
            "consumidor_cidade" => $consumidor->cidade,
            "consumidor_pais" => $consumidor->pais,
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


        $base = Base::where('id', $encomenda->id_base)->first();
        $atributos_base= [
            "base_id" => $base->id,
            "base_id_transportadora" => $base->id_transportadora,
            "base_morada" => $base->morada,
            "base_codigo_postal" => $base->codigo_postal,
            "base_cidade" => $base->cidade,
            "base_pais" => $base->pais,
            "base_nome" => $base->nome,
            "base_path_imagem" => $base->path_imagem,
        ];

        session()->put('encomenda', $atributos_encomenda);
        session()->put('encomenda_produto', $atributos_produto);
        session()->put('encomenda_produto_armazem', $atributos_armazem);
        session()->put('encomenda_consumidor', $atributos_consumidor);
        session()->put('encomenda_fornecedor', $atributos_fornecedor);
        session()->put('encomenda_transportadora', $atributos_transportadora);
        session()->put('encomenda_base', $atributos_base);

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



    public function alterar_estado_encomenda(Request $request)
    {

        $estados = Estado_encomenda::all();

        $match = false;
        foreach ($estados as $estado) {
            if ($request->estado == $estado->nome) {
                $match = true;
            }
        }

        if (!$match) {
            return "Tentativa de colocação de estado inválido na encomenda";
        }
        

        $encomenda = Encomenda::where('id', session()->get('encomenda')['encomenda_id'])->first();

        $encomenda->estado_encomenda = $request->estado;
        $encomenda->save();

        $consumidor = Utilizador::where('id', $encomenda->id_consumidor)->first();
        $encomenda_consumidor_nome = $consumidor->primeiro_nome . " " . $consumidor->ultimo_nome;
        $transportadora = Utilizador::where('id', $encomenda->id_transportadora)->first();
        $encomenda_transportadora_nome = $transportadora->primeiro_nome . " " . $transportadora->ultimo_nome;
        $fornecedor = Utilizador::where('id', $encomenda->id_fornecedor)->first();
        $encomenda_fornecedor_nome = $fornecedor->primeiro_nome . " " . $fornecedor->ultimo_nome;

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
            "encomenda_consumidor_nome" => $encomenda_consumidor_nome,
            "encomenda_id_produto" => $encomenda->id_produto,
            "encomenda_id_transportadora" => $encomenda->id_transportadora,
            "encomenda_transportadora_nome" => $encomenda_transportadora_nome,
            "encomenda_id_base" => $encomenda->id_base,
            "encomenda_id_fornecedor" => $encomenda->id_fornecedor,
            "encomenda_fornecedor_nome" => $encomenda_fornecedor_nome,
            "encomenda_estado_encomenda" => $encomenda->estado_encomenda,
        ];

        session()->put('encomenda', $atributos_encomenda);


        // notificacao de estado ao consumidor
        $notificacao_consumidor = Notificacao::create([
            'id_utilizador' => $encomenda->id_consumidor,
            'mensagem' => "A sua encomenda nº ".$encomenda->id." encontra-se agora no estado '". $request->estado ."'",
            'estado' => 1,
        ]);


        // notificacao de estado ao fornecedor
        $notificacao_fornecedor = Notificacao::create([
            'id_utilizador' => $encomenda->id_fornecedor,
            'mensagem' => "A encomenda de nº ".$encomenda->id." passou ao estado '". $request->estado ."'",
            'estado' => 1,
        ]);

        // notificacao de estado a transportadora
        $notificacao_transportadora = Notificacao::create([
            'id_utilizador' => $encomenda->id_transportadora,
            'mensagem' => "A encomenda de nº ".$encomenda->id." passou ao estado '". $request->estado ."'",
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

        return redirect('/encomenda');

    }

}