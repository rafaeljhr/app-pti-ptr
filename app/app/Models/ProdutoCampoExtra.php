<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoCampoExtra extends Model
{
	protected $table = 'produto_campos_extra';

    protected $fillable = [
        'id_produto', 'campo_extra', 'valor_campo',
    ];
 
}