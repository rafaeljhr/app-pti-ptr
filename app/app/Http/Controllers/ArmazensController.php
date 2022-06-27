<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Armazem;
use App\Models\Produto;
use App\Models\Evento;
use App\Models\Produto_campos_extra;
use App\Models\Notificacao;
use App\Http\Controllers\ProductsController;

class ArmazensController extends Controller
{

    public function armazemRegister(Request $request)
    {
        // return $request->input();
        (new ArmazensController)->getAllArmazens(); // put all armazens of fornecedor in session
        $request->validate([
            'nome'=>'required|string',
            'morada'=>'required|string',
            'nome'=>'required|string',
            'morada'=>'required|string',
            'codigo_postal_1'=>'required|integer',
            'codigo_postal_2'=>'required|integer',
            'cidade'=>'required|string',
            'pais'=>'required|string',
        ]);

        $codigo_postal = $request->get('codigo_postal_1') . "-" . $request->get('codigo_postal_2');

        $filename = "images/default_armazem.jpg";

        if($request->file('path_imagem_armazem')){

            $allowedMimeTypes = ['image/jpeg', 'image/jpg','image/gif','image/png'];
            $contentType = $request->file('path_imagem_armazem')->getClientMimeType();

            if(!in_array($contentType, $allowedMimeTypes) ){
                return response()->json('error: Not an image submited in the form');
            }

            $file= $request->file('path_imagem_armazem');
            $filename= uniqid().$file->getClientOriginalName();

            if (!$file-> move(public_path('images/users_images/'), $filename)) {
                return 'Error saving the file';
            }

            $filename = 'images/users_images/' . $filename;
            
        }

        $noti ="O armazem ";
        $noti .= $request->get('nome');
        $noti.=" foi criado com sucesso";

        $notis = Notificacao::create([
            'id_utilizador'=>session()->get('user_id'),
            'mensagem'=>$noti,
            'estado'=>1,
        ]);
        
        $atributos_notificacao = [
            "notificacao_id" => $notis->id,
            "notificacao_id_utilizador" => $notis->id_utilizador,
            "notificacao_mensagem" => $notis->mensagem,
            "notificacao_estado" => $notis->estado,
        ];
       
        session()->push('notificacoes', $atributos_notificacao);


        $newArmazem = Armazem::create([
            'id_fornecedor' => session()->get('user_id'),
            'morada' => $request->get('morada'),
            'nome' => $request->get('nome'),
            'path_imagem' => $filename,
            'codigo_postal' => $codigo_postal,
            'cidade'=>$request->get('cidade'),
            'pais'=>$request->get('pais'),
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
        ]);

        $idArmazem = Armazem::where('morada', $request->get('morada'))->get();


        $atributos_novo_armazem = [
            "armazem_id" => $idArmazem[0]->id,
            "armazem_id_fornecedor" => $newArmazem->id_fornecedor,
            "armazem_morada" => $newArmazem->morada,
            "armazem_nome" => $newArmazem->nome,
            "armazem_path_imagem" => $newArmazem->path_imagem,
            "armazem_zip_code"=> $newArmazem->codigo_postal,
            "armazem_cidade"=> $newArmazem->cidade,
            "armazem_pais"=> $newArmazem->pais,
            "armazem_latitude"=> $newArmazem->latitude,
            "armazem_longitude"=> $newArmazem->longitude,
        ];


        if(session()->has('armazens')){
            session()->push('armazens', $atributos_novo_armazem);
        } else {
            $armazem_info = array();
            array_push($armazem_info, $atributos_novo_armazem);
            session()->put('armazens', $armazem_info);
        } 

        return redirect('/storage');

    }


