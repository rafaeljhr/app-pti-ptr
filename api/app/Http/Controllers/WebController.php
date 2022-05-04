<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consumidor;
use App\Models\Transportadora;
use App\Models\fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'tipo_conta' => $request->get('tipo_conta'),
            'email' => $request->get('email'),
            'password' => $request->get('password')
        );

        if($this->checkLoginDetails($user_data)){

            session()->put('user_email', $user_data['email']);
            session()->put('tipo_conta', $user_data['tipo_conta']);

            return redirect('index');
        }else{
            return back()->with('error', 'Email ou Password errados');
        }

    }
    
    function checkLoginDetails(array $user_data){

        if ($user_data['tipo_conta'] == 'consumidor'){
            $user = Consumidor::where('email', $user_data['email'])->first();
        }elseif ($user_data['tipo_conta'] == 'transportadora'){
            $user = Transportadora::where('email', $user_data['email'])->first();
        }elseif ($user_data['tipo_conta'] == 'fornecedor'){
            $user = fornecedor::where('email', $user_data['email'])->first();
        }else{
            return FALSE;
        }

        if (!$user || !Hash::check($user_data['password'], $user->password)){
    
            return FALSE;
        }

        session()->put('user_nome', $user['nome']);
        session()->put('user', $user);

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

        $tipo_conta = session()->get('tipo_conta');
        $email = session()->get('user_email');

        if ($tipo_conta == 'consumidor'){
            $user = Consumidor::where('email', $email)->first();
        }elseif ($tipo_conta == 'transportadora'){
            $user = Transportadora::where('email', $email)->first();
        }elseif ($tipo_conta == 'fornecedor'){
            $user = fornecedor::where('email', $email)->first();
        }

        $user->tokens()->delete();

        $token = $user->createToken('API_TokenAcess',[$tipo_conta])->plainTextToken;

        return $token;
    }
}
