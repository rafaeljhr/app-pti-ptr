<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;  

class WebController extends Controller
{
    function login(){
        return view('login');
    }

    function checklogin(Request $request){

        $this-> validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:1'
        ]);

        $user_data = array(
            'email' => $request->get('email'),
            'password' => $request->get('password')
        );

        if($this->checkLoginDetails($user_data)){

            return redirect('index');
        }else{
            return back()->with('error', 'Email ou Password errados');
        }

    }
    
    function checkLoginDetails(array $user_data){

        $user = Utilizador::where('email', $user_data['email'])->first();
        
        if (!$user || !Hash::check($user_data['password'], $user->password)){
            
            return FALSE;
        }

        session()->put('user', $user);
        session()->put('user_nome', $user->primeiro_nome);
        
        return TRUE;

    }

    function index(){
        return view('index');
    }

    function logout(){

        session()->flush();

        return redirect('login');
    }

    function GetToken(){
        $token = $this->GerenateToken();
        
        return redirect()->route('index')->with([ 'token' => $token ]);
    }

    function GerenateToken(){

        $user = session()->get('user');

        $tipo_conta = DB::table('tipo_de_conta')->where('id', $user->tipo_de_conta)->value('nome');

        $user->tokens()->delete();

        $token = $user->createToken('API_TokenAcess',[$tipo_conta])->plainTextToken;

        return $token;
    }
}
