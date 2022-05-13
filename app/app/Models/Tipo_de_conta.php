<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_de_conta extends Model
{
	protected $table = 'tipo_de_conta';

    protected $fillable = [
        'nome',
    ];
 
}