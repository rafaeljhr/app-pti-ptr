<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\Veiculo;
use App\Models\Notificacao;
use App\Models\Tipo_de_combustivel;

class BasesController extends Controller
{

    public static function rebuild_transportadora_session() 
    {

        //
        // BASES
        //
        $transportadora_bases = Base::where('id_transportadora', session()->get('user_id'))->get();

        $all_transportadora_bases = array();

        foreach($transportadora_bases as $base) {

            $base_id = $base->id;
            $base_id_transportadora = $base->id_transportadora;
            $base_morada = $base->morada;
            $base_nome = $base->nome;
            $base_path_imagem = $base->path_imagem;
            $base_codigo_postal = $base->codigo_postal;
            $base_cidade = $base->cidade;
            $base_pais = $base->pais;

            $atributos_base = [
                "base_id" => $base_id,
                "base_id_transportadora" => $base_id_transportadora,
                "base_morada" => $base_morada,
                "base_nome" => $base_nome,
                "base_path_imagem" => $base_path_imagem,
                "base_codigo_postal" => $base_codigo_postal,
                "base_cidade" => $base_cidade,
                "base_pais" => $base_pais,
            ];

            array_push($all_transportadora_bases, $atributos_base);
        }

        session()->put('bases', $all_transportadora_bases);

        //
        // VEICULOS
        //
        $transportadora_veiculos = Veiculo::where('id_transportadora', session()->get('user_id'))->get();

        $all_transportadora_veiculos = array();

        foreach($transportadora_veiculos as $veiculo) {

            $veiculo_id = $veiculo->id;
            $veiculo_id_base = $veiculo->id_base;
            $veiculo_id_transportadora = $veiculo->id_transportadora;
            $veiculo_nome = $veiculo->nome;
            $veiculo_quantidade = $veiculo->quantidade;
            $veiculo_tipoCombustivel = $veiculo->tipoCombustivel;
            $veiculo_consumo_por_100km = $veiculo->consumo_por_100km;
            $veiculo_path_imagem = $veiculo->path_imagem;

            $atributos_veiculo = [
                "veiculo_id" => $veiculo_id,
                "veiculo_id_base" => $veiculo_id_base,
                "veiculo_id_transportadora" => $veiculo_id_transportadora,
                "veiculo_nome" => $veiculo_nome,
                "veiculo_quantidade" => $veiculo_quantidade,
                "veiculo_tipoCombustivel" => $veiculo_tipoCombustivel,
                "veiculo_consumo_por_100km" => $veiculo_consumo_por_100km,
                "veiculo_path_imagem" => $veiculo_path_imagem,
            ];

            array_push($all_transportadora_veiculos, $atributos_veiculo);
        }

        session()->put('veiculos', $all_transportadora_veiculos);

        //
        // Tipos de combustivel
        //
        if(!(session()->has('tipos_combustivel'))){

            $tipos_combustivel = Tipo_de_combustivel::all();

            $all_tipos_combustivel = array();

            foreach($tipos_combustivel as $tipo) {

                $tipos_combustivel_nome = $tipo->nome;
                $tipos_combustivel_co2_por_km = $tipo->co2_por_km;

                $atributos_tipo_combustivel= [
                    "tipos_combustivel_nome" => $tipos_combustivel_nome,
                    "tipos_combustivel_co2_por_km" => $tipos_combustivel_co2_por_km,
                ];

                array_push($all_tipos_combustivel, $atributos_tipo_combustivel);
            }

            session()->put('tipos_combustivel', $all_tipos_combustivel);
            
        }

        
    }

    public function baseRegister(Request $request)
    {
        $request->validate([
            'nome'=>'required|string',
            'morada'=>'required|string',
            'codigo_postal_1'=>'required|string',
            'codigo_postal_2'=>'required|string',
            'cidade'=>'required|string',
            'pais'=>'required|string',
        ]);

        $filename = "images/default_base.jpg";

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

        $codigo_postal = $request->get('codigo_postal_1') . "-" . $request->get('codigo_postal_2');

        $newBase = Base::create([
            'id_transportadora' => session()->get('user_id'),
            'morada' => $request->get('morada'),
            'codigo_postal' => $codigo_postal,
            'cidade' => $request->get('cidade'),
            'pais' => $request->get('morada'),
            'nome' => $request->get('nome'),
            'path_imagem' => $filename,
        ]);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A sua base '".$newBase->nome."' foi criada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);

