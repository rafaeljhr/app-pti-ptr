<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Subcategoria;
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

        (new ArmazensController)->getAllArmazens(); // put all armazens of fornecedor in session

    }


    public function productRegister(Request $request)
    {

        // return $request->input();

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


        $filename = "public/images/default_produto.jpg";

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


        session()->put('last_added_product_id', $newProduto->id);

        self::rebuild_fornecedor_session(); // REBUILD THE FORNECEDOR SESSION

        return view('inventory');

    }


    public static function getAllProducts()
    {
        self::rebuild_fornecedor_session(); // BUILD THE FORNECEDOR SESSION
        
        return view('inventory');
    }


    public function productRemoveLastAdded(){

        $produto = Produto::where('id', session()->get('last_added_product_id'))->first();
        $produto->delete();

        session()->forget('last_added_product_id');

        return redirect('/inventory'); // this will rebuild the sessions vars

    }


    public function productAddEvent(Request $request){

        $request->validate([
        ]);

        self::rebuild_fornecedor_session(); // REBUILD THE FORNECEDOR SESSION

        return view('inventory');

    }

}