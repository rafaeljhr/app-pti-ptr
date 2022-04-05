<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Produto extends Model
{
    public $timestamps = false;

	protected $table = 'produto';

    protected $fillable = [
        'preco', 'nome', 'data_producao_do_produto', 
        'data_insercao_no_site', 'poluicao_gerada_por_dia', 'info_arbitraria',
        'id_armazem', 'id_fornecedor', 'nome_categoria', 'nome_subcategoria'
    ];

    protected $hidden = [
        'id_armazem',
    ];

    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class, 'id_fornecedor');
    }
	
    use HasApiTokens, HasFactory;
}
