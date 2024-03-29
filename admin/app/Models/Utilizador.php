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
        'email', 'password', 'primeiro_nome', 'ultimo_nome', 'path_imagem', 'numero_telemovel', 'numero_contribuinte',
        'morada', 'codigo_postal', 'cidade', 'pais', 'tipo_de_conta', 'google_id'
    ];

    protected $hidden = [
        'google_id',
        'updated_at',
        'created_at',
    ];
	
    use HasApiTokens, HasFactory;
}
