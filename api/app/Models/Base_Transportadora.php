<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base_Transportadora extends Model
{
    public $timestamps = false;

	protected $table = 'base';

    protected $fillable = [
        'morada', 'id_transportadora', 'telefone'
    ];

    use HasFactory;
}
