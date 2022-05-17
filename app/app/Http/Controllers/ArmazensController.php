<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Armazem;
use App\Models\Produto;
use App\Models\Evento;
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
        ]);

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


        $newArmazem = Armazem::create([
            'id_fornecedor' => session()->get('user_id'),
            'morada' => $request->get('morada'),
            'nome' => $request->get('nome'),
            'path_imagem' => $filename,
        ]);

        $idArmazem = Armazem::where('morada', $request->get('morada'))->get();


        $atributos_novo_armazem = [
            "armazem_id" => $idArmazem[0]->id,
            "armazem_id_fornecedor" => $newArmazem->id_fornecedor,
            "armazem_morada" => $newArmazem->morada,
            "armazem_nome" => $newArmazem->nome,
            "armazem_path_imagem" => $newArmazem->path_imagem,
        ];


        if(session()->has('armazens')){
            session()->push('armazens', $atributos_novo_armazem);
        } else {
            $armazem_info = array();
            array_push($armazem_info, $atributos_novo_armazem);
            session()->put('armazens', $armazem_info);
        }

        //
        // Constucao do armazém para ser mostrado no html
        //
        $htmlA =
        '<div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">'
        ;

        
        for($a = 0; $a < sizeOf(session()->get('armazens')); $a++) {


            $htmlA=$htmlA."
            <div class='col'>
                <div class='card'>
                   
                    <h5 class='card-title'>".session()->get('armazens')[$a]['armazem_nome']."</h5>
                    <img src='".session()->get('armazens')[$a]['armazem_path_imagem']."' class='imagemProduto card-img-top'>
                    <div class='card-body text-center'>
                    <h4 class='card-title'>".session()->get('armazens')[$a]['armazem_morada']."</h4>
                    <button id='storageInfo' name='". route('storage-info')."' type='button' onclick='infoAdicional('".session()->get('armazens')[$a]['armazem_id']."', '".session()->get('armazens')[$a]['armazem_nome']."')' class='btn btn-outline-primary'>info</button>
                    <br>
                    <button type='button' class='btn btn-outline-primary'>Editar</button>

                    <button type='button' id='buttonApagarArmazem' name='".route('armazem-delete-controller')."' onclick='apagarArmazem(".session()->get('armazens')[$a]['armazem_id'].")' class='btn btn-outline-danger'>Apagar</button>
                    </div>
                </div>
            </div>"
            ;

            if($a > 0 && $a % 3==0) {
                $htmlA=$htmlA.
                '</div>'.
                
                '<div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">'
                ;
            }
        }

        if(sizeOf(session()->get('armazens')) % 3!=0) {
            $htmlA=$htmlA.
            '</div>'
           
            ;
        }

        return $htmlA; //devolver a cadeia logistica do produto

        

        //return redirect('/inventory');

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



    


    public function armazemDelete(Request $request){
        
        $produto = Produto::where('id_armazem', $request->get('id_armazem'))->first();
       
        if($produto!=null){
            Evento::where('id_produto', $produto->id)->delete();
            if ($produto->path_imagem != "images/default_produto.jpg") {
                unlink($produto->path_imagem); // apagar a imagem do produto
            }
    
            $produto->delete();
            session()->forget('all_fornecedor_produtos');
            ProductsController::rebuild_fornecedor_session(); // rebuild products on session
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

        $htmlA =
        '<div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">'
        ;

        
        for($a = 0; $a < sizeOf(session()->get('armazens')); $a++) {


            $htmlA=$htmlA."
            <div class='col'>
                <div class='card'>
                   
                    <h5 class='card-title'>".session()->get('armazens')[$a]['armazem_nome']."</h5>
                    <img src='".session()->get('armazens')[$a]['armazem_path_imagem']."' class='imagemProduto card-img-top'>
                    
                    <div class='card-body text-center'>

                    <h4 class='card-text'>".session()->get('armazens')[$a]['armazem_morada']."</h4>
                    <button id='storageInfo' name='".route('storage-info')."' type='button' onclick='infoAdicional('".session()->get('armazens')[$a]['armazem_id']."', '".session()->get('armazens')[$a]['armazem_nome']."')' class='btn btn-outline-primary'>info</button>
                    <br>
                    <button type='button' class='btn btn-outline-primary'>Editar</button>

                    <button type='button' id='buttonApagarArmazem' name='".route('armazem-delete-controller')."' onclick='apagarArmazem(".session()->get('armazens')[$a]['armazem_id'].")' class='btn btn-outline-danger'>Apagar</button>
                
                    
                    </div>
                </div>
            </div>"
            ;

            if($a > 0 && $a % 3==0) {
                $htmlA=$htmlA.
                '</div>'.
                
                '<div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">'
                ;
            }
        }

        if(sizeOf(session()->get('armazens')) % 3!=0) {
            $htmlA=$htmlA.
            '</div>'
           
            ;
        }

        return $htmlA; 
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


