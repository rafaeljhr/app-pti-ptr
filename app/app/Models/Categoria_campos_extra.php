<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria_campos_extra extends Model
{
    
	protected $table = 'categoria_campos_extra';

    protected $fillable = [
        'nome_categoria', 'campo_extra', 'nome_campo_extra', 
    ];
 
}