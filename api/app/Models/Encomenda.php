<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    protected $table = 'encomenda';

    public $timestamps = false;

    protected $fillable = [
        'preco', 'morada_de_entrega', 'quantidade',
        'data_realizada', 'data_finalizada', 'id_consumidor',
        'id_produto', 'id_transportadora'
    ];

    use HasFactory;
}
