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

    public function getAllCategoriesAndSubcategories()
    {
        $categories = Categoria::all();

        $all_categories = array();

        foreach($categories as $category) {

            $category_nome = $category->nome;

            array_push($all_categories, $category_nome);
        }

        session()->put('categories', $all_categories);

        $subcategories = Subcategoria::all();

        $all_subcategories = array();

        foreach($subcategories as $subcategory) {

            $atributos_subcategory = array();

            $subcategory_nome = $subcategory->nome;
            $subcategory_nome_categoria = $subcategory->nome_categoria;

            array_push($atributos_subcategory, $subcategory_nome);
            array_push($atributos_subcategory, $subcategory_nome_categoria);

            array_push($all_subcategories, $atributos_subcategory);
        }

        session()->put('subcategories', $all_subcategories);

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
            $filename= date('YmdHi').$file->getClientOriginalName();

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

        // adding the product to the session

        $atributos_produto = array();

        $produto_id = $newProduto->id;
        $produto_nome = $newProduto->nome;
        $produto_preco = $newProduto->preco;
        $produto_id_armazem = $newProduto->id_armazem;
        $produto_id_fornecedor = $newProduto->id_fornecedor;
        $produto_quantidade = $newProduto->quantidade;
        $produto_nome_categoria = $newProduto->nome_categoria;
        $produto_path_imagem = $newProduto->path_imagem;
        $produto_nome_subcategoria = $newProduto->nome_subcategoria;
        $produto_informacoes_adicionais = $newProduto->informacoes_adicionais;
        $produto_data_producao_do_produto = $newProduto->data_producao_do_produto;
        $produto_data_insercao_no_site = $newProduto->data_insercao_no_site;
        $produto_kwh_consumidos_por_dia = $newProduto->kwh_consumidos_por_dia;

        array_push($atributos_produto, $produto_id);
        array_push($atributos_produto, $produto_nome);
        array_push($atributos_produto, $produto_preco);
        array_push($atributos_produto, $produto_id_armazem);
        array_push($atributos_produto, $produto_id_fornecedor);
        array_push($atributos_produto, $produto_quantidade);
        array_push($atributos_produto, $produto_nome_categoria);
        array_push($atributos_produto, $produto_path_imagem);
        array_push($atributos_produto, $produto_nome_subcategoria);
        array_push($atributos_produto, $produto_informacoes_adicionais);
        array_push($atributos_produto, $produto_data_producao_do_produto);
        array_push($atributos_produto, $produto_data_insercao_no_site);
        array_push($atributos_produto, $produto_kwh_consumidos_por_dia);


        $all_fornecedor_produtos = session()->get('all_fornecedor_produtos');
        array_push($all_fornecedor_produtos, $atributos_produto);

        session()->put('all_fornecedor_produtos', $all_fornecedor_produtos);

        session()->put('last_added_product_id', $newProduto->id);

        session()->put('passo', 2);

        return redirect('/inventory');

    }


    public function getAllProducts()
    {
        $fornecedor_produtos = Produto::where('id_fornecedor', session()->get('user_id'))->get();

        $all_fornecedor_produtos = array();

        foreach($fornecedor_produtos as $produto) {

            $atributos_produto = array();

            $produto_id = $produto->id;
            $produto_nome = $produto->nome;
            $produto_id_armazem = $produto->id_armazem;
            $produto_id_fornecedor = $produto->id_fornecedor;
            $produto_nome_categoria = $produto->nome_categoria;
            $produto_path_imagem = $produto->path_imagem;
            $produto_nome_subcategoria = $produto->nome_subcategoria;
            $produto_informacoes_adicionais = $produto->informacoes_adicionais;
            $produto_data_producao_do_produto = $produto->data_producao_do_produto;
            $produto_data_insercao_no_site = $produto->data_insercao_no_site;
            $produto_kwh_consumidos_por_dia = $produto->kwh_consumidos_por_dia;

            array_push($atributos_produto, $produto_id);
            array_push($atributos_produto, $produto_nome);
            array_push($atributos_produto, $produto_id_armazem);
            array_push($atributos_produto, $produto_id_fornecedor);
            array_push($atributos_produto, $produto_nome_categoria);
            array_push($atributos_produto, $produto_path_imagem);
            array_push($atributos_produto, $produto_nome_subcategoria);
            array_push($atributos_produto, $produto_informacoes_adicionais);
            array_push($atributos_produto, $produto_data_producao_do_produto);
            array_push($atributos_produto, $produto_data_insercao_no_site);
            array_push($atributos_produto, $produto_kwh_consumidos_por_dia);


            array_push($all_fornecedor_produtos, $atributos_produto);
        }

        session()->put('all_fornecedor_produtos', $all_fornecedor_produtos);

        if(!(session()->has('categories'))){
            self::getAllCategoriesAndSubcategories(); // put all categories and subcategories in session
        }

        (new ArmazensController)->getAllArmazens(); // put all armazens of fornecedor in session

        return redirect('/inventory');
    }

    public function productRemoveLastAdded(){

        $produto = Produto::where('id', session()->get('last_added_product_id'))->first();
        $produto->delete();

        self::getAllProducts(); // rebuild the products in session

        session()->put('passo', 1);

    }

}