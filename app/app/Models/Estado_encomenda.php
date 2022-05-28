<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado_encomenda extends Model
{

    public $timestamps = false;
    
	protected $table = 'estado_encomenda';

    protected $fillable = [
        'nome',
    ];
 
}