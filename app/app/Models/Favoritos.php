<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favoritos extends Model
{
    public $timestamps = false;
    
	protected $table = 'favoritos';

    protected $fillable = [
        'id_utilizador', 'id_produto', 'mensagem',
    ];
 
}