<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Fornecedor extends Model
{
    protected $table = 'fornecedor';

    protected $fillable = [
        'email', 'password', 'nome', 'path_imagem', 'telefone', 'nif', 'morada', 'google_id'
    ];

    protected $hidden = [
        'password',
        'nif',
        'google_id',
        'updated_at',
        'created_at',
    ];
	
    use HasApiTokens, HasFactory;
}
