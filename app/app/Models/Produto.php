<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

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

        $favoritos = 0;

        if($id != null){
            $utilizador = Utilizador::findOrFail($id);
            $favoritos = $utilizador->favoritos->pluck('id_produto');
        }

        return [$produtos, $favoritos];
    }
}
            