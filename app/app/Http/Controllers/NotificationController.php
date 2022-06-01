<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notificacao;

class NotificationController extends Controller
{

    public static function obter_notificacoes_do_utilizador() {
        $notificacoes = Notificacao::where('id_utilizador', session()->get('user_id'))->where('estado','1')->get();
                
        $all_notificacoes = array();

        foreach($notificacoes as $notificacao) {

            $notificacao_id = $notificacao->id;
            $notificacao_id_utilizador = $notificacao->id_utilizador;
            $notificacao_mensagem = $notificacao->mensagem;
            $notificacao_estado = $notificacao->id;

            $atributos_notificacao = [
                "notificacao_id" => $notificacao_id,
                "notificacao_id_utilizador" => $notificacao_id_utilizador,
                "notificacao_mensagem" => $notificacao_mensagem,
                "notificacao_estado" => $notificacao_estado,
            ];

            array_push($all_notificacoes, $atributos_notificacao);
        }

        session()->put('notificacoes', $all_notificacoes);
    }

    public function hideNotification(Request $request)
    {

        //return $request;

        $notificacao = Notificacao::where('id', $request->id)->first();
        $notificacao->estado = 0;
        $notificacao->save();

        // rebuild user notification on session
        $notificacoes = Notificacao::where('id_utilizador', session()->get('user_id'))->where('estado','1')->get();

        $all_notificacoes = array();

        foreach($notificacoes as $notificacao) {

            $notificacao_id = $notificacao->id;
            $notificacao_id_utilizador = $notificacao->id_utilizador;
            $notificacao_mensagem = $notificacao->mensagem;
            $notificacao_estado = $notificacao->id;

            $atributos_notificacao = [
                "notificacao_id" => $notificacao_id,
                "notificacao_id_utilizador" => $notificacao_id_utilizador,
                "notificacao_mensagem" => $notificacao_mensagem,
                "notificacao_estado" => $notificacao_estado,
            ];

            array_push($all_notificacoes, $atributos_notificacao);
        }

        session()->put('notificacoes', $all_notificacoes);

    }


}