<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
	protected $table = 'produto';

    protected $fillable = [
        'nome', 'id_armazem', 'id_fornecedor', 'nome_categoria', 'nome_subcategoria', 'info_arbitraria', 'data_producao_do_produto', 'data_insercao_no_site', 'poluicao_gerada_por_dia',
    ];
 
}