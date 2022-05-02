<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    public $timestamps = false;
    
	protected $table = 'eventos_da_cadeia_logistica_do_produto';

    protected $fillable = [
        'id_produto', 'nome', 'co2_produzido', 'kwh_consumidos', 'descricao_do_evento',
    ];
 
}