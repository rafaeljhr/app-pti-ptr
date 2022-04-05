<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class fornecedor extends Model
{
    protected $table = 'fornecedor';

    protected $fillable = [
        'morada', 'telefone', 'nif', 'nome', 'email', 'password'
    ];

    protected $hidden = [
        'password',
        'nif',
        'updated_at',
        'created_at',
    ];

    public function produto()
    {
      return $this->hasMany(Produto::class, 'id_fornecedor', 'id');
    }

    public function armazem(){
        return $this->hasMany(Armazem::class, 'id_fornecedor', 'id');
    }
	
    use HasApiTokens, HasFactory;
}
