<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\base_transportadora;

class Transportadora extends Model
{
    protected $table = 'transportadora';

    protected $fillable = [
        'morada', 'telefone', 'nif', 'nome', 'email', 'password'
    ];

    protected $hidden = [
        'password',
        'nif',
        'updated_at',
        'created_at',
    ];

    public function base_transportadora()
    {
      return $this->hasMany(base_transportadora::class, 'id_transportadora', 'id');
    }
	
    use HasApiTokens, HasFactory;
}
