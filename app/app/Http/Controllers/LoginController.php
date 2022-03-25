<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LoginController extends Controller{

    public function submit(Request $request){
        $validated = $request->validate([
            'inlineRadioOptions' => 'required',
            'usernameLogin' => 'required|email',
            'passwordLogin' => 'required',
        ]);

        dd($request);
    }
}