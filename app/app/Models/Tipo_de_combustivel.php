<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_de_combustivel extends Model
{
	protected $table = 'tipo_combustivel';

    protected $fillable = [
        'nome', 'co2_por_km',
    ];
 
}