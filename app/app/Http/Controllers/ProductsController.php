<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
    
        $kwh_sum = 0;
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
            $produto_kwh_consumidos_por_dia = $produto->kwh_consumidos_por_dia_no_armazem;
            $produto_state = $produto->pronto_a_vender;

            

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
                "pronto_a_vender" => $produto_state,
            ];


            array_push($all_fornecedor_produtos, $atributos_produto);
        }

        session()->put('all_fornecedor_produtos', $all_fornecedor_produtos);



        if(session()->get('notificado') == null){
            $now = time(); 
            $dataVals = Produto_campos_extra::where('campo_extra', 'data_validade')->get();
            

            foreach(session()->get('all_fornecedor_produtos') as $produto){
                foreach($dataVals as $dataVal){
                    $id = $dataVal->id_produto;
                    if($produto['produto_id'] == $id){
                        $date = strtotime($dataVal->valor_campo);
                        $datediff = ceil(($date - $now)/86400);
                        if($datediff < 7 && $datediff > 0){
                            $noti ="O Produto ";
                            $noti .= $produto['produto_nome'];
                            $noti.=" tem apenas ".$datediff." dias antes de expirar";
        
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
                        }
                    }
                

                
            }
            

            }
            session()->put('notificado', 1);
        }

        if(!(session()->has('categories'))){
            self::getAllCategoriesAndSubcategories(); // put all categories and subcategories in session
        }

        if(!(session()->has('armazens'))){
            (new ArmazensController)->getAllArmazens(); // put all armazens of fornecedor in session
        }

        
        $fornecedor_eventos = Evento::where('id_fornecedor', session()->get('user_id'))->get();

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


    }


    public function productRegister(Request $request)
    {
        //dd($campos_extra);
       
        $catField = Categoria_campos_extra::where('nome_categoria', $request->get('nome_categoria'))->get();


        if($catField==null){
            
        }
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
            'nome_subcategoria' => $request->get('nome_subcategoria'),
            'path_imagem' => $filename,          
            'informacoes_adicionais' => $request->get('informacoes_adicionais'),
            'data_producao_do_produto' => $request->get('data_producao_do_produto'),
            'data_insercao_no_site' => $request->get('data_insercao_no_site'),
            'kwh_consumidos_por_dia_no_armazem' => $request->get('kwh_consumidos_por_dia'),
            'pronto_a_vender' => 0,
        ]);

        $fornecedor_historico = Fornecedor_historico_poluicao::where('id_fornecedor', session()->get('user_id'))->first();
        $historico_to_update = [
            'id_fornecedor' => session()->get('user_id'),
            'poluicao_co2_produzida' => $fornecedor_historico->poluicao_co2_produzida,
            'kwh_consumidos' => $fornecedor_historico->kwh_consumidos + $newProduto->kwh_consumidos_por_dia_no_armazem,
        ];
        
        $fornecedor_historico->update($historico_to_update);

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
            'quantidade'=>'sometimes|required|integer',
            'data_p'=>'sometimes|required|string',
            'data_i'=>'sometimes|required|string',
            'kwh'=>'sometimes|required|string',
            'info'=>'sometimes|required|string',
            'nome_categoria'=> 'sometimes|required|string',
            'nome_subcategoria'=>'sometimes|required|string',
        ]);

        
        
        $produto = Produto::where('id', session()->get('produto_atual')['produto_id'])->first();
        $catAntiga = $produto->nome_categoria;
        if($catAntiga == $request->nome_categoria){
            $atributo_to_update = [
                'nome' => $request->nome,
                'preco' => $request->preco,
                'id_armazem' => session()->get('produto_atual')['produto_id_armazem'],
                'id_fornecedor' => session()->get('user_id'),
                'quantidade' => $request->quantidade,
                'nome_categoria' => $request->nome_categoria,
                'nome_subcategoria' => session()->get('produto_atual')['produto_nome_subcategoria'],
                'path_imagem' => session()->get('produto_atual')['produto_path_imagem'],       
                'informacoes_adicionais' => $request->info,
                'data_producao_do_produto' => $request->data_p,
                'data_insercao_no_site' => $request->data_i,
                'kwh_consumidos_por_dia_no_armazem' => $request->kwh,
                'pronto_a_vender' => session()->get('produto_atual')['pronto_a_vender'],
            ];
        }else{
            $atributo_to_update = [
                'nome' => $request->nome,
                'preco' => $request->preco,
                'id_armazem' => session()->get('produto_atual')['produto_id_armazem'],
                'id_fornecedor' => session()->get('user_id'),
                'quantidade' => $request->quantidade,
                'nome_categoria' => $request->nome_categoria,
                'nome_subcategoria' =>  $request->nome_subcategoria,
                'path_imagem' => session()->get('produto_atual')['produto_path_imagem'],       
                'informacoes_adicionais' => $request->info,
                'data_producao_do_produto' => $request->data_p,
                'data_insercao_no_site' => $request->data_i,
                'kwh_consumidos_por_dia_no_armazem' => $request->kwh,
                'pronto_a_vender' => session()->get('produto_atual')['pronto_a_vender'],
            ];
        }

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
        if($catAntiga  != $produto-> nome_categoria){
            $campos = Categoria_campos_extra::where('nome_categoria', $produto-> nome_categoria)->get();
            $all_campos_extra_produtos = array();

            foreach($campos as $campo) {

                $campo_nome = $campo->nome_campo_extra;
                $campo_extra = $campo->campo_extra;
                $campo_cat = $campo->nome_categoria;
                

                $atributos_campo_extra = [
                    "nome_campo" => $campo_nome,
                    "campo" => $campo_extra,   
                    "nome_cat" => $campo_cat,   
                ];


                array_push($all_campos_extra_produtos, $atributos_campo_extra);
            }

            session()->put('cat_selected', $all_campos_extra_produtos);
            session()->put('cat_now', $produto-> nome_categoria);
            
            
            return redirect('/campos-extra-edit');
        }else{//update  de campos  extra
            $campos_extra = Produto_campos_extra::where('id_produto', session()->get('produto_atual')['produto_id'])->get();
            
            foreach($campos_extra as $campo){
                $name = $campo->campo_extra;
                $string_check = htmlentities( $campo->valor_campo , ENT_QUOTES, "UTF-8");
            
                if($campo->valor_campo != $request->$name){
                    Produto_campos_extra::where('id_produto', session()->get('produto_atual')['produto_id'])
                    ->where('campo_extra', $campo->campo_extra)
                    ->update(array('valor_campo' => $string_check)) ;
                }
                
                
            }
            $campos_extra = Produto_campos_extra::where('id_produto', session()->get('produto_atual')['produto_id'])->get();
            $all_campos_extra_produtos = array();
            foreach($campos_extra as $campo){
                $campo_nome = $campo->campo_extra;
                $campo_valor = $campo->valor_campo;
                

                $atributos_campo_extra = [
                    "nome_campo" => $campo_nome,
                    "valor_campo" => $campo_valor,   
                ];


                array_push($all_campos_extra_produtos, $atributos_campo_extra);
            }

            session()->put('campos_extra_atuais', $all_campos_extra_produtos);
            
        }


        

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


        self::rebuild_fornecedor_session(); 

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

        
        //
        // Constucao da cadeia logistica para ser mostrada no html
        //
        

        return redirect('/inventory'); //devolver a cadeia logistica do produto
    }



    public function allProducts() {

        return View::make('products')->with('produtos', Produto::getAllProducts());

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



        $fornecedor_historico = Fornecedor_historico_poluicao::where('id_fornecedor', session()->get('user_id'))->first();
        $historico_to_update = [
            'id_fornecedor' => session()->get('user_id'),
            'poluicao_co2_produzida' => $fornecedor_historico->poluicao_co2_produzida  + $newEvento->poluicao_co2_produzida,
            'kwh_consumidos' => $fornecedor_historico->kwh_consumidos + $newEvento->kwh_consumidos,
        ];
        $fornecedor_historico->update($historico_to_update);




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

        $noti ="A cadeia logistica ";
        $noti .= $request->get('nomeCadeia');
        $noti.=" foi criada com sucesso";

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
         // rebuild armazens of fornecedor in session
        self::rebuild_fornecedor_session();

        $noti ="A cadeia ";
        $noti .= $cadeia->nome;
        $noti.=" foi apagada com sucesso";

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
        return redirect('/cadeia');
    }

    public function cadeiaEdit(Request $request){
        
        $request->validate([
            'nome'=>'sometimes|required|string',
            'co2'=>'sometimes|required',
            'kwh'=>'sometimes|required',
            'desc'=>'sometimes|required|string',
           
        ]);
        //dd($request->all());

        
        
        $evento = Evento::where('id', session()->get('cadeia_atual')['cadeia_id'])->first();
        
        $historico_to_update = [
            //'id_produto' => session()->get('prod_cadeia_actual'),
            'nome' => $request->get('nome'),
            'poluicao_co2_produzida' => $request->get('co2'),
            'kwh_consumidos' => $request->get('kwh'),
            'descricao_do_evento' => $request->get('desc'),
        ];
        $evento->update($historico_to_update);
        
        $atributos_cadeia= [
            "cadeia_id" => session()->get('cadeia_atual')['cadeia_id'],
            "nome_cadeia" => $evento->nome,
            "co2_cadeia" => $evento->poluicao_co2_produzida,
            "kwh_cadeia" => $evento->kwh_consumidos,
            "descricao_cadeia" => $evento->descricao_do_evento,
        ];

        session()->put('cadeia_atual', $atributos_cadeia);

        $notificacao = Notificacao::create([
            'id_utilizador' => session()->get('user_id'),
            'mensagem' => "A  informação da cadeia '".$evento->nome."' foi atualizada!",
            'estado' => 1,
        ]);

        $atributos_notificacao = [
            "notificacao_id" => $notificacao->id,
            "notificacao_id_utilizador" => $notificacao->id_utilizador,
            "notificacao_mensagem" => $notificacao->mensagem,
            "notificacao_estado" => $notificacao->estado,
        ];

        session()->push('notificacoes', $atributos_notificacao);


        self::rebuild_fornecedor_session(); // put all session bases and veiculos up to date

        return redirect('/cadeia-edit');
    }


    public function productInfo($id){

        $produto = Produto::where('id', $id)->first();
        $campo_extra = Produto_campos_extra::where('id_produto',  $id)->get();
        $cadeias  = Evento::where('id_produto', $id)->get();
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


        $all_eventos_produtos = array();

        foreach($cadeias as $evento) {

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

        session()->put('cadeias_produto_atual', $all_eventos_produtos);
       
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

    public function compareProds(Request $request){
        //dd($request->has(77));
        $prods = array();
            
        for($i = 0; $i < sizeOf(session()->get('all_fornecedor_produtos')); $i++){
            if($request->has(session()->get('all_fornecedor_produtos')[$i]['produto_id']) == true){
                array_push($prods, session()->get('all_fornecedor_produtos')[$i]['produto_id']);
            }
        }
        $produto = Produto::where('id', $prods[0])->first();
        if($produto->pronto_a_vender != 0){
            $eventos = Evento::where('id_produto', $prods[0])->get();
            $co2 = 0;
            $kwh = 0;
            foreach($eventos as $evento){
                $co2 = $co2 + $evento->poluicao_co2_produzida;
                $kwh = $kwh + $evento->kwh_consumidos;
                
            }
            $sum  = $co2 +  $kwh;
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
                'poluicao_evento_co2'  => $co2,
                'poluicao_evento_kwh'  => $kwh,
            ];
        }else{
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
                'poluicao_evento_co2'  => 0,
                'poluicao_evento_kwh'  => 0,
            ];
        }
        session()->put('produto_comparar1', $atributos_produto);


        

        $produto = Produto::where('id', $prods[1])->first();
        if($produto->pronto_a_vender != 0){
            $evento = Evento::where('id_produto', $prods[1])->get();
            $co2 = 0;
            $kwh = 0;
            foreach($eventos as $evento){
                $co2  =  $co2 + $evento->poluicao_co2_produzida;
                $kwh  =  $kwh + $evento->kwh_consumidos;
                
            }
            
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
                'poluicao_evento_co2'  => $co2,
                'poluicao_evento_kwh'  => $kwh,
            ];
        }else{
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
                'poluicao_evento_co2'  => 0,
                'poluicao_evento_kwh'  => 0,
            ];
        }
        session()->put('produto_comparar2', $atributos_produto);
        return redirect('/comparar-prods');
    }

    
    public function productAddDelCarrinho(Request $request) {
  
        $produto = Produto::where('id', $request->id)->first();

        //$html = "".$produto->get('nome_produto')." adicionado ao carrinho com sucesso!";
        if(session()->has('carrinho_produtos')){
            
            if (!$this->IsProductInCart($produto)){
                session()->push('carrinho_produtos', $produto);
            }

        } else {
            $carrinho = array();
            array_push($carrinho, $produto);
            session()->put('carrinho_produtos', $carrinho);
        } 

        return session()->get('carrinho_produtos');
        //return $html;
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

            $armazemLat = $armazem->latitude;
            $armazemLon = $armazem->longitude;

            $distanciasTransportadoras = array(); /* here */
            foreach ($coordsTransportadoras as &$coordsTransportadora) {
                $distanciaAprox = 0;
                $distanciaAprox += abs($armazemLat - $coordsTransportadora[2]);
                $distanciaAprox += abs($armazemLon - $coordsTransportadora[3]);

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
        $produto_kwh_consumidos_por_dia_no_armazem = $produto->kwh_consumidos_por_dia_no_armazem;
        

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
            "produto_kwh_consumidos_por_dia_no_armazem" => $produto_kwh_consumidos_por_dia_no_armazem,
            
        ];

        

        
        session()->put('produto_detalhes', $atributos_produto);
        return redirect('/produto-detalhes');
            
    }
}