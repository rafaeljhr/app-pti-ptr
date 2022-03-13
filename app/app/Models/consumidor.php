<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consumidor extends Model
{
    protected $table = 'consumidor';
    use HasFactory;

    protected $fillable = [
        'telefone',
        'nome',
        'nif',
        'morada'
    ];
}
