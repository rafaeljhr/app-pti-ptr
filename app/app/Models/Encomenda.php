<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    public $timestamps = false;
    
	protected $table = 'encomenda';

    protected $fillable = [
        'preco', 'morada', 'codigo_postal', 'cidade', 'pais', 'quantidade', 'data_realizada', 'data_finalizada', 'id_consumidor', 'id_produto', 'id_transportadora', 'id_fornecedor', 'estado_encomenda',
    ];
 
}