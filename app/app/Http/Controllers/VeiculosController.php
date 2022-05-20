<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Veiculo;
use App\Models\Notificacao;

class VeiculosController extends Controller
{

    public function veiculoRegister(Request $request)
    {
        $request->validate([
            'nome'=>'required|string',
            'tipo_combustivel'=>'required|string',
            'consumo_por_100km'=>'required|string',
            'id_base'=>'required|string',
            'quantidade'=>'required|string',
        ]);
        
        $filename = "images/default_veiculo.png";

        if($request->file('path_imagem')){

            $allowedMimeTypes = ['image/jpeg', 'image/jpg','image/gif','image/png'];
            $contentType = $request->file('path_imagem')->getClientMimeType();

            if(!in_array($contentType, $allowedMimeTypes) ){
                return response()->json('error: Not an image submited in the form');
            }

            $file= $request->file('path_imagem');
            $filename= uniqid().$file->getClientOriginalName();

            if (!$file-> move(public_path('images/users_images/'), $filename)) {
                return 'Error saving the file';
            }

            $filename = 'images/users_images/' . $filename;
            
        }
        
        $newVeiculo = Veiculo::create([
            'id_base' => $request->get('id_base'),
            'id_transportadora' => session()->get('user_id'),
            'nome' => $request->get('nome'),
            'quantidade' => $request->get('quantidade'),
            'tipoCombustivel' => $request->get('tipo_combustivel'),
            'consumo_por_100km' => $request->get('consumo_por_100km'),
            'path_imagem' => $filename,
        ]);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "O seu veículo '".$newVeiculo->nome."' foi criado!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);


        $atributos_novo_veiculo = [
            "veiculo_id" => $newVeiculo->id,
            "veiculo_id_base" => $newVeiculo->id_base,
            "veiculo_id_transportadora" => $newVeiculo->id_transportadora,
            "veiculo_nome" => $newVeiculo->nome,
            "veiculo_quantidade" => $newVeiculo->quantidade,
            "veiculo_tipoCombustivel" => $newVeiculo->tipoCombustivel,
            "veiculo_consumo_por_100km" => $newVeiculo->consumo_por_100km,
            "veiculo_path_imagem" => $newVeiculo->path_imagem,
        ];


        if(session()->has('veiculos')){
            session()->push('veiculos', $atributos_novo_veiculo);
        } else {
            $veiculos = array();
            array_push($veiculos, $atributos_novo_veiculo);
            session()->put('veiculos', $veiculos);
        }

        return redirect('/veiculos');

    }



    public function veiculoInformacoes($id)
    {
        $veiculo = Veiculo::where('id', $id)->first();

        $atributos_veiculo = [
            "veiculo_id" => $veiculo->id,
            "veiculo_id_base" => $veiculo->id_base,
            "veiculo_id_transportadora" => $veiculo->id_transportadora,
            "veiculo_nome" => $veiculo->nome,
            "veiculo_quantidade" => $veiculo->quantidade,
            "veiculo_tipoCombustivel" => $veiculo->tipoCombustivel,
            "veiculo_consumo_por_100km" => $veiculo->consumo_por_100km,
            "veiculo_path_imagem" => $veiculo->path_imagem,
        ];

        session()->put('veiculo', $atributos_veiculo);

        return redirect('/veiculo');

    }


    public function changeImagem(Request $request)
    {
        
        $veiculo = Veiculo::where('id', session()->get('veiculo')['veiculo_id'])->first();

        if($request->file('mudar_path_imagem')){
                
            $allowedMimeTypes = ['image/jpeg', 'image/jpg','image/gif','image/png'];
            $contentType = $request->file('mudar_path_imagem')->getClientMimeType();

            if(!in_array($contentType, $allowedMimeTypes) ){
                return response()->json('error: Not an image submited in the form');
            }

            $file= $request->file('mudar_path_imagem');
            $filename= uniqid().$file->getClientOriginalName();

            if (!$file-> move(public_path('images/users_images/'), $filename)) {
                return 'Error saving the file';
            }

            $filename = 'images/users_images/' . $filename;
            
        } else {
            return "falhou mudar avatar";
        }

        if (!(str_contains($veiculo->path_imagem , 'http'))) {
            if ($veiculo->path_imagem != "images/default_veiculo.png") {
                unlink($veiculo->path_imagem); // apagar a imagem antiga
            }
        }

        $veiculo->path_imagem = $filename;
        $veiculo->save();

        $atributos_veiculo = [
            "veiculo_id" => $veiculo->id,
            "veiculo_id_base" => $veiculo->id_base,
            "veiculo_id_transportadora" => $veiculo->id_transportadora,
            "veiculo_nome" => $veiculo->nome,
            "veiculo_quantidade" => $veiculo->quantidade,
            "veiculo_tipoCombustivel" => $veiculo->tipoCombustivel,
            "veiculo_consumo_por_100km" => $veiculo->consumo_por_100km,
            "veiculo_path_imagem" => $veiculo->path_imagem,
        ];

        session()->put('veiculo', $atributos_veiculo);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A imagem do seu veículo '".$veiculo->nome."' foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);


        BasesController::rebuild_transportadora_session();

        return redirect('/veiculo');

    }



    public function veiculoEdit(Request $request)
    {
        $request->validate([
            'nome'=>'sometimes|required|string',
            'tipoCombustivel'=>'sometimes|required|string',
            'consumo_por_100km'=>'sometimes|required|string',
            'id_base'=>'sometimes|required|string',
            'quantidade'=>'sometimes|required|string',
        ]);
        
        $veiculo = Veiculo::where('id', session()->get('veiculo')['veiculo_id'])->first();
        $veiculo->update($request->all());
        
        $atributos_veiculo = [
            "veiculo_id" => $veiculo->id,
            "veiculo_id_base" => $veiculo->id_base,
            "veiculo_id_transportadora" => $veiculo->id_transportadora,
            "veiculo_nome" => $veiculo->nome,
            "veiculo_quantidade" => $veiculo->quantidade,
            "veiculo_tipoCombustivel" => $veiculo->tipoCombustivel,
            "veiculo_consumo_por_100km" => $veiculo->consumo_por_100km,
            "veiculo_path_imagem" => $veiculo->path_imagem,
        ];

        session()->put('veiculo', $atributos_veiculo);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "As informações do seu veículo '".$veiculo->nome."' foram atualizadas!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);

        BasesController::rebuild_transportadora_session();

        return redirect('/veiculo');

    }


    public function veiculoDelete()
    {
        $veiculo = Veiculo::where('id', session()->get('veiculo')['veiculo_id'])->first();

        if (!(str_contains($veiculo->path_imagem , 'http'))) {
            if ($veiculo->path_imagem != "images/default_veiculo.png") {
                unlink($veiculo->path_imagem); // apagar a imagem antiga
            }
        }

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "O seu veículo '".$veiculo->nome."' foi apagado!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);

        $veiculo->delete();

        BasesController::rebuild_transportadora_session();

        return redirect('/veiculos');
    }

}


