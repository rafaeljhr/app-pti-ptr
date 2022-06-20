<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    public $timestamps = false;
    
	protected $table = 'base';

    protected $fillable = [
        'id_transportadora', 'morada', 'codigo_postal', 'cidade', 'pais', 'nome', 'path_imagem', 'preco',
    ];
 
}