        $atributos_nova_base= [
            "base_id" => $newBase->id,
            "base_id_transportadora" => $newBase->id_transportadora,
            "base_morada" => $newBase->morada,
            "base_codigo_postal" => $newBase->codigo_postal,
            "base_cidade" => $newBase->cidade,
            "base_pais" => $newBase->pais,
            "base_nome" => $newBase->nome,
            "base_path_imagem" => $newBase->path_imagem,
        ];


        if(session()->has('bases')){
            session()->push('bases', $atributos_nova_base);
        } else {
            $armazem_info = array();
            array_push($armazem_info, $atributos_nova_base);
            session()->put('armazens', $armazem_info);
        }

        return redirect('/bases');

    }



    public function baseInformacoes($id)
    {
        $base = Base::where('id', $id)->first();

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

        session()->put('base', $atributos_base);

        $veiculos = Veiculo::where('id_base', $base->id)->get();

        $all_veiculos = array();

        foreach($veiculos as $veiculo) {

            $veiculo_id = $veiculo->id;
            $veiculo_id_base = $veiculo->id_base;
            $veiculo_id_transportadora = $veiculo->id_transportadora;
            $veiculo_nome = $veiculo->nome;
            $veiculo_quantidade = $veiculo->quantidade;
            $veiculo_tipoCombustivel = $veiculo->tipoCombustivel;
            $veiculo_consumo_por_100km = $veiculo->consumo_por_100km;
            $veiculo_path_imagem = $veiculo->path_imagem;

            $atributos_veiculo = [
                "veiculo_id" => $veiculo_id,
                "veiculo_id_base" => $veiculo_id_base,
                "veiculo_id_transportadora" => $veiculo_id_transportadora,
                "veiculo_nome" => $veiculo_nome,
                "veiculo_quantidade" => $veiculo_quantidade,
                "veiculo_tipoCombustivel" => $veiculo_tipoCombustivel,
                "veiculo_consumo_por_100km" => $veiculo_consumo_por_100km,
                "veiculo_path_imagem" => $veiculo_path_imagem,
            ];

            array_push($all_veiculos, $atributos_veiculo);
        }

        session()->put('base_veiculos', $all_veiculos);
        

        return redirect('/base');

    }


    public function changeImagem(Request $request)
    {
        
        $base = Base::where('id', session()->get('base')['base_id'])->first();

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

        if (!(str_contains($base->path_imagem , 'http'))) {
            if ($base->path_imagem != "images/default_base.jpg") {
                unlink($base->path_imagem); // apagar a imagem antiga
            }
        }

        $base->path_imagem = $filename;
        $base->save();

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

        session()->put('base', $atributos_base);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A imagem da sua base '".$base->nome."' foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);


        self::rebuild_transportadora_session(); // put all session bases and veiculos up to date

        return redirect('/base');

    }



    public function baseEdit(Request $request)
    {
        $request->validate([
            'nome'=>'sometimes|required|string',
            'morada'=>'sometimes|required|string',
            'cidade'=>'sometimes|required|string',
            'codigo_postal_1'=>'sometimes|required|integer',
            'codigo_postal_2'=>'sometimes|required|integer',
            'pais'=>'sometimes|required|string',
        ]);

        
        $base = Base::where('id', session()->get('base')['base_id'])->first();
        $base->update($request->all());
        
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

        session()->put('base', $atributos_base);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "As informações da sua base '".$base->nome."' foram atualizadas!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);

        self::rebuild_transportadora_session(); // put all session bases and veiculos up to date

        return redirect('/base');

    }


    public function baseDelete()
    {
        $base = Base::where('id', session()->get('base')['base_id'])->first();

        $veiculos = Veiculo::where('id_base', session()->get('base')['base_id'])->get();
        foreach ($veiculos as $veiculo) {
            if (!(str_contains($veiculo->path_imagem , 'http'))) {
                if ($veiculo->path_imagem != "images/default_veiculo.png") {
                    unlink($veiculo->path_imagem); // apagar a imagem antiga
                }
            }
        }
        Veiculo::where('id_base', session()->get('base')['base_id'])->delete();

        if (!(str_contains($base->path_imagem , 'http'))) {
            if ($base->path_imagem != "images/default_base.jpg") {
                unlink($base->path_imagem); // apagar a imagem antiga
            }
        }

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A sua base '".$base->nome."' foi apagada e todos os veículos associados à mesma!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);

        $base->delete();

        self::rebuild_transportadora_session(); // put all session bases and veiculos up to date

        return redirect('/bases');
    }

}