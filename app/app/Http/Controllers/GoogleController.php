<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Fornecedor;
use App\Models\Transportadora;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

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

                $consumidor = Consumidor::where('google_id', session()->get('user_google_id'))->first();
                $fornecedor = Fornecedor::where('google_id', session()->get('user_google_id'))->first();
                $transportadora = Transportadora::where('google_id', session()->get('user_google_id'))->first();

                if ($consumidor || $fornecedor || $transportadora) {
                    session()->forget('failed_login');
                    return redirect('/signin');
                    
                } else {
                    session()->forget('user_google_id');
                    session()->put('failed_login', "yes");
                    return redirect('/signin');

                }

            }

            

            // Check Users Email If Already There
            // $is_user = Consumidor::where('email', $user->getEmail())->first();
            




            // 'password' => Hash::make($user->getName().'@'.$user->getId())

            // if(!$is_user){

            //     $saveUser = Consumidor::updateOrCreate([
            //         'google_id' => $user->getId(),
            //     ],[
            //         'nome' => $user->getName(),
            //         'email' => $user->getEmail(),
                    
            //         'path_imagem' >=
            //     ]);

            // }else{
            //     $saveUser = Consumidor::where('email',  $user->getEmail())->update([
            //         'google_id' => $user->getId(),
            //     ]);
            //     $saveUser = Consumidor::where('email', $user->getEmail())->first();
            // }

            

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}