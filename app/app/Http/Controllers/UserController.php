<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consumidor;
use App\Models\Fornecedor;
use App\Models\Transportadora;
use Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // Get an existing consumidor/transportadora/fornecedor
    public function login(Request $request)
    {

        $accountType = $request->get('inlineRadioOptions');
        $email = $request->get('usernameLogin');
        $password = $request->get('passwordLogin');

        if ($accountType == "consumidor") {

            $consumidor = Consumidor::where('email', $email)->first();

            if (!$consumidor || !Hash::check($password, $consumidor->password)) {
                Session::put('failed_login', "yes");
                return redirect('/signin');

            } else {
                session()->forget('failed_login');
                Session::put('loggedIn', 'yes');
                Session::put('userType', 'consumidor');
                Session::put('user_email', $consumidor->email);
                Session::put('user_nome', $consumidor->nome);
                Session::put('user_telemovel', $consumidor->telemovel);
                Session::put('user_nif', $consumidor->nif);
                Session::put('user_morada', $consumidor->morada);
                
                return redirect('/');
            }


        } elseif ($accountType == "fornecedor") {

            $fornecedor = Fornecedor::where('email', $email)->first();

            if (!$fornecedor || !Hash::check($password, $fornecedor->password)) {
                Session::put('failed_login', "yes");
                return redirect('/signin');

            } else {
                session()->forget('failed_login');
                Session::put('loggedIn', 'yes');
                Session::put('userType', 'fornecedor');
                Session::put('user_email', $fornecedor->email);
                Session::put('user_nome', $fornecedor->nome);
                Session::put('user_telemovel', $fornecedor->telemovel);
                Session::put('user_nif', $fornecedor->nif);
                Session::put('user_morada', $fornecedor->morada);
                
                return redirect('/');
            }


        } elseif ($accountType == "transportadora") {

            $transportadora = Transportadora::where('email', $email)->first();

            if (!$transportadora || !Hash::check($password, $transportadora->password)) {
                Session::put('failed_login', "yes");
                return redirect('/signin');

            } else {
                session()->forget('failed_login');
                Session::put('loggedIn', 'yes');
                Session::put('userType', 'transportadora');
                Session::put('user_email', $transportadora->email);
                Session::put('user_nome', $transportadora->nome);
                Session::put('user_telemovel', $transportadora->telemovel);
                Session::put('user_nif', $transportadora->nif);
                Session::put('user_morada', $transportadora->morada);
                
                return redirect('/');
            }


        } else { 
            print "Erro no login! O userType recebido é diferente de transportadora/fornecedor/consumidor !";
            print "";
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
        
        $accountType = $request->get('selectedOption');

        $request->validate([
            'name'=>'required|string',
            'phone_number'=>'required|string',
            'nif'=>'required|string',
            'address'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        if ($accountType == "consumidor") {

            $newConsumidor = Consumidor::create([
                'nome' => $request->get('name'),
                'telefone' => $request->get('phone_number'),
                'nif' => $request->get('nif'),
                'morada' => $request->get('address'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);
    
            Session::put('userType', 'consumidor');
            Session::put('user_email', $newConsumidor->email);
            Session::put('user_nome', $newConsumidor->nome);
            Session::put('user_telemovel', $newConsumidor->telemovel);
            Session::put('user_nif', $newConsumidor->nif);
            Session::put('user_morada', $newConsumidor->morada);
        

        } elseif ($accountType == "fornecedor") {

            $newFornecedor = Fornecedor::create([
                'nome' => $request->get('name'),
                'telefone' => $request->get('phone_number'),
                'nif' => $request->get('nif'),
                'morada' => $request->get('address'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);
    
            Session::put('userType', 'fornecedor');
            Session::put('user_email', $newFornecedor->email);
            Session::put('user_nome', $newFornecedor->nome);
            Session::put('user_telemovel', $newFornecedor->telemovel);
            Session::put('user_nif', $newFornecedor->nif);
            Session::put('user_morada', $newFornecedor->morada);


        } elseif ($accountType == "transportadora") {
            
            $newTransportadora = Transportadora::create([
                'nome' => $request->get('name'),
                'telefone' => $request->get('phone_number'),
                'nif' => $request->get('nif'),
                'morada' => $request->get('address'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);
    
            Session::put('userType', 'transportadora');
            Session::put('user_email', $newTransportadora->email);
            Session::put('user_nome', $newTransportadora->nome);
            Session::put('user_telemovel', $newTransportadora->telemovel);
            Session::put('user_nif', $newTransportadora->nif);
            Session::put('user_morada', $newTransportadora->morada);

            
        } else { 
            print "Erro no register! O userType recebido é diferente de transportadora/fornecedor/consumidor !";
            print "";
            return $request->input();
        }

        return redirect('/');

    }



    // Update the information of a consumidor/transportadora/fornecedor
    public function update(Request $request)
    {
        return $request->input();

        $request->validate([
            'name'=>'sometimes|required|string',
            'phone_number'=>'sometimes|required|string',
            'nif'=>'sometimes|required|string',
            'address'=>'sometimes|required|string',
            'email'=>'sometimes|required|string',
            'password'=>'sometimes|required|string',
        ]);

        if (Session::get('userType') == "consumidor") {

            $consumidor = Consumidor::where('email', $email)->first();
            $consumidor->update($request->all());

        } elseif (Session::get('userType') == "fornecedor") {

            $consumidor = Consumidor::where('email', $email)->first();
            $consumidor->update($request->all());

        } elseif (Session::get('userType') == "transportadora") {

            $consumidor = Consumidor::where('email', $email)->first();
            $consumidor->update($request->all());

        } else {
            print "Erro no update dos dados do utilizador! O userType da sessão é diferente de transportadora/fornecedor/consumidor !";
            print "";
            return $request->input();
        }

        return redirect('/profile');

    }



    // Delete a consumidor/transportadora/fornecedor
    public function delete()
    {
        if (Session::get('userType') == "consumidor") {

            $consumidor = Consumidor::where('email', Session::get('user_email'))->first();
            $consumidor->delete();

        } elseif (Session::get('userType') == "fornecedor") {

            $fornecedor = Fornecedor::where('email', Session::get('user_email'))->first();
            $fornecedor->delete();

        } elseif (Session::get('userType') == "transportadora") {

            $transportadora = Transportadora::where('email', Session::get('user_email'))->first();
            $transportadora->delete();

        } else {
            print "Erro no delete do utilizador! O userType da sessão é diferente de transportadora/fornecedor/consumidor !";
            print "";
            return $request->input();
        }

        Session::flush();
        return redirect('/');
    }

}
