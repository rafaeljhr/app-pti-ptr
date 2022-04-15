<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Subcategoria;

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

        $request->validate([
            'nome'=>'required|string',
            'id_armazem'=>'required|string',
            'nome_categoria'=>'required|string',
            'nome_subcategoria'=>'required|string',
            'info_arbitraria'=>'required|string',
            'data_producao_do_produto'=>'required|string',
            'data_insercao_no_site'=>'required|string',
            'poluicao_gerada_por_dia'=>'required|string',
        ]);

        $newProduto = Produto::create([
            'nome' => $request->get('nome'),
            'id_armazem' => $request->get('id_armazem'),
            'id_fornecedor' => session()->get('id_fornecedor'),
            'nome_categoria' => $request->get('nome_categoria'),
            'nome_subcategoria' => $request->get('nome_subcategoria'),
            'info_arbitraria' => $request->get('info_arbitraria'),
            'data_producao_do_produto' => $request->get('data_producao_do_produto'),
            'data_insercao_no_site' => $request->get('data_insercao_no_site'),
            'poluicao_gerada_por_dia' => bcrypt($request->get('poluicao_gerada_por_dia'))
        ]);

        // adding the product to the session

        $atributos_produto = array();

        $produto_id = $newProduto->id;
        $produto_nome = $newProduto->nome;
        $produto_id_armazem = $newProduto->id_armazem;
        $produto_id_fornecedor = $newProduto->id_fornecedor;
        $produto_nome_categoria = $newProduto->nome_categoria;
        $produto_nome_subcategoria = $newProduto->nome_subcategoria;
        $produto_info_arbitraria = $newProduto->info_arbitraria;
        $produto_data_producao_do_produto = $newProduto->data_producao_do_produto;
        $produto_data_insercao_no_site = $newProduto->data_insercao_no_site;
        $produto_poluicao_gerada_por_dia = $newProduto->poluicao_gerada_por_dia;

        array_push($atributos_produto, $produto_id);
        array_push($atributos_produto, $produto_nome);
        array_push($atributos_produto, $produto_id_armazem);
        array_push($atributos_produto, $produto_id_fornecedor);
        array_push($atributos_produto, $produto_nome_categoria);
        array_push($atributos_produto, $produto_nome_subcategoria);
        array_push($atributos_produto, $produto_info_arbitraria);
        array_push($atributos_produto, $produto_data_producao_do_produto);
        array_push($atributos_produto, $produto_data_insercao_no_site);
        array_push($atributos_produto, $produto_poluicao_gerada_por_dia);


        $all_fornecedor_produtos = session()->get('all_fornecedor_produtos');
        array_push($all_fornecedor_produtos, $atributos_produto);

        session()->put('all_fornecedor_produtos', $all_fornecedor_produtos);

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
            $produto_nome_subcategoria = $produto->nome_subcategoria;
            $produto_info_arbitraria = $produto->info_arbitraria;
            $produto_data_producao_do_produto = $produto->data_producao_do_produto;
            $produto_data_insercao_no_site = $produto->data_insercao_no_site;
            $produto_poluicao_gerada_por_dia = $produto->poluicao_gerada_por_dia;

            array_push($atributos_produto, $produto_id);
            array_push($atributos_produto, $produto_nome);
            array_push($atributos_produto, $produto_id_armazem);
            array_push($atributos_produto, $produto_id_fornecedor);
            array_push($atributos_produto, $produto_nome_categoria);
            array_push($atributos_produto, $produto_nome_subcategoria);
            array_push($atributos_produto, $produto_info_arbitraria);
            array_push($atributos_produto, $produto_data_producao_do_produto);
            array_push($atributos_produto, $produto_data_insercao_no_site);
            array_push($atributos_produto, $produto_poluicao_gerada_por_dia);


            array_push($all_fornecedor_produtos, $atributos_produto);
        }

        session()->put('all_fornecedor_produtos', $all_fornecedor_produtos);

        if(!(session()->has('categories'))){
            self::getAllCategoriesAndSubcategories(); // put all categories and subcategories in session
        }

        return redirect('/inventory');
    }

    public function productDelete(Request $request){

        $produto = Produto::where('id', $request->get('id'))->first();
        $produto->delete();

        self::getAllProducts(); // rebuild the products in session

    }

}