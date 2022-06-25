<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProductsController;
use URL;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $timestamps = false;
    
	protected $table = 'produto';

    protected $fillable = [
        'nome', 'preco', 'id_armazem', 'id_fornecedor', 'quantidade', 'nome_categoria', 'path_imagem', 'nome_subcategoria', 'informacoes_adicionais', 'data_producao_do_produto', 'data_insercao_no_site', 'kwh_consumidos_por_dia_no_armazem', 'pronto_a_vender',
    ];

    

    public function scopegetAllProducts(){

        $produtos = DB::table("produto")
                    ->select("produto.id", "produto.nome", "produto.preco", "produto.path_imagem", "produto.quantidade","utilizador.ultimo_nome")
                    ->leftjoin("utilizador", function ($join) {
                        $join->on("produto.id_fornecedor", "=", "utilizador.id");
                    })
                    ->orderby("produto.quantidade", "desc")
                    ->orderby("utilizador.ultimo_nome", "desc")
                    ->groupby("produto.id")
                    ->get();

        $id = session()->get('user_id');

        return $produtos;
    }

    public function scopegetFavoritesProducts(){

        $id = session()->get('user_id');

        $favoritos = DB::table("produto")
                    ->select("produto.id", "produto.nome", "produto.preco", "produto.path_imagem", "produto.quantidade")
                    ->leftjoin("favoritos", function ($join) {
                        $join->on("produto.id", "=", "favoritos.id_produto");
                    })
                    ->where("favoritos.id_utilizador", "=", $id)
                    ->orderby("produto.quantidade", "desc")
                    ->groupby("produto.id")
                    ->get();

                    

        return $favoritos;
    }

    public function scopegetFavoritesProductsIDs(){

        $id = session()->get('user_id');

        $favoritos = DB::table("produto")
                    ->select("produto.id")
                    ->leftjoin("favoritos", function ($join) {
                        $join->on("produto.id", "=", "favoritos.id_produto");
                    })
                    ->where("favoritos.id_utilizador", "=", $id)
                    ->orderby("produto.quantidade", "desc")
                    ->groupby("produto.id")
                    ->get();

        return $favoritos->pluck("id");
    }

    public function scopegetHtmlProductStore($produtos){

        $html = "";

        $produtos = $produtos->get();

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

            if (session()->has("user_id")){
                $result = (new ProductsController)->isInCarrinho($produto);

                if (!$result){
                    $html .= '<p><button class="BtnAddDelProd" onclick="AdicionarApagarProdutoCarrinho(this, ' . $produto->id .',' . "'" . route('Add-Del-Carrinho') . "'" . ')">Adicionar ao Carrinho</button></p>';
                }else{
                    $html .= '<p><button class="BtnAddDelProd" style="background-color:red" onclick="AdicionarApagarProdutoCarrinho(this, ' . $produto->id  . ', ' . route('Add-Del-Carrinho') . ')">Remover do Carrinho</button></p>';
                }
            }

            $html .= "</div>";

        }
        
        return $html;

    }
}
            