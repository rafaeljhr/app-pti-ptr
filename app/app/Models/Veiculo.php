<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    public $timestamps = false;
    
	protected $table = 'veiculo';

    protected $fillable = [
        'id_base', 'id_transportadora', 'nome', 'quantidade', 'tipoCombustivel', 'consumo_por_100km', 'path_imagem',
    ];
 
}