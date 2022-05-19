<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\Notificacao;
use App\Http\Controllers\ProductsController;

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
            $base_morada = $base->morada;
            $base_nome = $base->nome;
            $base_path_imagem = $base->path_imagem;
            $base_codigo_postal = $base->codigo_postal;
            $base_cidade = $base->cidade;
            $base_pais = $base->pais;

            $atributos_base = [
                "base_id" => $base_id,
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

            $base_id = $base->id;
            $base_morada = $base->morada;
            $base_nome = $base->nome;
            $base_path_imagem = $base->path_imagem;
            $base_codigo_postal = $base->codigo_postal;
            $base_cidade = $base->cidade;
            $base_pais = $base->pais;

            $atributos_base = [
                "base_id" => $base_id,
                "base_morada" => $base_morada,
                "base_nome" => $base_nome,
                "base_path_imagem" => $base_path_imagem,
                "base_codigo_postal" => $base_codigo_postal,
                "base_cidade" => $base_cidade,
                "base_pais" => $base_pais,
            ];

            array_push($all_transportadora_bases, $atributos_base);
        }

        session()->put('veiculos', $all_transportadora_veiculos);

    }

    public function armazemRegister(Request $request)
    {
        // return $request->input();
        // (new ArmazensController)->getAllArmazens(); // put all armazens of fornecedor in session
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

            $file= $request->file('path_imagem_armazem');
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

        // notificacao de criacao da base
        $primeira_notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A sua base ".$newBase->nome." foi criada!",
            'estado' => 1,
        ]);


        $atributos_novo_armazem = [
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
            session()->push('bases', $atributos_novo_armazem);
        } else {
            $armazem_info = array();
            array_push($armazem_info, $atributos_novo_armazem);
            session()->put('armazens', $armazem_info);
        }

        return redirect('/bases');

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

        $html="<button type='button'  class='btn-close' id='button-close-div'  aria-label='Close'></button>
        <p>Tem a certeza que deseja apagar o armazém ".$request->get('nome_armazem')."</p>
        <button type='button' id='buttonApagarArmazem' name='".route('armazem-delete-controller')."' onclick='apagarArmazem(".$request->get('id_armazem').")' class='btn btn-outline-danger'>Apagar</button>
        ";
        return $html;
    }



    


    public function armazemDelete(Request $request){
        
        $produto = Produto::where('id_armazem', $request->get('id_armazem'))->get();
        foreach($produto as $produtos){
            if($produtos!=null){
                Evento::where('id_produto', $produtos->id)->delete();
                if ($produtos->path_imagem != "images/default_produto.jpg") {
                    unlink($produtos->path_imagem); // apagar a imagem do produto
                }
        
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

                    
                    <button type='button' id='buttonApagarArmazemWarning' name='".route('armazem-delete-warning')."' onclick='deleteWarning('".session()->get('armazens')[$a]['armazem_id']."', '".session()->get('armazens')[$a]['armazem_nome']."')' class='btn btn-outline-danger'>Apagar</button>
                    
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


