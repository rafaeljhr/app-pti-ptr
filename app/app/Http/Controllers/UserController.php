<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consumidor;
use App\Models\Fornecedor;
use App\Models\Transportadora;
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
                session()->put('failed_login', "yes");
                return redirect('/signin');

            } else {
                session()->forget('failed_login');
                session()->put('loggedIn', 'yes');
                session()->put('userType', 'consumidor');
                session()->put('user_id', $consumidor->id);
                session()->put('user_email', $consumidor->email);
                session()->put('user_nome', $consumidor->nome);
                session()->put('user_telefone', $consumidor->telefone);
                session()->put('user_nif', $consumidor->nif);
                session()->put('user_morada', $consumidor->morada);
                
                return redirect('/');
            }


        } elseif ($accountType == "fornecedor") {

            $fornecedor = Fornecedor::where('email', $email)->first();

            if (!$fornecedor || !Hash::check($password, $fornecedor->password)) {
                session()->put('failed_login', "yes");
                return redirect('/signin');

            } else {
                session()->forget('failed_login');
                session()->put('loggedIn', 'yes');
                session()->put('userType', 'fornecedor');
                session()->put('user_id', $fornecedor->id);
                session()->put('user_email', $fornecedor->email);
                session()->put('user_nome', $fornecedor->nome);
                session()->put('user_telefone', $fornecedor->telefone);
                session()->put('user_nif', $fornecedor->nif);
                session()->put('user_morada', $fornecedor->morada);
                
                return redirect('/');
            }


        } elseif ($accountType == "transportadora") {

            $transportadora = Transportadora::where('email', $email)->first();

            if (!$transportadora || !Hash::check($password, $transportadora->password)) {
                session()->put('failed_login', "yes");
                return redirect('/signin');

            } else {
                session()->forget('failed_login');
                session()->put('loggedIn', 'yes');
                session()->put('userType', 'transportadora');
                session()->put('user_id', $transportadora->id);
                session()->put('user_email', $transportadora->email);
                session()->put('user_nome', $transportadora->nome);
                session()->put('user_telefone', $transportadora->telefone);
                session()->put('user_nif', $transportadora->nif);
                session()->put('user_morada', $transportadora->morada);
                
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
        session()->flush();
        return redirect('/');
    }


    // Saber se 
    public function register_etapa1(Request $request)
    {
        return $request->input();
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
    
            session()->put('loggedIn', 'yes');
            session()->put('userType', 'consumidor');
            session()->put('user_id', $newConsumidor->id);
            session()->put('user_email', $newConsumidor->email);
            session()->put('user_nome', $newConsumidor->nome);
            session()->put('user_telefone', $newConsumidor->telefone);
            session()->put('user_nif', $newConsumidor->nif);
            session()->put('user_morada', $newConsumidor->morada);
        

        } elseif ($accountType == "fornecedor") {

            $newFornecedor = Fornecedor::create([
                'nome' => $request->get('name'),
                'telefone' => $request->get('phone_number'),
                'nif' => $request->get('nif'),
                'morada' => $request->get('address'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);
    
            session()->put('loggedIn', 'yes');
            session()->put('userType', 'fornecedor');
            session()->put('user_id', $newFornecedor->id);
            session()->put('user_email', $newFornecedor->email);
            session()->put('user_nome', $newFornecedor->nome);
            session()->put('user_telefone', $newFornecedor->telefone);
            session()->put('user_nif', $newFornecedor->nif);
            session()->put('user_morada', $newFornecedor->morada);


        } elseif ($accountType == "transportadora") {
            
            $newTransportadora = Transportadora::create([
                'nome' => $request->get('name'),
                'telefone' => $request->get('phone_number'),
                'nif' => $request->get('nif'),
                'morada' => $request->get('address'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);
    
            session()->put('loggedIn', 'yes');
            session()->put('userType', 'transportadora');
            session()->put('user_id', $newTransportadora->id);
            session()->put('user_email', $newTransportadora->email);
            session()->put('user_nome', $newTransportadora->nome);
            session()->put('user_telefone', $newTransportadora->telefone);
            session()->put('user_nif', $newTransportadora->nif);
            session()->put('user_morada', $newTransportadora->morada);

            
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
        // return $request->input();
        $request->validate([
            'nome'=>'sometimes|required|string',
            'telefone'=>'sometimes|required|string',
            'nif'=>'sometimes|required|string',
            'morada'=>'sometimes|required|string',
            'email'=>'sometimes|required|string',
            'password'=>'sometimes|required|string',
        ]);

        if (session()->get('userType') == "consumidor") {

            $consumidor = Consumidor::where('email', session()->get('user_email'))->first();
            $consumidor->update($request->all());
            
            session()->put('user_id', $consumidor->id);
            session()->put('user_email', $consumidor->email);
            session()->put('user_nome', $consumidor->nome);
            session()->put('user_telefone', $consumidor->telefone);
            session()->put('user_nif', $consumidor->nif);
            session()->put('user_morada', $consumidor->morada);

        } elseif (session()->get('userType') == "fornecedor") {

            $fornecedor = Fornecedor::where('email', session()->get('user_email'))->first();

            $fornecedor->update($request->all());

            session()->put('user_id', $fornecedor->id);
            session()->put('user_email', $fornecedor->email);
            session()->put('user_nome', $fornecedor->nome);
            session()->put('user_telefone', $fornecedor->telefone);
            session()->put('user_nif', $fornecedor->nif);
            session()->put('user_morada', $fornecedor->morada);

        } elseif (session()->get('userType') == "transportadora") {

            $transportadora = Transportadora::where('email', session()->get('user_email'))->first();
            $transportadora->update($request->all());

            session()->put('user_id', $transportadora->id);
            session()->put('user_email', $transportadora->email);
            session()->put('user_nome', $transportadora->nome);
            session()->put('user_telefone', $transportadora->telefone);
            session()->put('user_nif', $transportadora->nif);
            session()->put('user_morada', $transportadora->morada);

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
        if (session()->get('userType') == "consumidor") {

            $consumidor = Consumidor::where('email', session()->get('user_email'))->first();
            $consumidor->delete();

        } elseif (session()->get('userType') == "fornecedor") {

            $fornecedor = Fornecedor::where('email', session()->get('user_email'))->first();
            $fornecedor->delete();

        } elseif (session()->get('userType') == "transportadora") {

            $transportadora = Transportadora::where('email', session()->get('user_email'))->first();
            $transportadora->delete();

        } else {
            print "Erro no delete do utilizador! O userType da sessão é diferente de transportadora/fornecedor/consumidor !";
            print "";
        }

        session()->flush();
        return redirect('/');
    }

}
