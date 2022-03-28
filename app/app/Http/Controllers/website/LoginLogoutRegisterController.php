<?php


namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consumidor;
use App\Models\fornecedor;
use App\Models\Transportadora;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginLogoutRegisterController extends Controller
{

    // Get an existing consumidor/transportadora/fornecedor
    public function login(Request $request)
    {

        $accountType = $request->get('selectedOption');
        $email = $request->get('usernameLogin');
        $password = $request->get('passwordLogin');

        if ($accountType == "consumidor") {

            $consumidor = Consumidor::where('email', $email)->first();

            if (!$consumidor || !Hash::check($password, $consumidor->password)) {
                Session::put('failed_login', "yes");
                return redirect('/signin');

            } else {
                session()->forget('failed_login');
                Session::put('userType', 'consumidor');
                Session::put('user_email', $consumidor->email);
                Session::put('user_nome', $consumidor->nome);
                Session::put('user_telemovel', $consumidor->telemovel);
                Session::put('user_nif', $consumidor->nif);
                Session::put('user_morada', $consumidor->morada);
                
                return redirect('/');
            }


        } elseif ($accountType == "fornecedor") {


            return $request->input();
        } else { 

            return $request->input();
        }
        
    }



    // Delete a consumidor/transportadora/fornecedor
    public function logout()
    {
        Session::flush();
        return redirect('/');
    }



    // Register a consumidor/transportadora/fornecedor
    public function register(Request $request)
    {
        return $request->input();
        $accountType = $request->get('selectedOption');

        if ($accountType == "consumidor") {

            $newConsumidor = new consumidor([
            'nome' => $request->get('name'),
            'telemovel' => $request->get('phone_number'),
            'nif' => $request->get('nif'),
            'morada' => $request->get('address'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'api_token' => Str::random(60)
            ]);


        } elseif ($accountType == "fornecedor") {

            


            return $request->input();

        } elseif ($accountType == "transportadora") {

            


            return $request->input();
            
        } else { 

            return $request->input();
        }

      
        // $newConsumidor = new consumidor([
        // 'nome' => $request->get('nome'),
        // 'email' => $request->get('email'),
        // 'password' => $request->get('password'),
        // 'telemovel' => $request->get('telemovel'),
        // 'nif' => $request->get('nif'),
        // 'morada' => $request->get('morada'),
        // 'api_token' => Str::random(60)
        // ]);
    
        // $newConsumidor->save();
    
        // return response()->json($newConsumidor);

        return $request->input();
    }



    // Update the information of a consumidor/transportadora/fornecedor
    public function update(Request $request, $id)
    {
        $consumidor = consumidor::findOrFail($id);

        $request->validate([
            'telefone' => 'required',
            'nome' => 'required',
            'nif' => 'required',
            'morada' => 'required'
        ]);

        $consumidor->telefone = $request->get('telefone');
        $consumidor->nome = $request->get('nome');
        $consumidor->nif = $request->get('nif');
        $consumidor->morada = $request->get('morada');

        $consumidor->save();

        return response()->json($consumidor);
    }



    // Delete a consumidor/transportadora/fornecedor
    public function delete(Request $request, $id)
    {
        $consumidor = consumidor::findOrFail($id);
        $consumidor->delete();

        return response()->json($consumidor::all());
    }


    
}
