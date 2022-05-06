<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Armazem;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Evento;
use App\Http\Controllers\ArmazensController;

class ProductsController extends Controller
{

    public static function getAllCategoriesAndSubcategories()
    {
        $categories = Categoria::all();

        $all_categories = array();

        foreach($categories as $category) {

            $category_nome = $category->nome;

            $atributos_category = [
                "category_nome" => $category_nome,
            ];

            array_push($all_categories, $atributos_category);
        }

        session()->put('categories', $all_categories);

        $subcategories = Subcategoria::all();

        $all_subcategories = array();

        foreach($subcategories as $subcategory) {

            $subcategory_nome = $subcategory->nome;
            $subcategory_nome_categoria = $subcategory->nome_categoria;

            $atributos_subcategory = [
                "subcategory_nome" => $subcategory_nome,
                "subcategory_nome_categoria" => $subcategory_nome_categoria,
            ];

            array_push($all_subcategories, $atributos_subcategory);
        }

        session()->put('subcategories', $all_subcategories);

    }

    public static function rebuild_fornecedor_session()
    {
        $fornecedor_produtos = Produto::where('id_fornecedor', session()->get('user_id'))->get();

        $all_fornecedor_produtos = array();

        foreach($fornecedor_produtos as $produto) {

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
            $produto_kwh_consumidos_por_dia = $produto->kwh_consumidos_por_dia;

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


            array_push($all_fornecedor_produtos, $atributos_produto);
        }

        session()->put('all_fornecedor_produtos', $all_fornecedor_produtos);

        if(!(session()->has('categories'))){
            self::getAllCategoriesAndSubcategories(); // put all categories and subcategories in session
        }

        if(!(session()->has('armazens'))){
            (new ArmazensController)->getAllArmazens(); // put all armazens of fornecedor in session
        }
        

    }


    public function productRegister(Request $request)
    {

        //return $request->input();

        $request->validate([
            'nome'=>'required|string',
            'id_armazem'=>'required|integer',
            'nome_categoria'=>'required|string',
            'nome_subcategoria'=>'required|string',
            'preco' => 'required|numeric',
            'data_producao_do_produto'=>'required|string',
            'data_insercao_no_site'=>'required|string',
            'kwh_consumidos_por_dia'=>'required|numeric',
            'quantidade' => 'required|integer',
            'informacoes_adicionais'=>'required|string',
        ]);


        $filename = "images/default_produto.jpg";

        if($request->file('path_imagem_produto')){
            
            $allowedMimeTypes = ['image/jpeg', 'image/jpg','image/gif','image/png'];
            $contentType = $request->file('path_imagem_produto')->getClientMimeType();

            if(!in_array($contentType, $allowedMimeTypes) ){
                return response()->json('error: Not an image submited in the form');
            }

            $file= $request->file('path_imagem_produto');
            $filename= uniqid().$file->getClientOriginalName();

            if (!$file-> move(public_path('images/users_images/'), $filename)) {
                return 'Error saving the file';
            }

            $filename = 'images/users_images/' . $filename;
            
        }


        $newProduto = Produto::create([
            'nome' => $request->get('nome'),
            'preco' => $request->get('preco'),
            'id_armazem' => $request->get('id_armazem'),
            'id_fornecedor' => session()->get('user_id'),
            'quantidade' => $request->get('quantidade'),
            'nome_categoria' => $request->get('nome_categoria'),
            'path_imagem' => $filename,
            'nome_subcategoria' => $request->get('nome_subcategoria'),
            'informacoes_adicionais' => $request->get('informacoes_adicionais'),
            'data_producao_do_produto' => $request->get('data_producao_do_produto'),
            'data_insercao_no_site' => $request->get('data_insercao_no_site'),
            'kwh_consumidos_por_dia' => $request->get('kwh_consumidos_por_dia')
        ]);

        $atributos_novo_produto = [
            "produto_id" => $newProduto->id,
            "produto_nome" => $newProduto->nome,
            "produto_preco" => $newProduto->preco,
            "produto_id_armazem" => $newProduto->id_armazem,
            "produto_id_fornecedor" => $newProduto->id_fornecedor,
            "produto_quantidade" => $newProduto->quantidade,
            "produto_nome_categoria" => $newProduto->nome_categoria,
            "produto_path_imagem" => $newProduto->path_imagem,
            "produto_nome_subcategoria" => $newProduto->nome_subcategoria,
            "produto_informacoes_adicionais" => $newProduto->informacoes_adicionais,
            "produto_data_producao_do_produto" => $newProduto->data_producao_do_produto,
            "produto_data_insercao_no_site" => $newProduto->data_insercao_no_site,
            "produto_kwh_consumidos_por_dia" => $newProduto->kwh_consumidos_por_dia,
        ];


        session()->push('all_fornecedor_produtos', $atributos_novo_produto);
        session()->put('last_added_product_id', $newProduto->id);
    }


