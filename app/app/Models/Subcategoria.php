<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
	protected $table = 'subcategoria';

    protected $fillable = [
        'nome', 'nome_categoria',
    ];
    
 
}