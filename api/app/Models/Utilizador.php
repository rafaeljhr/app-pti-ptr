<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Utilizador extends Model
{
	protected $table = 'utilizador';

    public $timestamps = false;

    protected $fillable = [
        'email', 'password', 'primeiro_nome', 'ultimo_nome', 'path_imagem', 'numero_telemovel', 'numero_contribuinte',
        'morada', 'codigo_postal', 'cidade', 'pais', 'tipo_de_conta', 'google_id'
    ];

    protected $hidden = [
        'google_id',
        'updated_at',
        'created_at',
        'numero_contribuinte',
        'cidade',
        'tipo_de_conta',
        'codigo_postal',
        'morada',
        'numero_telemovel',
        'longitude',
        'latitude',
        'password'
    ];

    public function encomendas(){
        return $this->hasMany(Encomenda::class, 'id_consumidor', 'id');
    }

    public function produto(){
      return $this->hasMany(Produto::class, 'id_fornecedor', 'id');
    }

    public function armazem(){
        return $this->hasMany(Armazem::class, 'id_fornecedor', 'id');
    }

    public function base_transportadora(){
        return $this->hasMany(base_transportadora::class, 'id_transportadora', 'id');
    }
	
    use HasApiTokens, HasFactory;
}