    public function productRemoveLastAdded(Request $request){

        Evento::where('id_produto', session()->get('last_added_product_id'))->delete();

        $produto = Produto::where('id', session()->get('last_added_product_id'))->first();

        session()->forget('last_added_product_id');
        session()->forget('produto_cadeia_logistica');

        if ($produto->path_imagem != "images/default_produto.jpg") {
            unlink($produto->path_imagem); // apagar a imagem do produto
        }

        $produto->delete();

        self::rebuild_fornecedor_session(); // rebuild products on session
    }


    public static function productRemove(Request $request){

        Evento::where('id_produto', $request->get('id_produto'))->delete();
        
        $produto = Produto::where('id', $request->get('id_produto'))->first();

        session()->forget('all_fornecedor_produtos');

        if ($produto->path_imagem != "images/default_produto.jpg") {
            unlink($produto->path_imagem); // apagar a imagem do produto
        }

        $produto->delete();

        self::rebuild_fornecedor_session(); // rebuild products on session

        //
        // Constucao da cadeia logistica para ser mostrada no html
        //
        $html =
        "<div class='row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4'>"
        ;

        
        for($i = 0; $i < sizeOf(session()->get('all_fornecedor_produtos')); $i++) {

            $html=$html."
            <div class='col'>
                <div class='card'>
                    <button type='button' class='btn-close' id='button-close-div' aria-label='Close'></button>
                    <h5 class='card-title'>".session()->get('all_fornecedor_produtos')[$i]['produto_nome']."</h5>
                    <h4 class='card-text text-danger'>".session()->get('all_fornecedor_produtos')[$i]['produto_preco']." €</h4>
                    <img src='".session()->get('all_fornecedor_produtos')[$i]['produto_path_imagem']."' class='imagemProduto card-img-top'>
                    <div class='card-body text-center'>
                        <h5 class='card-title'>".session()->get('all_fornecedor_produtos')[$i]['produto_informacoes_adicionais']."</h5>
                        <button type='button' class='btn btn-outline-primary'>Ver informações do produto</button>
                        <br>
                        <button type='button' class='btn btn-outline-primary'>Editar</button>

                        <button type='button' id='buttonApagarProduto' name='".route('product-remove')."' onclick='apagarProduto(".session()->get('all_fornecedor_produtos')[$i]['produto_id'].")' class='btn btn-outline-danger'>Apagar</button>
                
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
            
        }


        if(sizeOf(session()->get('all_fornecedor_produtos')) % 3!=0) {
            $html=$html.
            '</div>'
            ;
        }

        return $html; //devolver a cadeia logistica do produto
    }


