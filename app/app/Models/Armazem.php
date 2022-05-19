<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armazem extends Model
{
    public $timestamps = false;
    
	protected $table = 'armazem';

    protected $fillable = [
        'id_fornecedor', 'morada', 'codigo_postal', 'cidade', 'pais', 'nome', 'path_imagem',
    ];
 
}