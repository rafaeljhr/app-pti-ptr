<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Transportadora extends Model
{
    protected $table = 'transportadora';

    protected $fillable = [
        'morada_fiscal', 'telemovel', 'nif', 'nome', 'email', 'password'
    ];

    protected $hidden = [
        'password',
        'nif',
        'updated_at',
        'created_at',
    ];
	
    use HasApiTokens, HasFactory;
}
