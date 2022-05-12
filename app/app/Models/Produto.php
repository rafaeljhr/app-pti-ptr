<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $timestamps = false;
    
	protected $table = 'produto';

    protected $fillable = [
        'nome', 'preco', 'id_armazem', 'id_fornecedor', 'quantidade', 'nome_categoria', 'path_imagem', 'nome_subcategoria', 'informacoes_adicionais', 'data_producao_do_produto', 'data_insercao_no_site', 'kwh_consumidos_por_dia_no_armazem',
    ];
 
}