<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Utilizador extends Model
{
    public $timestamps = false;

	protected $table = 'utilizador';

    protected $fillable = [
        'id',
        'email', 
        'password', 
        'primeiro_nome', 
        'ultimo_nome', 
        'path_imagem', 
        'numero_telemovel', 
        'numero_contribuinte', 
        'morada',
        'codigo_postal',
        'cidade',
        'pais',
        'google_id', 
        'tipo_de_conta',
    ];

    protected $hidden = [
        'password',
        'numero_telemovel',
        'numero_contribuinte',
        'morada',
        'codigo_postal',
        'cidade',
        'google_id',
    ];
	
    use HasApiTokens, HasFactory;
}
