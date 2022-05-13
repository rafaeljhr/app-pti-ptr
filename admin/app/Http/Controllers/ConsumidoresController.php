<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consumidor;

class ConsumidoresController extends Controller
{
    public function index()
    {
        $users =  Consumidor::all();
        
        return view('consumidores', compact('users'));
    } 
}