    public static function getAllArmazens()
    {
        $fornecedor_armazens = Armazem::where('id_fornecedor', session()->get('user_id'))->get();

        $all_fornecedor_armazens = array();

        foreach($fornecedor_armazens as $armazem) {

            $atributos_armazem = [
                "armazem_id" => $armazem->id,
                "armazem_id_fornecedor" => $armazem->id_fornecedor,
                "armazem_morada" => $armazem->morada,
                "armazem_nome" => $armazem->nome,
                "armazem_path_imagem" => $armazem->path_imagem,
                "armazem_latitude" => $armazem->latitude,
                "armazem_longitude" => $armazem->longitude,
            ];

            array_push($all_fornecedor_armazens, $atributos_armazem);
        }

        session()->put('armazens', $all_fornecedor_armazens);
    }


    public function deleteWarning(Request $request){

        $html="Tem a certeza que deseja apagar o armazém ".$request->get('nome_armazem')."     
        ";

        $htmlB="
        
        <input name ='id_armazem' type='hidden' value='".$request->get('id_armazem')."'>
        <button type='submit' data-bs-dismiss='modal' id='buttonApagarArmazem' class='btn btn-outline-danger'>Apagar</button>
        
        ";
        
        return array($html, $htmlB);
    }

    public function armazemDelete(Request $request){
        
        $produto = Produto::where('id_armazem', $request->get('id_armazem'))->get();
        foreach($produto as $produtos){
            if($produtos!=null){
                Evento::where('id_produto', $produtos->id)->delete();
                if ($produtos->path_imagem != "images/default_produto.jpg") {
                    unlink($produtos->path_imagem); // apagar a imagem do produto
                }
                Produto_campos_extra::where('id_produto',  $produtos->id)->delete();
                Favoritos::where('id_produto', $produtos->id)->delete();
                $produtos->delete();

                session()->forget('all_fornecedor_produtos');
                ProductsController::rebuild_fornecedor_session(); // rebuild products on session
            }
        }

        $armazem = Armazem::where('id', $request->get('id_armazem'))->first();
        
        

        session()->forget('armazem');
        if($armazem->path_imagem!=null){
            if ($armazem->path_imagem != "images/default_armazem.jpg") {
                unlink($armazem->path_imagem); // apagar a imagem do produto
            }
        }
        $armazem->delete();
        (new ArmazensController)->getAllArmazens(); // rebuild armazens of fornecedor in session
        ProductsController::rebuild_fornecedor_session();

        $noti ="O armazem ";
        $noti .= $armazem->nome;
        $noti.=" foi apagado com sucesso";

        $notis = Notificacao::create([
            'id_utilizador'=>session()->get('user_id'),
            'mensagem'=>$noti,
            'estado'=>1,
        ]);
        
        $atributos_notificacao = [
            "notificacao_id" => $notis->id,
            "notificacao_id_utilizador" => $notis->id_utilizador,
            "notificacao_mensagem" => $notis->mensagem,
            "notificacao_estado" => $notis->estado,
        ];
       
        session()->push('notificacoes', $atributos_notificacao);
        return redirect('/storage');

         
    }

