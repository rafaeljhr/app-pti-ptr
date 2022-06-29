<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use URL;

use App\Models\Produto;
use App\Models\Armazem;
use App\Models\Base;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Evento;
use App\Models\Notificacao;
use App\Models\Categoria_campos_extra;
use App\Models\Produto_campos_extra;
use App\Models\Favoritos;
use App\Models\Fornecedor_historico_poluicao;
use App\Http\Controllers\ArmazensController;
use App\Models\Utilizador;
use DateTime;

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

        $favs = Favoritos::where('id_utilizador', session()->get('user_id'))->get();

        $all_favs = array();

        foreach($favs as $fav1) {

            $fav_id = $fav1->id;
            $fav_id_utilizador = $fav1->id_utilizador;
            $fav_id_produto = $fav1->id_produto;
            $fav_mensagem = $fav1->mensagem;

            $atributos_favoritos = [
                "fav_id" => $fav_id,
                "fav_id_utilizador" => $fav_id_utilizador,
                "fav_id_produto" => $fav_id_produto,
                "fav_mensagem" => $fav_mensagem,
            ];

            array_push($all_favs, $atributos_favoritos);
        }

        session()->put('favoritos', $all_favs);


        $fornecedor_produtos = Produto::where('id_fornecedor', session()->get('user_id'))->get();
        
        $all_fornecedor_produtos = array();

        $all_fornecedor_produtos_incidentes = array();
    
        foreach($fornecedor_produtos as $produto) {

            // VER SE O PRODUTO É DA CATEGORIA ALIMENTOS E SE É NECESSÁRIO ALERTAR SOBRE O PRAZO DE VALIDADE
            $campo_extra = Produto_campos_extra::where('id_produto', $produto->id)->get();
            foreach($campo_extra as $campo) {
                if ($campo->campo_extra == 'prazo_de_validade') {

                    $produto = Produto::where('id', $campo->id_produto)->first();

                    if ($produto->quantidade_produto_expirada == 0) {

                        list($day, $month, $year) = explode('/', $campo->valor_campo);
                        $validade = $year."-".$month."-".$day;
                        $validade_real = strtotime($validade);
                        
                        $atual = new DateTime();
                        $hoje = strtotime($atual->format('Y-m-d'));

                        $datediff = $validade_real - $hoje;

                        $diffInDays = round($datediff / (60 * 60 * 24));

                        if($diffInDays < 10 && ($diffInDays > 0)) {

                            $notis = Notificacao::create([
                                'id_utilizador'=>session()->get('user_id'),
                                'mensagem'=>"O produto " . $produto->nome . " tem apenas mais " . $diffInDays . " dias de validade!",
                                'estado'=>1,
                            ]);
                            
                            $atributos_notificacao = [
                                "notificacao_id" => $notis->id,
                                "notificacao_id_utilizador" => $notis->id_utilizador,
                                "notificacao_mensagem" => $notis->mensagem,
                                "notificacao_estado" => $notis->estado,
                            ];
                        
                            session()->push('notificacoes', $atributos_notificacao);

                        } else if ($diffInDays <= 0) {

                            if ($produto->quantidade > 0) {

                                $atributo_to_update = [
                                    'quantidade' => 0,
                                    'quantidade_produto_expirada' => $produto->quantidade,
                                ];
                                $produto->update($atributo_to_update);

                                $notis = Notificacao::create([
                                    'id_utilizador'=>session()->get('user_id'),
                                    'mensagem'=>"O produto " . $produto->nome . " expirou o prazo de validade e foi movido para 'Incidentes'!",
                                    'estado'=>1,
                                ]);
                                
                                $atributos_notificacao = [
                                    "notificacao_id" => $notis->id,
                                    "notificacao_id_utilizador" => $notis->id_utilizador,
                                    "notificacao_mensagem" => $notis->mensagem,
                                    "notificacao_estado" => $notis->estado,
                                ];
                            
                                session()->push('notificacoes', $atributos_notificacao);

                            }

                        }
                    }
                }
            }


            $eventos_logisticos = Evento::where('id_produto', $produto->id)->get();

            if (sizeOf($eventos_logisticos) > 0) {
                $tem_eventos_logisticos = 1;
            } else {
                $tem_eventos_logisticos = 0;
            }

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
                "produto_tem_eventos_logisticos" => $tem_eventos_logisticos,
                "pronto_a_vender" => $produto->pronto_a_vender,
                "produto_quantidade_produto_expirada" => $produto->quantidade_produto_expirada,
                "produto_quantidade_produto_incidentes_transporte" => $produto->quantidade_produto_incidentes_transporte,
            ];

            if ($produto->quantidade_produto_expirada > 0 || $produto->quantidade_produto_incidentes_transporte > 0) {
                array_push($all_fornecedor_produtos_incidentes, $atributos_produto);
            } else {
                array_push($all_fornecedor_produtos, $atributos_produto);
            }

            
        }

        session()->put('all_fornecedor_produtos', $all_fornecedor_produtos);
        session()->put('all_fornecedor_produtos_incidentes', $all_fornecedor_produtos_incidentes);

        if(!(session()->has('categories'))){
            self::getAllCategoriesAndSubcategories(); // put all categories and subcategories in session
        }

        if(!(session()->has('armazens'))){
            (new ArmazensController)->getAllArmazens(); // put all armazens of fornecedor in session
        }


    }


    public function productRegister(Request $request)
    {
        //dd($campos_extra);
       
        $catField = Categoria_campos_extra::where('nome_categoria', $request->get('nome_categoria'))->get();


        if($catField==null){
            
        }
        $request->validate([
            'nome'=>'required|string',
            'id_armazem'=>'required|string',
            'nome_categoria'=>'required|string',
            'nome_subcategoria'=>'required|string',
            'preco' => 'required|numeric',
            'data_producao_do_produto'=>'required|string',
            'data_insercao_no_site'=>'required|string',
            'kwh_consumidos_por_dia'=>'required|numeric',
            'quantidade' => 'required|string',
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
            'nome_subcategoria' => $request->get('nome_subcategoria'),
            'path_imagem' => $filename,          
            'informacoes_adicionais' => $request->get('informacoes_adicionais'),
            'data_producao_do_produto' => $request->get('data_producao_do_produto'),
            'data_insercao_no_site' => $request->get('data_insercao_no_site'),
            'kwh_consumidos_por_dia_no_armazem' => $request->get('kwh_consumidos_por_dia'),
            'pronto_a_vender' => 0,
        ]);

        foreach($catField as $catFields){
            
            $name_field = $catFields->campo_extra;
            
            $string_check = htmlentities( $request->get($name_field) , ENT_QUOTES, "UTF-8");
            Produto_campos_extra::create([
                'id_produto' => $newProduto->id,
                'campo_extra' => $name_field,
                'valor_campo' => $string_check
            ]);
        }

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
            "produto_kwh_consumidos_por_dia" => $newProduto->kwh_consumidos_por_dia_no_armazem,
            "pronto_a_vender" => $newProduto->pronto_a_vender,
        ];

        $noti ="O Produto ";
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

        session()->push('all_fornecedor_produtos', $atributos_novo_produto);

        return redirect('/inventory');
    }


    public function productEdit(Request  $request){
        //$request->input();
        $request->validate([
            'nome'=>'sometimes|required|string',
            'preco'=>'sometimes|required|string',
            'quantidade'=>'sometimes|required|string',
            'data_p'=>'sometimes|required|string',
            'data_i'=>'sometimes|required|string',
            'kwh'=>'sometimes|required|string',
            'info'=>'sometimes|required|string',
            'nome_categoria'=> 'sometimes|required|string',
            'nome_subcategoria'=>'sometimes|required|string',
        ]);
        
        $produto = Produto::where('id', session()->get('produto_atual')['produto_id'])->first();
        $atributo_to_update = [
            'nome' => $request->nome,
            'preco' => $request->preco,
            'id_armazem' => session()->get('produto_atual')['produto_id_armazem'],
            'id_fornecedor' => session()->get('user_id'),
            'quantidade' => $request->quantidade,
            'nome_subcategoria' => session()->get('produto_atual')['produto_nome_subcategoria'],
            'path_imagem' => session()->get('produto_atual')['produto_path_imagem'],       
            'informacoes_adicionais' => $request->info,
            'data_producao_do_produto' => $request->data_p,
            'data_insercao_no_site' => $request->data_i,
            'kwh_consumidos_por_dia_no_armazem' => $request->kwh,
            'pronto_a_vender' => session()->get('produto_atual')['pronto_a_vender'],
        ];
        $produto->update($atributo_to_update);

        $atributos_produto = [
            'produto_id' => $produto->id,
            'produto_nome' => $produto->nome,
            'produto_preco' => $produto->preco,
            'produto_id_armazem' => $produto->id_armazem,
            'produto_id_fornecedor' => $produto->id_fornecedor,
            'produto_quantidade' => $produto->quantidade,
            'produto_nome_categoria' => $produto->nome_categoria,
            'produto_path_imagem' => $produto->path_imagem,
            'produto_nome_subcategoria' => $produto->nome_subcategoria,
            'produto_informacoes_adicionais' => $produto->informacoes_adicionais,
            'produto_data_producao_do_produto' => $produto->data_producao_do_produto,
            'produto_data_insercao_no_site' => $produto->data_insercao_no_site,
            'produto_kwh_consumidos_por_dia' => $produto->kwh_consumidos_por_dia_no_armazem,
            'pronto_a_vender' => $produto->pronto_a_vender,
        ];
        session()->put('produto_atual', $atributos_produto);
        
        $campos_extra = Produto_campos_extra::where('id_produto', session()->get('produto_atual')['produto_id'])->get();
        
        foreach($campos_extra as $campo){
            $name = $campo->campo_extra;
            $string_check = htmlentities( $campo->valor_campo , ENT_QUOTES, "UTF-8");
        
            if($campo->valor_campo != $request->$name){

                $atributos_produto = [
                    'valor_campo' => $request->$name,  
                ];

                Produto_campos_extra::where('id_produto', session()->get('produto_atual')['produto_id'])
                ->where('campo_extra', $campo->campo_extra)
                ->update($atributos_produto) ;
            }
        }

        $campos_extra = Produto_campos_extra::where('id_produto', session()->get('produto_atual')['produto_id'])->get();
        $all_campos_extra_produtos = array();
        foreach($campos_extra as $campo){

            $campo_extra_nome = Categoria_campos_extra::where('campo_extra', $campo->campo_extra)->first();

            $atributos_campo_extra = [
                "nome_campo_extra" => $campo_extra_nome->nome_campo_extra,
                "campo_extra" => $campo->campo_extra,
                "valor_campo" => $campo->valor_campo,   
            ];

            array_push($all_campos_extra_produtos, $atributos_campo_extra);
        }
        session()->put('campos_extra_atuais', $all_campos_extra_produtos);


        self::rebuild_fornecedor_session();


        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A  informação do produto '".$produto->nome."' foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];
        session()->push('notificacoes', $atributos_notificacao); 

        return redirect('/products-edit');
    }



    public function alterarCamposExtras(Request $request){
        Produto_campos_extra::where('id_produto', session()->get('produto_atual')['produto_id'])->delete();
        $catField = Categoria_campos_extra::where('nome_categoria', session()->get('cat_now'))->get();
        foreach($catField as $catFields){
            
            $name_field = $catFields->campo_extra;
            $string_check = htmlentities( $request->get($name_field) , ENT_QUOTES, "UTF-8");
            Produto_campos_extra::create([
                'id_produto' => session()->get('produto_atual')['produto_id'],
                'campo_extra' => $name_field,
                'valor_campo' => $string_check,
            ]);
        }

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A  informação do produto '".session()->get('produto_atual')['produto_nome']."' foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);

        $campo_extra = Produto_campos_extra::where('id_produto', session()->get('produto_atual')['produto_id'])->get();
        
        $all_campos_extra_produtos = array();

        foreach($campo_extra as $campo) {

            $campo_nome = $campo->campo_extra;
            $campo_valor = $campo->valor_campo;
            

            $atributos_campo_extra = [
                "nome_campo" => $campo_nome,
                "valor_campo" => $campo_valor,   
            ];


            array_push($all_campos_extra_produtos, $atributos_campo_extra);
        }

        session()->put('campos_extra_atuais', $all_campos_extra_produtos);
        self::rebuild_fornecedor_session(); 

        return redirect('/products-edit');
    }



    public function deleteWarning(Request $request){

        $html="Tem a certeza que deseja apagar o produto ".$request->get('nome_produto')."     
        ";

        $htmlB="
        
        <input name ='id_produto' type='hidden' value='".$request->get('id_produto')."'>
        <button type='submit' data-bs-dismiss='modal' id='buttonApagarProduto' class='btn btn-outline-danger'>Apagar</button>
        
        ";
        
        return array($html, $htmlB);
    }



    public static function productRemove(Request $request){

        Favoritos::where('id_produto', $request->get('id_produto'))->delete();
        
        $favs = Favoritos::where('id_utilizador', session()->get('user_id'))->get();

        $all_favs = array();

        foreach($favs as $fav1) {

            $fav_id = $fav1->id;
            $fav_id_utilizador = $fav1->id_utilizador;
            $fav_id_produto = $fav1->id_produto;
            $fav_mensagem = $fav1->mensagem;

            $atributos_favoritos = [
                "fav_id" => $fav_id,
                "fav_id_utilizador" => $fav_id_utilizador,
                "fav_id_produto" => $fav_id_produto,
                "fav_mensagem" => $fav_mensagem,
            ];

            array_push($all_favs, $atributos_favoritos);
        }

        session()->put('favoritos', $all_favs);



        Evento::where('id_produto', $request->get('id_produto'))->delete();
        Produto_campos_extra::where('id_produto', $request->get('id_produto'))->delete();
        $produto = Produto::where('id', $request->get('id_produto'))->first();

        session()->forget('all_fornecedor_produtos');

        if ($produto->path_imagem != "images/default_produto.jpg") {
            unlink($produto->path_imagem); // apagar a imagem do produto
        }

        $produto->delete();

        self::rebuild_fornecedor_session(); // rebuild products on session

        $noti ="O Produto ";
        $noti .= $request->get('nome');
        $noti.=" foi removido com sucesso";

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
        

        return redirect('/inventory'); //devolver a cadeia logistica do produto
    }

    public function getHtmlProductStore($produtos){

        $html = "";
        
        if ($produtos == []){
            return $html;
        }

        $favoritos = Produto::getFavoritesProductsIDs();
        
        foreach($produtos as $produto){
            
            $image_path_filename = $produto->path_imagem;

            $tagFavoritos = "fa fa-star";
            if (!file_exists($image_path_filename)) {
                $image_path_filename = "images/default_produto.jpg";
            }
            if($favoritos != null and $favoritos->contains($produto->id)) {
                $tagFavoritos = "fa fa-star checked";
            }

            $html .= '<div class="carta">';

            if (session()->has("user_id")){
                $html .=  '<a id="hideAnchor" class="Estrela_Favoritos" onclick="AdicionarApagarFavorito(this, ' . $produto->id  . ',' . "'" . route('Add-Del-Fav') . "'" . ' )">';
                $html .= '<span class="' . $tagFavoritos . '"></span>';
                $html .= "</a>";
            }

            $html .= '<a id="hideAnchor" href="' .  URL::to('produtoDetalhes/'.$produto->id) . '">';
            $html .= '<img src="' . $image_path_filename . '" style="width:100%" />';
            $html .= "</a>";
            $html .= '<h4>' . $produto->nome . '</h4>';
            $html .= '<p class="price">' . $produto->preco . '€</p>';

            
            $result = $this->isInCarrinho($produto);

            if (!$result){
                $html .= '<p><button class="BtnAddDelProd" onclick="AdicionarApagarProdutoCarrinho(this, ' . $produto->id .',' . "'" . route('Add-Del-Carrinho') . "'" . ')">Adicionar ao Carrinho</button></p>';
            }else{
                $html .= '<p><button class="BtnAddDelProd" style="background-color:red;" onclick="AdicionarApagarProdutoCarrinho(this, ' . $produto->id .',' . "'" . route('Add-Del-Carrinho') . "'" . ')">Remover do Carrinho</button></p>';
            }

            $html .= "</div>";

        }
        
        return $html;

    }

    public function CategoriasHtml(){

        $html = '<label for="Categorias">Categorias:&nbsp;</label>';

        $html .= '<select name="Categorias" id="Categorias" onChange="CreateSubCatOptions(' . "'" . route("HtmlSubCategoria") . "'" . ', ' . "'" . route("HtmlCamposExtras") . "'" . ')">';

        $html .= '<option selected value=""> -- Selecionar uma opção -- </option>';

        $categorias = Categoria::all();

        foreach ($categorias as $opcao) {
            $html .= '<option value="' . $opcao->nome . '">' . $opcao->nome . '</option>';
        }

        $html .= "</select>";

        return $html;
    }

    public function SubCategoriasHtml(Request $request){

        $html = '<label for="SubCategoria">SubCategoria:&nbsp;</label>';

        $html .= '<select name="SubCategoria" id="SubCategoria">';

        $html .= '<option selected value=""> -- Selecionar uma opção -- </option>';

        $subcategorias = Subcategoria::where('nome_categoria', $request->categoria)->get();

        foreach ($subcategorias as $opcao) {
            $html .= '<option value="' . $opcao->nome . '">' . $opcao->nome . '</option>';
        }

        $html .= "</select>";

        return $html;
    }

    public function CamposExtrasHtml(Request $request){

        $html = "";

        $CamposExtra = Categoria_campos_extra::where('nome_categoria', $request->categoria)->get();

        foreach ($CamposExtra as $campoExtra) {
            $html .= '<label for="'. $campoExtra->campo_extra .'">' . $campoExtra->nome_campo_extra . ':</label>';

            $html .= '<input type="text" id="'. $campoExtra->campo_extra .'" name="'. $campoExtra->campo_extra .'"><br><br>';

        }

        return $html;

    }

    public function ProductFilter(Request $request){

        if($request->favoritos == "on"){
            $produtos = Produto::getFavoritesProducts();
        }else{
            $produtos = Produto::getAllProducts();
        }

        $temp = Produto::where('preco', '<', $request->Preco)->get();
        $produtos = $this->IntersectArrays($produtos, $temp);

        $temp = Produto::where('quantidade', '>', '0')->get();
        $produtos = $this->IntersectArrays($produtos, $temp);

        if ($request->Nome != ""){

            $temp = Produto::where('nome', 'like', '%' . $request->Nome . '%')->get();
            $produtos = $this->IntersectArrays($produtos, $temp);
        }
        
        if($request->Categorias != ""){
            $temp = $this->SqlCategoria($request->Categorias);
            $produtos = $this->IntersectArrays($produtos, $temp);

            if ($request->SubCategoria != ""){
                $temp = $this->SqlSubCategoria($request->SubCategoria);
                $produtos = $this->IntersectArrays($temp, $produtos);
            }
        }

        $produtos = $this->FiltroCamposExtra($produtos, $request->Categorias, $request);
    
        $html = $this->getHtmlProductStore($produtos);

        return $html;
        
    }

    public function FiltroCamposExtra($produtos, $categoria, Request $request) {

        $data = $request->all();
        $campos_extra = Categoria_campos_extra::where('nome_categoria', $categoria)->get();

        foreach ($data as $key => $campo){
            foreach($campos_extra as $campo_extra){

                if ($key == $campo_extra->campo_extra and $campo != "" and $campo != null){
                    
                    $temp = DB::table("produto")
                        ->select("produto.id", "produto.nome", "produto.preco", "produto.path_imagem", "produto.quantidade")
                        ->leftjoin("produto_campos_extra", function ($join) {
                            $join->on("produto.id", "=", "produto_campos_extra.id_produto");
                        })
                        ->where("produto_campos_extra.campo_extra", "=", $campo_extra->campo_extra)
                        ->where("produto_campos_extra.valor_campo", "=", $campo)
                        ->orderby("produto.quantidade", "desc")
                        ->groupby("produto.id")
                        ->get();
                    
                    if (!$temp->isEmpty()){
                        $produtos = $this->IntersectArrays($produtos, $temp);
                    }else{
                        return [];
                    }
                }
            }
        }

        return $produtos;
    }

    public function allProducts() {
        $this->getAllCategoriesAndSubcategories();

        $html = $this->getHtmlProductStore(Produto::getAllProducts());

        $categorias = $this->CategoriasHtml();

        $data = [
            'produtos' => $html,
            'categorias' => $categorias,
        ];

        return View::make('products')->with('data', $data);

    }

    public function IntersectArrays($array1, $array2){

        $collection = collect();

        foreach ($array1 as $array1Item) {
            foreach ($array2 as $array2Item) {
                if ($array1Item->id == $array2Item->id){
                    $collection->push($array1Item);
                }
            }
        }

        return $collection;
    }

    public function SqlCategoria (String $Categoria){

        $produtos = DB::table("produto")
            ->select("produto.id", "produto.nome", "produto.preco", "produto.path_imagem", "produto.quantidade","utilizador.ultimo_nome")
            ->leftjoin("utilizador", function ($join) {
                $join->on("produto.id_fornecedor", "=", "utilizador.id");
            })
            ->where("produto.nome_categoria", "=", $Categoria)
            ->orderby("produto.quantidade", "desc")
            ->orderby("utilizador.ultimo_nome", "desc")
            ->groupby("produto.id")
            ->get();

        return $produtos;

    }

    public function SqlSubCategoria (String $SubCategoria){

        $produtos = DB::table("produto")
            ->select("produto.id", "produto.nome", "produto.preco", "produto.path_imagem", "produto.quantidade","utilizador.ultimo_nome")
            ->leftjoin("utilizador", function ($join) {
                $join->on("produto.id_fornecedor", "=", "utilizador.id");
            })
            ->where("produto.nome_subcategoria", "=", $SubCategoria)
            ->orderby("produto.quantidade", "desc")
            ->orderby("utilizador.ultimo_nome", "desc")
            ->groupby("produto.id")
            ->get();

        return $produtos;

    }

    function isInCarrinho($produto) {

        if(session()->get('carrinho_produtos')!=null) {
    
            $cart = session()->get('carrinho_produtos');
            foreach ($cart as $key=>$prod){
                
                if ($cart[$key]->id == $produto->id){
                    return true; 
                }
            } 
            return false;
        }
    }

    public function cadeiaPage($id){

        $produto = Produto::where('id', $id)->first();

        if(session()->get('prod_cadeia_actual') == null){
            session()->put('prod_cadeia_actual', $produto->id);
            session()->put('prod_nome_cadeia_actual', $produto->nome);
        }else{
            session()->forget('prod_cadeia_actual');
            session()->put('prod_cadeia_actual', $produto->id);
            session()->forget('prod_nome_cadeia_actual');
            session()->put('prod_nome_cadeia_actual', $produto->nome);
        }

        $fornecedor_eventos = Evento::where('id_produto', $produto->id)->get();

        $all_fornecedor_eventos = array();
        
        foreach($fornecedor_eventos as $evento) {
            
            $atributos_novo_evento = [
                "evento_id" =>  $evento->id,
                "evento_id_produto" => $evento->id_produto,
                "evento_nome" => $evento->nome,
                "evento_co2_produzido" => $evento->poluicao_co2_produzida,
                "evento_kwh_consumidos" => $evento->kwh_consumidos,
                "evento_descricao_do_evento" => $evento->descricao_do_evento,
                "id_fornecedor" => $evento->id_fornecedor,
            ];
            
            array_push($all_fornecedor_eventos, $atributos_novo_evento);
        }

        session()->put('produto_cadeia_logistica', $all_fornecedor_eventos);
       
        return redirect('/cadeia');
    }



    public function productAddEvent(Request $request){

        $request->validate([
            'nomeCadeia'=>'required|string',
            'co2_produzido'=>'required',
            'kwh_consumidos'=>'required',
            'descricaoCadeia'=>'required|string',
        ]);

        $newEvento = Evento::create([
            'id_produto' => session()->get('prod_cadeia_actual'),
            'nome' => $request->get('nomeCadeia'),
            'poluicao_co2_produzida' => $request->get('co2_produzido'),
            'kwh_consumidos' => $request->get('kwh_consumidos'),
            'descricao_do_evento' => $request->get('descricaoCadeia'),
            'id_fornecedor' => session()->get('user_id'),
        ]);

        $produto = Produto::where('id', session()->get('prod_cadeia_actual'))->first();

        $atributos_update_produto = [
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
            "pronto_a_vender" => 1,
        ];
        $produto->update($atributos_update_produto);

        $atributos_novo_evento = [
            "evento_id"  => $newEvento->id,
            "evento_id_produto" => $newEvento->id_produto,
            "evento_nome" => $newEvento->nome,
            "evento_co2_produzido" => $newEvento->poluicao_co2_produzida,
            "evento_kwh_consumidos" => $newEvento->kwh_consumidos,
            "evento_descricao_do_evento" => $newEvento->descricao_do_evento,
            "id_fornecedor" => $newEvento->id_fornecedor,
        ];

        $notis = Notificacao::create([
            'id_utilizador'=>session()->get('user_id'),
            'mensagem'=>"O evento logístico " . $request->get('nomeCadeia') . " foi criado com sucesso!",
            'estado'=>1,
        ]);
        
        $atributos_notificacao = [
            "notificacao_id" => $notis->id,
            "notificacao_id_utilizador" => $notis->id_utilizador,
            "notificacao_mensagem" => $notis->mensagem,
            "notificacao_estado" => $notis->estado,
        ];
       
        session()->push('notificacoes', $atributos_notificacao);

        if(session()->has('produto_cadeia_logistica')){
            session()->push('produto_cadeia_logistica', $atributos_novo_evento);
        } else {
            $produto_cadeia_logistica = array();
            array_push($produto_cadeia_logistica, $atributos_novo_evento);
            session()->put('produto_cadeia_logistica', $produto_cadeia_logistica);
        }

        return redirect('/cadeia'); //devolver a cadeia logistica do produto

    }

    public function cadeiaInfo($id){
        $cadeia =  Evento::where('id', $id)->first();

        $atributos_cadeia= [
            "cadeia_id" => $id,
            "cadeia_id_produto" => $cadeia->id_produto,
            "nome_cadeia" => $cadeia->nome,
            "co2_cadeia" => $cadeia->poluicao_co2_produzida,
            "kwh_cadeia" => $cadeia->kwh_consumidos,
            "descricao_cadeia" => $cadeia->descricao_do_evento,
        ];

        session()->put('cadeia_atual', $atributos_cadeia);
        
        return redirect('/cadeia-edit');
    }

    public function cadeiaDelete(Request $request){

        $cadeia = Evento::where('id', $request->get('id_cadeia'))->first();
        $cadeia->delete();

         // rebuild cadeia logistica
        $fornecedor_eventos = Evento::where('id_produto', session()->get('cadeia_atual')['cadeia_id_produto'])->get();

        $all_fornecedor_eventos = array();
        
        foreach($fornecedor_eventos as $evento) {
            
            $atributos_novo_evento = [
                "evento_id" =>  $evento->id,
                "evento_id_produto" => $evento->id_produto,
                "evento_nome" => $evento->nome,
                "evento_co2_produzido" => $evento->poluicao_co2_produzida,
                "evento_kwh_consumidos" => $evento->kwh_consumidos,
                "evento_descricao_do_evento" => $evento->descricao_do_evento,
                "id_fornecedor" => $evento->id_fornecedor,
            ];
            
            array_push($all_fornecedor_eventos, $atributos_novo_evento);
        }
        session()->put('produto_cadeia_logistica', $all_fornecedor_eventos);

        $notis = Notificacao::create([
            'id_utilizador'=>session()->get('user_id'),
            'mensagem'=>"O evento logístico " . $cadeia->nome . " foi apagado com sucesso",
            'estado'=>1,
        ]);
        
        $atributos_notificacao = [
            "notificacao_id" => $notis->id,
            "notificacao_id_utilizador" => $notis->id_utilizador,
            "notificacao_mensagem" => $notis->mensagem,
            "notificacao_estado" => $notis->estado,
        ];
       
        session()->push('notificacoes', $atributos_notificacao);
        return redirect('/cadeia');
    }

    public function cadeiaEdit(Request $request){
        
        $request->validate([
            'nome'=>'sometimes|required|string',
            'co2'=>'sometimes|required|string',
            'kwh'=>'sometimes|required|string',
            'desc'=>'sometimes|required|string',
        ]);
        
        $to_update = [
            'nome' => $request->nome,
            'poluicao_co2_produzida' => $request->co2,
            'kwh_consumidos' => $request->kwh,
            'descricao_do_evento' => $request->desc,
        ];

        $evento = Evento::where('id', session()->get('cadeia_atual')['cadeia_id'])->first();
        $evento->update($to_update);
        
        $atributos_cadeia= [
            "cadeia_id" => $evento->id,
            "cadeia_id_produto" => $evento->id_produto,
            "nome_cadeia" => $evento->nome,
            "co2_cadeia" => $evento->poluicao_co2_produzida,
            "kwh_cadeia" => $evento->kwh_consumidos,
            "descricao_cadeia" => $evento->descricao_do_evento,
        ];
        session()->put('cadeia_atual', $atributos_cadeia);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A informação do evento logístico '".$evento->nome."' foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];
        session()->push('notificacoes', $atributos_notificacao);

        // rebuild cadeia logistica
        $fornecedor_eventos = Evento::where('id_produto', session()->get('cadeia_atual')['cadeia_id_produto'])->get();

        $all_fornecedor_eventos = array();
        
        foreach($fornecedor_eventos as $evento) {
            
            $atributos_novo_evento = [
                "evento_id" =>  $evento->id,
                "evento_id_produto" => $evento->id_produto,
                "evento_nome" => $evento->nome,
                "evento_co2_produzido" => $evento->poluicao_co2_produzida,
                "evento_kwh_consumidos" => $evento->kwh_consumidos,
                "evento_descricao_do_evento" => $evento->descricao_do_evento,
                "id_fornecedor" => $evento->id_fornecedor,
            ];
            
            array_push($all_fornecedor_eventos, $atributos_novo_evento);
        }
        session()->put('produto_cadeia_logistica', $all_fornecedor_eventos);

        return redirect('/cadeia-edit');
    }


    public function productInfo($id){

        $produto = Produto::where('id', $id)->first();

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
            "pronto_a_vender" => $produto->pronto_a_vender,
        ];

        session()->put('produto_atual', $atributos_produto);

        $produto_armazem = Armazem::where('id', $produto->id_armazem)->first();

        $atributos_armazem = [
            "armazem_id" => $produto_armazem->id,
            "armazem_id_fornecedor" => $produto_armazem->id_fornecedor,
            "armazem_morada" => $produto_armazem->morada,
            "armazem_nome" => $produto_armazem->nome,
            "armazem_path_imagem" => $produto_armazem->path_imagem,
            "armazem_latitude" => $produto_armazem->latitude,
            "armazem_longitude" => $produto_armazem->longitude,
        ];

        session()->put('produto_atual_armazem', $atributos_armazem);

        $campo_extra = Produto_campos_extra::where('id_produto', $id)->get();

        $all_campos_extra_produtos = array();

        foreach($campo_extra as $campo) {

            $campo_extra_nome = Categoria_campos_extra::where('campo_extra', $campo->campo_extra)->first();

            if ($campo->campo_extra == 'prazo_de_validade') {

                $now = time();
                $date = strtotime($campo->valor_campo);
                $datediff = ceil(($date - $now)/86400);

                if($datediff < 7 && $datediff > 0){
                    $produto = Produto::where('id', $campo->id_produto)->first();

                    $notis = Notificacao::create([
                        'id_utilizador'=>session()->get('user_id'),
                        'mensagem'=>"O produto " . $produto->nome . "tem apenas mais " . $datediff . " dias antes de validade!",
                        'estado'=>1,
                    ]);
                    
                    $atributos_notificacao = [
                        "notificacao_id" => $notis->id,
                        "notificacao_id_utilizador" => $notis->id_utilizador,
                        "notificacao_mensagem" => $notis->mensagem,
                        "notificacao_estado" => $notis->estado,
                    ];
                
                    session()->push('notificacoes', $atributos_notificacao);
                }
            }


            $atributos_campo_extra = [
                "nome_campo_extra" => $campo_extra_nome->nome_campo_extra,
                "campo_extra" => $campo->campo_extra,
                "valor_campo" => $campo->valor_campo,   
            ];

            array_push($all_campos_extra_produtos, $atributos_campo_extra);
        }

        session()->put('campos_extra_atuais', $all_campos_extra_produtos);


        // rebuild cadeia logistica do produto em sessao
        $produto_eventos = Evento::where('id_produto', $produto->id)->get();

        $all_produto_eventos = array();
        
        foreach($produto_eventos as $evento) {
            
            $atributos_novo_evento = [
                "evento_id" =>  $evento->id,
                "evento_id_produto" => $evento->id_produto,
                "evento_nome" => $evento->nome,
                "evento_co2_produzido" => $evento->poluicao_co2_produzida,
                "evento_kwh_consumidos" => $evento->kwh_consumidos,
                "evento_descricao_do_evento" => $evento->descricao_do_evento,
                "id_fornecedor" => $evento->id_fornecedor,
            ];
            
            array_push($all_produto_eventos, $atributos_novo_evento);
        }
        session()->put('cadeias_produto_atual', $all_produto_eventos);
       
        return redirect('/products-edit');
    }

    public function changeImgProd(Request $request){
        $produto = Produto::where('id', session()->get('produto_atual')['produto_id'])->first();

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

        if (!(str_contains($produto->path_imagem , 'http'))) {
            if ($produto->path_imagem != "images/default_produto.jpg") {
                unlink($produto->path_imagem); // apagar a imagem antiga
            }
        }

        $produto->path_imagem = $filename;
        $produto->save();

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
            "pronto_a_vender" => $produto->pronto_a_vender,
        ];

        session()->put('produto_atual', $atributos_produto);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A imagem da seu produto ".$produto->nome." foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);


        self::rebuild_fornecedor_session(); 

        return redirect('/products-edit');
    }



    public function filterProduct(Request $request){

        //View::share('testerView', 'Steve');
        return view("apresentacao_produtos",['filtroArmazem' => $request->get('id_armazem')]);
        
    }

    public function searchCat(Request $request){

        //View::share('testerView', 'Steve');
        return view("apresentacao_produtos_cat",['filtroCat' => $request->get('categoria')]);
        
    }




    public function changeSub(Request $request){

        $subCat = Subcategoria::where('nome_categoria', $request->get('categoria'))->get();


        $camposExtra = Categoria_campos_extra::where('nome_categoria', $request->get('categoria'))->get();

        if($request->get('categoria') != null){
            $html="<label for='nome_subcategoria' class='form-label'>Subcategorias de ".$request->get('categoria')."</label>
            <select ref='subcat' class='form-control' name='nome_subcategoria' id='novo_produto_subcategoria' required>
                <option default value=''>-- Selecione uma subcategoria --</option>";
            foreach($subCat as $sub){
                $html=$html."
                <option value='".$sub->nome."'>".$sub->nome."</option>
                
                ";
            }
            
        }else{
            $html="<label for='nome_subcategoria' class='form-label'>Selecione uma categoria</label>
            <select ref='subcat' disabled class='form-control' name='nome_subcategoria' id='novo_produto_subcategoria' required>
                <option default value=''>-- Selecione uma subcategoria --</option>";
            
        }

        if($camposExtra != null){
    
            $htmlC =
            "<div class='row'>"
            ;
    
            $i = 0;
            foreach($camposExtra as $camposExtras) {
            $htmlC=$htmlC."
                <div class='col'>
                   <label for='".$camposExtras->campo_extra."' class='form-label'> ".$camposExtras->nome_campo_extra.":</label>
                   <input  name='".$camposExtras->campo_extra."' class='form-control' type='text' required>
                </div>"
                ;
    
                if($i > 0 && $i % 2==0) {
                    $htmlC=$htmlC.
                    "</div>".
                    "<div class='row'>"
                    ;
                }
                $i = $i + 1;
            }



        return array($html,$htmlC);
        }   
    }

    public function compararProdutos(Request $request){

        session()->put('categoria_a_comparar', $request->comparar_categoria);

        return view('comparar_produtos');
    }


    public function compararProdutosLoja(Request $request){

        $categoria = $request->comparar_categoria;

        session()->put('categoria_a_comparar', $categoria);

        $produtos = Produto::getAllProducts();

        $all_produtos = array();

        foreach($produtos as $produto) {

            if ($produto->nome_categoria == $categoria) {
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
                    "pronto_a_vender" => $produto->pronto_a_vender,
                    "produto_quantidade_produto_expirada" => $produto->quantidade_produto_expirada,
                    "produto_quantidade_produto_incidentes_transporte" => $produto->quantidade_produto_incidentes_transporte,
                ];
    
                array_push($all_produtos, $atributos_produto);
            }
            
        }

        session()->put('produtos_comparar', $all_produtos);

        return view('comparar_produtos_loja');
    }


    public function compararDoisProdutos(Request $request){

        $Produto1 = Produto::where('id', $request->produto1)->first();
        $campo_extra_produto1 = Produto_campos_extra::where('id_produto', $Produto1->id)->get();

        $fornecedor1 = Utilizador::where('id', $Produto1->id_fornecedor)->first();
        $fornecedor1_nome = $fornecedor1->primeiro_nome . " " . $fornecedor1->ultimo_nome;

        $atributos_produto1 = [
            "produto_id" => $Produto1->id,
            "produto_nome" => $Produto1->nome,
            "produto_preco" => $Produto1->preco,
            "produto_id_armazem" => $Produto1->id_armazem,
            "produto_id_fornecedor" => $Produto1->id_fornecedor,
            "produto_id_fornecedor_nome" => $fornecedor1_nome,
            "produto_quantidade" => $Produto1->quantidade,
            "produto_nome_categoria" => $Produto1->nome_categoria,
            "produto_path_imagem" => $Produto1->path_imagem,
            "produto_nome_subcategoria" => $Produto1->nome_subcategoria,
            "produto_informacoes_adicionais" => $Produto1->informacoes_adicionais,
            "produto_data_producao_do_produto" => $Produto1->data_producao_do_produto,
            "produto_data_insercao_no_site" => $Produto1->data_insercao_no_site,
            "produto_kwh_consumidos_por_dia" => $Produto1->kwh_consumidos_por_dia_no_armazem,
            "pronto_a_vender" => $Produto1->pronto_a_vender,
        ];

        session()->put('produto_1_atributos', $atributos_produto1);

        $produto1_armazem = Armazem::where('id', $Produto1->id_armazem)->first();

        $produto_1_atributos_armazem = [
            "armazem_id" => $produto1_armazem->id,
            "armazem_id_fornecedor" => $produto1_armazem->id_fornecedor,
            "armazem_morada" => $produto1_armazem->morada,
            "armazem_nome" => $produto1_armazem->nome,
            "armazem_path_imagem" => $produto1_armazem->path_imagem,
            "armazem_latitude" => $produto1_armazem->latitude,
            "armazem_longitude" => $produto1_armazem->longitude,
        ];

        session()->put('produto_1_atual_armazem', $produto_1_atributos_armazem);

        $all_campos_extra_produto1 = array();

        foreach($campo_extra_produto1 as $campo) {

            $campo_extra_nome = Categoria_campos_extra::where('campo_extra', $campo->campo_extra)->first();

            $atributos_campo_extra = [
                "nome_campo_extra" => $campo_extra_nome->nome_campo_extra,
                "campo_extra" => $campo->campo_extra,
                "valor_campo" => $campo->valor_campo,   
            ];

            array_push($all_campos_extra_produto1, $atributos_campo_extra);
        }

        session()->put('campos_extra_produto_1', $all_campos_extra_produto1);



        $Produto2 = Produto::where('id', $request->produto2)->first();
        $campo_extra_produto2 = Produto_campos_extra::where('id_produto', $Produto2->id)->get();

        $fornecedor2 = Utilizador::where('id', $Produto2->id_fornecedor)->first();
        $fornecedor2_nome = $fornecedor2->primeiro_nome . " " . $fornecedor2->ultimo_nome;

        $atributos_produto2 = [
            "produto_id" => $Produto2->id,
            "produto_nome" => $Produto2->nome,
            "produto_preco" => $Produto2->preco,
            "produto_id_armazem" => $Produto2->id_armazem,
            "produto_id_fornecedor" => $Produto2->id_fornecedor,
            "produto_id_fornecedor_nome" => $fornecedor2_nome,
            "produto_quantidade" => $Produto2->quantidade,
            "produto_nome_categoria" => $Produto2->nome_categoria,
            "produto_path_imagem" => $Produto2->path_imagem,
            "produto_nome_subcategoria" => $Produto2->nome_subcategoria,
            "produto_informacoes_adicionais" => $Produto2->informacoes_adicionais,
            "produto_data_producao_do_produto" => $Produto2->data_producao_do_produto,
            "produto_data_insercao_no_site" => $Produto2->data_insercao_no_site,
            "produto_kwh_consumidos_por_dia" => $Produto2->kwh_consumidos_por_dia_no_armazem,
            "pronto_a_vender" => $Produto2->pronto_a_vender,
        ];

        session()->put('produto_2_atributos', $atributos_produto2);

        $produto2_armazem = Armazem::where('id', $Produto2->id_armazem)->first();

        $produto_2_atributos_armazem = [
            "armazem_id" => $produto2_armazem->id,
            "armazem_id_fornecedor" => $produto2_armazem->id_fornecedor,
            "armazem_morada" => $produto2_armazem->morada,
            "armazem_nome" => $produto2_armazem->nome,
            "armazem_path_imagem" => $produto2_armazem->path_imagem,
            "armazem_latitude" => $produto2_armazem->latitude,
            "armazem_longitude" => $produto2_armazem->longitude,
        ];

        session()->put('produto_2_atual_armazem', $produto_2_atributos_armazem);

        $all_campos_extra_produto2 = array();

        foreach($campo_extra_produto2 as $campo) {

            $campo_extra_nome = Categoria_campos_extra::where('campo_extra', $campo->campo_extra)->first();

            $atributos_campo_extra = [
                "nome_campo_extra" => $campo_extra_nome->nome_campo_extra,
                "campo_extra" => $campo->campo_extra,
                "valor_campo" => $campo->valor_campo,   
            ];

            array_push($all_campos_extra_produto2, $atributos_campo_extra);
        }

        session()->put('campos_extra_produto_2', $all_campos_extra_produto2);

        return view('comparar_2_produtos');
    }

    
    public function productAddDelCarrinho(Request $request) {
  
        $produto = Produto::where('id', $request->id)->first();

        if(session()->has('carrinho_produtos')){
            
            if (!$this->IsProductInCart($produto)){
                session()->push('carrinho_produtos', $produto);
            } else {
                $carrinho = session()->get('carrinho_produtos');
                $reindexed_carrinho = array_values($carrinho);
                session()->put('carrinho_produtos', $reindexed_carrinho);
            }

        } else {
            $carrinho = array();
            array_push($carrinho, $produto);
            session()->put('carrinho_produtos', $carrinho);
        } 

        return session()->get('carrinho_produtos');
    }


    public function IsProductInCart($produto) {

        $ProdutoArray = array();
        array_push($ProdutoArray, $produto);

        $cart = session()->get('carrinho_produtos');
        foreach ($cart as $key=>$prod){
            if ($cart[$key] == $ProdutoArray[0]){
                
                if (count($cart) == 0){
                    $request->session()->forget('carrinho_produtos');
                }else{
                    unset($cart[$key]);
                    session()->put('carrinho_produtos', $cart);
                }

                return true; 
            }
        } 
        return false;
    }

    public function AddDelFav(Request  $request){

        $id_prod = $request->id;
        $id_user = session()->get('user_id');

        $Favorito = Favoritos::where('id_produto', '=', $id_prod)
                ->where('id_utilizador', '=', $id_user)
                ->first();

        if($Favorito == null){
            $fav = Favoritos::create([
                'id_utilizador' => $id_user,
                'id_produto' => $id_prod,
            ]);
        }else{
            $Favorito->delete();
        }

    }

    public static function obter_favoritos_do_utilizador() {

        $favs = Favoritos::where('id_utilizador', session()->get('user_id'))->get();

        $all_favs = array();

        foreach($favs as $fav1) {

            $fav_id = $fav1->id;
            $fav_id_utilizador = $fav1->id_utilizador;
            $fav_id_produto = $fav1->id_produto;
            $fav_mensagem = $fav1->mensagem;

            $atributos_favoritos = [
                "fav_id" => $fav_id,
                "fav_id_utilizador" => $fav_id_utilizador,
                "fav_id_produto" => $fav_id_produto,
                "fav_mensagem" => $fav_mensagem,
            ];

            array_push($all_favs, $atributos_favoritos);
        }

        session()->put('favoritos', $all_favs);
        
    }


    public static function findClosestBases() {
        $produtosBases = array();

        //obter coords das Bases
        $bases = Base::all();
        $coordsTransportadoras = array();

        foreach ($bases as &$base) {
            $coordBase = array();
            array_push($coordBase, $base->id_transportadora);
            array_push($coordBase, $base->nome);
            array_push($coordBase, $base->latitude);
            array_push($coordBase, $base->longitude);
            array_push($coordBase, $base->preco);
            array_push($coordBase, $base->id);

            array_push($coordsTransportadoras, $coordBase);
        }

        $carrinho = session()->get('carrinho_produtos');

        foreach ($carrinho as &$produto) {
            $armazem = Armazem::where('id', $produto['id_armazem'])->first();

            $armazemLat = floatval($armazem->latitude);
            $armazemLon = floatval($armazem->longitude);

            $distanciasTransportadoras = array();
            foreach ($coordsTransportadoras as &$coordsTransportadora) {
                $distanciaAprox = 0;
                $distanciaAprox += abs($armazemLat - floatval($coordsTransportadora[2]));
                $distanciaAprox += abs($armazemLon - floatval($coordsTransportadora[3]));

                $distanciasTransportadoras[] = array("dist" => $distanciaAprox,
                                                     "id" => $coordsTransportadora[0],
                                                     "nome" => $coordsTransportadora[1],
                                                     "lat" => $coordsTransportadora[2],
                                                     "lon" => $coordsTransportadora[3],
                                                     "price" => $coordsTransportadora[4],
                                                     "id_base" => $coordsTransportadora[5]);
            }

            usort($distanciasTransportadoras, 
                function (array $a, array $b) {
                    if ($a['dist'] < $b['dist']) {
                        return -1;
                    } else if ($a['dist'] > $b['dist']) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            );

            $slicedResult = array_slice($distanciasTransportadoras, 0, 3);
            array_push($produtosBases, $slicedResult);
        }
        
        return $produtosBases;
    }

    public static function distanceToStorage() {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);

        $url = "https://atlas.microsoft.com/route/directions/json?subscription-key=rxjgLgUQ02QSSkv0NKBzj7q3gXP9HPCNyHfoE_DBNRc&api-version=1.0&format=json&query=";

        if(session()->has('carrinho_produtos')){
            $carrinho = session()->get('carrinho_produtos');
            $produtosBases = self::findClosestBases();
        
            for($i = 0; $i < sizeOf(session()->get('carrinho_produtos')); $i++){
                $armazem = Armazem::where('id', $carrinho[$i]['id_armazem'])->first();

                for ($x = 0; $x < sizeOf($produtosBases[$i]); $x++) {
                    $url .= (strval($armazem->latitude) . ',' . strval($armazem->longitude) . ':' . strval($produtosBases[$i][$x]['lat']  . ',' . strval($produtosBases[$i][$x]['lon'])));
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $response = curl_exec($ch);
                    $response = json_decode($response);

                    $produtosBases[$i][$x]['dist'] = $response->routes[0]->summary->lengthInMeters;
                    $url = "https://atlas.microsoft.com/route/directions/json?subscription-key=rxjgLgUQ02QSSkv0NKBzj7q3gXP9HPCNyHfoE_DBNRc&api-version=1.0&format=json&query=";
                }
            }

            curl_close($ch);
            session()->put('basesDistancias', $produtosBases);
        }   
    }

    public static function calculatePollution() {

        if(session()->has('carrinho_produtos')){
            $poluicaoProdutos = array();
            $carrinho = session()->get('carrinho_produtos');
        
            for($i = 0; $i < sizeOf(session()->get('carrinho_produtos')); $i++){
                $eventos = Evento::where('id_produto', $carrinho[$i]['id'])->get();
                $poluicaoProduto = 0;

                for ($x = 0; $x < sizeOf($eventos); $x++) {
                    $poluicaoProduto += $eventos[$x]['poluicao_co2_produzida'];
                }

                array_push($poluicaoProdutos, $poluicaoProduto);
            }

            session()->put('poluicaoProdutos', $poluicaoProdutos);
        } 
    }

    public function prodInfo($id){
        $produto = Produto::where('id', $id)->first();
        $fornecedor_eventos = Evento::where('id_produto', $id)->get();


        $all_eventos_produtos = array();

        foreach($fornecedor_eventos as $evento) {

            $evento_nome = $evento->nome;
            $evento_co2 = $evento->poluicao_co2_produzida;
            $evento_kwh = $evento->kwh_consumidos;
            $evento_desc = $evento->descricao_do_evento;
            

            $atributos_evento = [
                "evento_nome" => $evento_nome,
                "evento_co2" => $evento_co2,   
                "evento_kwh" => $evento_kwh,
                "evento_desc" => $evento_desc,   
            ];


            array_push($all_eventos_produtos, $atributos_evento);
        }

        session()->put('cadeias_produto_info', $all_eventos_produtos);

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
            "produto_kwh_consumidos_por_dia_no_armazem" => $produto->kwh_consumidos_por_dia_no_armazem,
            
        ];

        $campo_extra = Produto_campos_extra::where('id_produto', $id)->get();

        $all_campos_extra_produtos = array();

        foreach($campo_extra as $campo) {

            $campo_extra_nome = Categoria_campos_extra::where('campo_extra', $campo->campo_extra)->first();

            $atributos_campo_extra = [
                "nome_campo_extra" => $campo_extra_nome->nome_campo_extra,
                "campo_extra" => $campo->campo_extra,
                "valor_campo" => $campo->valor_campo,   
            ];

            array_push($all_campos_extra_produtos, $atributos_campo_extra);
        }

        session()->put('campos_extra_atuais', $all_campos_extra_produtos);

        // rebuild cadeia logistica do produto em sessao
        $produto_eventos = Evento::where('id_produto', $produto->id)->get();

        $all_produto_eventos = array();
        
        foreach($produto_eventos as $evento) {
            
            $atributos_novo_evento = [
                "evento_id" =>  $evento->id,
                "evento_id_produto" => $evento->id_produto,
                "evento_nome" => $evento->nome,
                "evento_co2_produzido" => $evento->poluicao_co2_produzida,
                "evento_kwh_consumidos" => $evento->kwh_consumidos,
                "evento_descricao_do_evento" => $evento->descricao_do_evento,
                "id_fornecedor" => $evento->id_fornecedor,
            ];
            
            array_push($all_produto_eventos, $atributos_novo_evento);
        }
        session()->put('cadeias_produto_atual', $all_produto_eventos);

        session()->put('produto_detalhes', $atributos_produto);
        return redirect('/produto-detalhes');
            
    }
}