    public function productAddEvent(Request $request){

        $request->validate([
            'nomeCadeia'=>'required|string',
            'descricaoCadeia'=>'required|string',
        ]);

        if (!($request->has('co2_produzido'))) {
            $co2_produzido = 0;
        } else {
            $co2_produzido = $request->get('co2_produzido');
        }

        if (!($request->has('kwh_consumidos'))) {
            $kwh_consumidos = 0;
        } else {
            $kwh_consumidos = $request->get('kwh_consumidos');
        }


        $newEvento = Evento::create([
            'id_produto' => session()->get('last_added_product_id'),
            'nome' => $request->get('nomeCadeia'),
            'co2_produzido' => $co2_produzido,
            'kwh_consumidos' => $kwh_consumidos,
            'descricao_do_evento' => $request->get('descricaoCadeia'),
        ]);


        $atributos_novo_evento = [
            "evento_id_produto" => $newEvento->id_produto,
            "evento_nome" => $newEvento->nome,
            "evento_co2_produzido" => $newEvento->co2_produzido,
            "evento_kwh_consumidos" => $newEvento->kwh_consumidos,
            "evento_descricao_do_evento" => $newEvento->descricao_do_evento,
        ];


        if(session()->has('produto_cadeia_logistica')){
            session()->push('produto_cadeia_logistica', $atributos_novo_evento);
        } else {
            $produto_cadeia_logistica = array();
            array_push($produto_cadeia_logistica, $atributos_novo_evento);
            session()->put('produto_cadeia_logistica', $produto_cadeia_logistica);
        }

        //
        // Constucao da cadeia logistica para ser mostrada no html
        //
        $html =
        '<div class="row">'
        ;

        
        for($i = 0; $i < sizeOf(session()->get('produto_cadeia_logistica')); $i++) {

            $html=$html.'
            <div class="col">
              <div class="card"  style="width: 18rem;"> 
                <div class="card-body">
                  <h5 class="card-title">'.session()->get('produto_cadeia_logistica')[$i]["evento_nome"].'</h5>
                  <p class="card-text">'.session()->get('produto_cadeia_logistica')[$i]["evento_descricao_do_evento"].'</p>         
                </div>
              </div>
            </div>'
            ;

            if($i > 0 && $i % 3==0) {
                $html=$html.
                '</div>'.
                '<div class="row">'
                ;
            }
        }

        if(sizeOf(session()->get('produto_cadeia_logistica')) % 3!=0) {
            $html=$html.
            '</div>'
            ;
        }




        return $html; //devolver a cadeia logistica do produto

    }



    public function productInfo(Request $request){
       
        
        $produto = Produto::where('id', $request->get('id_produto'))->first();
        $armazem = Armazem::where('id', $produto->id_armazem)->first();
        $htmlA = "
        <div class='card' id='prudInfoA'>
                   
            <h5 class='card-title'>".$armazem->nome."</h5>
            <img src='".$armazem->path_imagem."' class='imagemProduto card-img-top'>
            
            <h5 class='card-title'>".$armazem->morada."</h5>
            

        </div>";
        $htmlE='<div class="row">'
        ;
        if(Evento::where('id_produto', $request->get('id_produto'))  != null){
            $evento = Evento::where('id_produto', $request->get('id_produto'))->get();
            $i = 0;
            foreach($evento as $eventos ){
                $htmlE=$htmlE.'
                <div class="col">
                <div class="card"  style="width: 18rem;"> 
                    <div class="card-body">
                    <h5 class="card-title">'.$eventos->nome.'</h5>
                    <p class="card-text">'.$eventos->descricao_do_evento.'</p>         
                    </div>
                </div>
                </div>'
                ;

            if($i > 0 && $i % 3==0) {
                $htmlE=$htmlE.
                '</div>'.
                '<div class="row">'
                ;
            }
            $i = $i + 1;
            }
        }

        $htmlD='<p id="toOverflow">Informações adicionais: '.$produto->informacoes_adicionais.'</p>';

        $htmlt='<p>Categoria: '.$produto->nome_categoria.'</p>
        <p>Subcategoria: '.$produto->nome_subcategoria.'</p>
        <p>Data de produção: '.$produto->data_producao_do_produto.'</p>
        <p>Data de inserção: '.$produto->data_insercao_no_site.'</p>
        <p>kwh:  '.$produto->kwh_consumidos_por_dia.'</p>
        
        ';

        return  array($htmlA, $htmlE, $htmlt, $htmlD);
    }

}