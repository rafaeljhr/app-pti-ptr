<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';

    public $timestamps = false;

    protected $fillable = [
        'username', 'password', 'cargo'
    ];

    protected $hidden = [
        'username',
        'password',
        'cargo'
    ];

    use HasFactory;
}
