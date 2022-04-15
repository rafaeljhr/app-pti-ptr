<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Armazem extends Model
{
    protected $table = 'armazem';

    public $timestamps = false;

    protected $fillable = [
        'morada', 'id_fornecedor'
    ];

    public function produto(){
      return $this->hasMany(Produto::class, 'id_armazem', 'id');
    }

    use HasFactory;
}
