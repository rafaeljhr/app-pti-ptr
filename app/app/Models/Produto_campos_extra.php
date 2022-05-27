<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto_campos_extra extends Model
{
    public $timestamps = false;
	protected $table = 'produto_campos_extra';

    protected $primaryKey = ['id_produto', 'campo_extra'];
    public $incrementing = false;

    protected $fillable = [
        'id_produto', 'campo_extra', "valor_campo",
    ];
 
}