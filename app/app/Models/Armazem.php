<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armazem extends Model
{
	protected $table = 'armazem';

    protected $fillable = [
        'id_fornecedor', 'morada', 'nome', 'recursos_consumidos_por_dia',
    ];
 
}