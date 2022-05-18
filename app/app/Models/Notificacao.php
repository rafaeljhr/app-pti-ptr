<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    public $timestamps = false;
    
	protected $table = 'notificacoes';

    protected $fillable = [
        'id_utilizador', 'mensagem', 'estado',
    ];
 
}