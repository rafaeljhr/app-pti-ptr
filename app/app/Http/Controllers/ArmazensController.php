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

            $armazem_id = $armazem->id;
            $armazem_id_fornecedor = $armazem->id_fornecedor;
            $armazem_morada = $armazem->morada;
            $armazem_nome = $armazem->nome;
            $armazem_path_imagem = $armazem->path_imagem;

            $atributos_armazem = [
                "armazem_id" => $armazem_id,
                "armazem_id_fornecedor" => $armazem_id_fornecedor,
                "armazem_morada" => $armazem_morada,
                "armazem_nome" => $armazem_nome,
                "armazem_path_imagem" => $armazem_path_imagem,
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

    public function storageInfo(Request $request){

        $produtos = Produto::where('id_armazem', $request->get('id_armazem'))->get();
        $armazemNome = Armazem::where('id', $request->get('id_armazem'))->first();
        if($produtos != null  && count($produtos) ){
            $htmlP="Armazem: ";
            $htmlP .= $armazemNome->nome;
            $html =
            "<div class='row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4'>"
            ;

            $i = 0;
            foreach($produtos as $armazemSel){

                $html=$html."
                <div class='col'>
                    <div class='card'>
                        
                        <h5 class='card-title'>".$armazemNome->nome."</h5>
                        <h4 class='card-text-center text-danger'>".$armazemSel->preco." €</h4>
                        <img src='".$armazemSel->path_imagem."' class='imagemProduto card-img-top'>
                        <div class='card-body text-center'>
                            <h5 class='card-title'>Informacões adicionais: ".$armazemSel->informacoes_adicionais."</h5>                
                        </div>
                    </div>
                </div>"
                ;

                if($i > 0 && $i % 3==0) {
                    $html=$html.
                    "</div>".
                    "<div class='row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4'>"
                    ;
                }
                $i = $i + 1;
                
            }


            
        }else{
            $html ="";
            $htmlP ="Não possui nenhum produto associado ao armazem ";
            $htmlP .= $armazemNome->nome;
        }

        return array($html, $htmlP);
    }

}


