<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	protected $table = 'categoria';

    protected $fillable = [
        'nome',
    ];

    public function scopegetSQLCategoryResult(String $Categoria){

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
}