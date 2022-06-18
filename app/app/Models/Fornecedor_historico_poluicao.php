<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor_historico_poluicao extends Model
{
    public $timestamps = false;
    
	protected $table = 'fornecedor_historico_poluicao';

    protected $fillable = [
        'id_fornecedor', 'poluicao_co2_produzida', 'kwh_consumidos',
    ];
 
}