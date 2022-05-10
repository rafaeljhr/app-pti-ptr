<?php

namespace App\Http\Controllers;

use App\Models\Tipo_de_conta;
use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            // dd($user);

            $email = $user->email;
            $nome = $user->name;
            $path_imagem = $user->avatar;
            $google_id = $user->id;

            
            session()->put('user_email', $email);
            session()->put('user_path_imagem', $path_imagem);
            session()->put('user_nome', $nome);
            session()->put('user_google_id', $google_id);

            if (session()->get('login_ou_registo') == "registo") {
                return redirect()->route('register-url');
            } else {

                $utilizador = Utilizador::where('google_id', session()->get('user_google_id'))->first();
                
                if ($utilizador) {

                    $tipo_conta_nome = (Tipo_de_conta::where('id', $utilizador->tipo_de_conta)->first())->nome;

                    session()->forget('failed_login');
                    session()->put('loggedIn', 'yes');
                    session()->put('userType', $tipo_conta_nome);
                    session()->put('user_id', $utilizador->id);
                    session()->put('user_email', $utilizador->email);
                    session()->put('user_primeiro_nome', $utilizador->primeiro_nome);
                    session()->put('user_ultimo_nome', $utilizador->ultimo_nome);
                    session()->put('user_path_imagem', $utilizador->path_imagem);
                    session()->put('user_numero_telemovel', $utilizador->numero_telemovel);
                    session()->put('user_numero_contribuinte', $utilizador->numero_contribuinte);
                    session()->put('user_morada', $utilizador->morada);
                    session()->put('user_codigo_postal', $utilizador->codigo_postal);
                    session()->put('user_cidade', $utilizador->cidade);
                    session()->put('user_pais', $utilizador->pais);
                    session()->put('user_google_id', $utilizador->google_id);

                    return redirect('/');
                    
                } else {
                    session()->forget('user_google_id');
                    session()->put('failed_login', "yes");
                    return redirect('/signin');

                }

            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}