<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Consumidor extends Model
{
	protected $table = 'consumidor';

    protected $fillable = [
        'nome', 'telefone', 'nif', 'morada', 'email', 'password'
    ];

    protected $hidden = [
        'password',
        'nif',
        'telefone',
        'morada',
        'updated_at',
        'created_at',
    ];
	
    use HasApiTokens, HasFactory;
}
