<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
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
            $user = Socialite::driver('google')->user();

            dd($user);

            // Check Users Email If Already There
            $is_user = Consumidor::where('email', $user->getEmail())->first();
            
            if(!$is_user){

                $saveUser = Consumidor::updateOrCreate([
                    'google_id' => $user->getId(),
                ],[
                    'nome' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make($user->getName().'@'.$user->getId())
                ]);
            }else{
                $saveUser = Consumidor::where('email',  $user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);
                $saveUser = Consumidor::where('email', $user->getEmail())->first();
            }

            return redirect()->route('home-url');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}