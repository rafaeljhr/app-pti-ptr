<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Consumidor extends Model
{
	protected $table = 'consumidor';

    protected $fillable = [
        'email', 'password', 'nome', 'path_imagem', 'telefone', 'nif', 'morada', 'google_id'
    ];

    protected $hidden = [
        'password',
        'nif',
        'telefone',
        'morada',
        'google_id',
        'updated_at',
        'created_at',
    ];
	
    use HasApiTokens, HasFactory;
}