    public function storageInfo($id){

        $armazem =  Armazem::where('id', $id)->first();

        $atributos_armazem= [
            "armazem_id" => $id,
            "id_fornecedor" => $armazem->id_fornecedor,
            "armazem_morada" => $armazem->morada,
            "armazem_nome" => $armazem->nome,
            "path_imagem" => $armazem->path_imagem,
            "armazem_codigo_postal" => $armazem->codigo_postal,
            "armazem_cidade" => $armazem->cidade,
            "armazem_pais" => $armazem->pais,
        ];

        session()->put('armazem_atual', $atributos_armazem);


        $armazem_produtos = Produto::where('id_armazem', $id)->get();

        $all_armazem_produtos = array();

        foreach($armazem_produtos as $produto) {

            $produto_id = $produto->id;
            $produto_nome = $produto->nome;
            $produto_preco = $produto->preco;
            $produto_id_armazem = $produto->id_armazem;
            $produto_id_fornecedor = $produto->id_fornecedor;
            $produto_quantidade = $produto->quantidade;
            $produto_nome_categoria = $produto->nome_categoria;
            $produto_path_imagem = $produto->path_imagem;
            $produto_nome_subcategoria = $produto->nome_subcategoria;
            $produto_informacoes_adicionais = $produto->informacoes_adicionais;
            $produto_data_producao_do_produto = $produto->data_producao_do_produto;
            $produto_data_insercao_no_site = $produto->data_insercao_no_site;
            $produto_kwh_consumidos_por_dia = $produto->kwh_consumidos_por_dia_no_armazem;

            $atributos_produto = [
                "produto_id" => $produto_id,
                "produto_nome" => $produto_nome,
                "produto_preco" => $produto_preco,
                "produto_id_armazem" => $produto_id_armazem,
                "produto_id_fornecedor" => $produto_id_fornecedor,
                "produto_quantidade" => $produto_quantidade,
                "produto_nome_categoria" => $produto_nome_categoria,
                "produto_path_imagem" => $produto_path_imagem,
                "produto_nome_subcategoria" => $produto_nome_subcategoria,
                "produto_informacoes_adicionais" => $produto_informacoes_adicionais,
                "produto_data_producao_do_produto" => $produto_data_producao_do_produto,
                "produto_data_insercao_no_site" => $produto_data_insercao_no_site,
                "produto_kwh_consumidos_por_dia" => $produto_kwh_consumidos_por_dia,
            ];


            array_push($all_armazem_produtos, $atributos_produto);
        }

        session()->put('armazem_actual_produtos', $all_armazem_produtos);
        return redirect('/storage-edit');
    }


    public function  armazemEdit(Request $request){
        $request->validate([
            'nome'=>'sometimes|required|string',
            'morada'=>'sometimes|required|string',
            'cidade'=>'sometimes|required|string',
            'codigo_postal_1'=>'sometimes|required|integer',
            'codigo_postal_2'=>'sometimes|required|integer',
            'pais'=>'sometimes|required|string',
        ]);

        $codigo_postal_completo = $request->codigo_postal_1."-".$request->codigo_postal_2;

        $toUpdate= [
            "nome" => $request->nome,
            "morada" => $request->morada,
            "cidade" => $request->cidade,
            "codigo_postal" => $codigo_postal_completo,
            "pais" => $request->pais,
            "preco" => $request->preco,
        ];

        
        $armazem = Armazem::where('id', session()->get('armazem_atual')['armazem_id'])->first();
        $armazem->update($toUpdate);
        
        $atributos_armazem= [
            "armazem_id" => $armazem->id,
            "id_fornecedor" => $armazem->id_fornecedor,
            "armazem_morada" => $armazem->morada,
            "armazem_nome" => $armazem->nome,
            "path_imagem" => $armazem->path_imagem,
            "armazem_codigo_postal" => $armazem->codigo_postal,
            "armazem_cidade" => $armazem->cidade,
            "armazem_pais" => $armazem->pais,
        ];

        session()->put('armazem_atual', $atributos_armazem);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A  informação do armazém '".$armazem->nome."' foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);


        self::getAllArmazens(); // put all session bases and veiculos up to date

        return redirect('/storage-edit');
    }

    public function changeImg(Request $request){
        $armazem = Armazem::where('id', session()->get('armazem_atual')['armazem_id'])->first();

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

        if (!(str_contains($armazem->path_imagem , 'http'))) {
            if ($armazem->path_imagem != "images/default_armazem.jpg") {
                unlink($armazem->path_imagem); // apagar a imagem antiga
            }
        }

        $armazem->path_imagem = $filename;
        $armazem->save();

        $atributos_armazem= [
            "armazem_id" => $armazem->id,
            "id_fornecedor" => $armazem->id_fornecedor,
            "armazem_morada" => $armazem->morada,
            "armazem_nome" => $armazem->nome,
            "path_imagem" => $armazem->path_imagem,
            "armazem_codigo_postal" => $armazem->codigo_postal,
            "armazem_cidade" => $armazem->cidade,
            "armazem_pais" => $armazem->pais,
        ];

        session()->put('armazem_atual', $atributos_armazem);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A imagem da seu armazém ".$armazem->nome." foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);


        self::getAllArmazens(); // put all session bases and veiculos up to date

        return redirect('/storage-edit');
    }

}


