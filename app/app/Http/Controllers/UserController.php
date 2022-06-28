<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notificacao;
use App\Models\Favoritos;
use Illuminate\Http\Request;
use App\Models\Utilizador;
use App\Models\Produto;
use App\Models\ProdutoCampoExtra;
use App\Models\Evento;
use App\Models\Armazem;
use App\Models\Veiculo;
use App\Models\Fornecedor_historico_poluicao;
use App\Models\Base;
use App\Models\Tipo_de_conta;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->get('usernameLogin');
        $password = $request->get('passwordLogin');

        $utilizador = Utilizador::where('email', $email)->first();

        if (!$utilizador || !Hash::check($password, $utilizador->password)) {
            session()->put('failed_login', "yes");
            return redirect('/signin');

        } else {
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
            session()->put('user_latitude', $utilizador->latitude);
            session()->put('user_longitude', $utilizador->longitude);

            NotificationController::obter_notificacoes_do_utilizador();
            
            ProductsController::obter_favoritos_do_utilizador();
            return redirect('/');
        }
        
    }


    // Delete a consumidor/transportadora/fornecedor
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }


    public function changePassword(Request $request)
    {
        $old_pass = $request->get('oldPass');
        $new_pass = $request->get('newPass1');

        $utilizador = Utilizador::where('email', session()->get('user_email'))->first();

        if (Hash::check($old_pass, $utilizador->password)) {

            $utilizador->password = bcrypt($new_pass);
            $utilizador->save();

            session()->forget('failed_password_change');
            return redirect('/profile');

        } else {
            return "falhou mudar password";

            session()->put('failed_password_change', "yes");
            return redirect('/profile');
        }

    }


    public function changeAvatar(Request $request)
    {
        
        $utilizador = Utilizador::where('email', session()->get('user_email'))->first();

        if($request->file('mudar_path_imagem')){
                
            $allowedMimeTypes = ['image/jpeg', 'image/jpg','image/gif','image/png'];
            $contentType = $request->file('mudar_path_imagem')->getClientMimeType();

            if(!in_array($contentType, $allowedMimeTypes) ){
                return response()->json('error: Not an image submited in the form');
            }

            $file= $request->file('mudar_path_imagem');
            $filename= uniqid().$file->getClientOriginalName();

            if (!$file-> move(public_path('images/users_images/'), $filename)) {
                return 'Error saving the file';
            }

            $filename = 'images/users_images/' . $filename;
            
        } else {
            return "falhou mudar avatar";
            return redirect('/profile');
        }

        if (!(str_contains($utilizador->path_imagem , 'http'))) {
            if ($utilizador->path_imagem != "images/default_user.png") {
                unlink($utilizador->path_imagem); // apagar a imagem antiga
            }
        }

        $utilizador->path_imagem = $filename;
        $utilizador->save();

        session()->put('user_path_imagem', $filename);

        return redirect('/profile');

    }


    // Register a consumidor/transportadora/fornecedor
    public function register(Request $request)
    {

        $accountType = $request->get('selectedOption');

        if (!($accountType=="consumidor" || $accountType=="fornecedor" || $accountType=="transportadora")) {
            print "Erro no register! O userType recebido é diferente de transportadora/fornecedor/consumidor !";
            print "";
            return $request->input();
        }
        

        $request->validate([
            'email'=>'required|string',
            'primeiro_nome'=>'required|string',
            'ultimo_nome'=>'required|string',
            'telemovel'=>'required|integer',
            'numero_contribuinte'=>'required|integer',
            'morada'=>'required|string',
            'cidade'=>'required|string',
            'codigo_postal_1'=>'required|integer',
            'codigo_postal_2'=>'required|integer',
            'pais'=>'required|string',
            'password'=>'required|string',
        ]);


        $codigo_postal = $request->get('codigo_postal_1') . "-" . $request->get('codigo_postal_2');

        $tipos_de_conta = Tipo_de_conta::all();

        $tipo_de_conta_novo_utilizador_id = "";
        foreach($tipos_de_conta as $tipo) {
            if ($tipo->nome == $request->get('selectedOption')) {
                $tipo_de_conta_novo_utilizador_id = $tipo->id;
            } 
        }

        if (session()->has('user_google_id')) {
            $newUtilizador = Utilizador::create([
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'primeiro_nome' => $request->get('primeiro_nome'),
                'ultimo_nome' => $request->get('ultimo_nome'),
                'path_imagem' => session()->get('user_path_imagem'),
                'numero_telemovel' => $request->get('telemovel'),
                'numero_contribuinte' => $request->get('numero_contribuinte'),
                'morada' => $request->get('morada'),
                'codigo_postal' => $codigo_postal,
                'cidade' => $request->get('cidade'),
                'pais' => $request->get('pais'),
                'google_id' => session()->get('user_google_id'),
                'tipo_de_conta' => $tipo_de_conta_novo_utilizador_id,
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
            ]);

            // notificacao de bem-vindo 
            $primeira_notificacao = Notificacao::create([
                'id_utilizador' => $newUtilizador->id,
                'mensagem' => "Bem-vindo à EcoSmart Store!",
                'estado' => 1,
            ]);

        } else {

            $filename = "images/default_user.png";

            if($request->file('path_imagem')){
                
                $allowedMimeTypes = ['image/jpeg', 'image/jpg','image/gif','image/png'];
                $contentType = $request->file('path_imagem')->getClientMimeType();

                if(!in_array($contentType, $allowedMimeTypes) ){
                    return response()->json('error: Not an image submited in the form');
                }

                $file= $request->file('path_imagem');
                $filename= uniqid().$file->getClientOriginalName();

                if (!$file-> move(public_path('images/users_images/'), $filename)) {
                    return 'Error saving the file';
                }

                $filename = 'images/users_images/' . $filename;
                
            }

            $newUtilizador = Utilizador::create([
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'primeiro_nome' => $request->get('primeiro_nome'),
                'ultimo_nome' => $request->get('ultimo_nome'),
                'path_imagem' => $filename,
                'numero_telemovel' => $request->get('telemovel'),
                'numero_contribuinte' => $request->get('numero_contribuinte'),
                'morada' => $request->get('morada'),
                'codigo_postal' => $codigo_postal,
                'cidade' => $request->get('cidade'),
                'pais' => $request->get('pais'),
                'google_id' => null,
                'tipo_de_conta' => $tipo_de_conta_novo_utilizador_id,
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
            ]);

            // notificacao de bem-vindo 
            $primeira_notificacao = Notificacao::create([
                'id_utilizador' => $newUtilizador->id,
                'mensagem' => "Bem-vindo à EcoSmart Store!",
                'estado' => 1,
            ]);
        }

        session()->put('loggedIn', 'yes');
        session()->put('userType', $accountType);
        session()->put('user_id', $newUtilizador->id);
        session()->put('user_email', $newUtilizador->email);
        session()->put('user_primeiro_nome', $newUtilizador->primeiro_nome);
        session()->put('user_ultimo_nome', $newUtilizador->ultimo_nome);
        session()->put('user_path_imagem', $newUtilizador->path_imagem);
        session()->put('user_numero_telemovel', $newUtilizador->numero_telemovel);
        session()->put('user_numero_contribuinte', $newUtilizador->numero_contribuinte);
        session()->put('user_morada', $newUtilizador->morada);
        session()->put('user_codigo_postal', $newUtilizador->codigo_postal);
        session()->put('user_cidade', $newUtilizador->cidade);
        session()->put('user_pais', $newUtilizador->pais);
        session()->put('user_latitude', $newUtilizador->latitude);
        session()->put('user_longitude', $newUtilizador->longitude);
        if ($newUtilizador->google_id != null || $newUtilizador->google_id != "NULL" || $newUtilizador->google_id != "null" || $newUtilizador->google_id != "Null") {
            session()->put('user_google_id', $newUtilizador->google_id);
        }

        $all_notificacoes = array();
        $atributos_notificacao = [
            "notificacao_id" => $primeira_notificacao->id,
            "notificacao_id_utilizador" => $primeira_notificacao->id_utilizador,
            "notificacao_mensagem" => $primeira_notificacao->mensagem,
            "notificacao_estado" => $primeira_notificacao->estado,
        ];
        array_push($all_notificacoes, $atributos_notificacao);
        session()->put('notificacoes', $all_notificacoes);


        return redirect('/');

    }



    // Update the information of a consumidor/transportadora/fornecedor
    public function update(Request $request) {
        // return $request->input();
        $request->validate([
            'email'=>'sometimes|required|string',
            'primeiro_nome'=>'sometimes|required|string',
            'ultimo_nome'=>'sometimes|required|string',
            'telemovel'=>'sometimes|required|integer',
            'numero_contribuinte'=>'sometimes|required|integer',
            'morada'=>'sometimes|required|string',
            'cidade'=>'sometimes|required|string',
            'codigo_postal_1'=>'sometimes|required|integer',
            'codigo_postal_2'=>'sometimes|required|integer',
            'pais'=>'sometimes|required|string',
            'password'=>'sometimes|required|string',
        ]);

        
        $utilizador = Utilizador::where('email', session()->get('user_email'))->first();
        $utilizador->update($request->all());
        
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
        session()->put('user_latitude', $utilizador->latitude);
        session()->put('user_longitude', $utilizador->longitude);

        return redirect('/profile');

    }


    // Delete utilizador
    public function delete()
    {
        $utilizador = Utilizador::where('email', session()->get('user_email'))->first();
        Favoritos::where('id_utilizador', session()->get('user_id'))->delete();
        Notificacao::where('id_utilizador', session()->get('user_id'))->delete();
        if($utilizador->tipo_de_conta == 5){
            Fornecedor_historico_poluicao::where('id_fornecedor', session()->get('user_id'))->delete();
        }
        if (session()->get('userType') == "consumidor") {

        } else if (session()->get('userType') == "fornecedor") {
            $produtos = Produto::where('id_fornecedor', session()->get('user_id'))->get();

            foreach($produtos as $produto){
                ProdutoCampoExtra::where('id_produto', $produto->id)->delete();
                Evento::where('id_produto', $produto->id)->delete();
            }

            foreach ($produtos as $produto) {
                if (!(str_contains($produto->path_imagem , 'http'))) {
                    if ($produto->path_imagem != "images/default_produto.jpg") {
                        unlink($produto->path_imagem); // apagar a imagem antiga
                    }
                }
            }
            Produto::where('id_fornecedor', session()->get('user_id'))->delete();

            $armazens = Armazem::where('id_fornecedor', session()->get('user_id'))->get();
            foreach ($armazens as $armazem) {
                if (!(str_contains($armazem->path_imagem , 'http'))) {
                    if ($armazem->path_imagem != "images/default_armazem.jpg") {
                        unlink($armazem->path_imagem); // apagar a imagem antiga
                    }
                }
            }
            Armazem::where('id_fornecedor', session()->get('user_id'))->get();


        } else {
            $veiculos = Veiculo::where('id_transportadora', session()->get('user_id'))->get();
            foreach ($veiculos as $veiculo) {
                if (!(str_contains($veiculo->path_imagem , 'http'))) {
                    if ($veiculo->path_imagem != "images/default_veiculo.png") {
                        unlink($veiculo->path_imagem); // apagar a imagem antiga
                    }
                }
            }
            Veiculo::where('id_transportadora', session()->get('user_id'))->delete();

            $bases = Base::where('id_transportadora', session()->get('user_id'))->get();
            foreach ($bases as $base) {
                if (!(str_contains($base->path_imagem , 'http'))) {
                    if ($base->path_imagem != "images/default_base.jpg") {
                        unlink($base->path_imagem); // apagar a imagem antiga
                    }
                }
            }
            Base::where('id_transportadora', session()->get('user_id'))->delete();

        }
        

        if (!(str_contains($utilizador->path_imagem , 'http'))) {
            if ($utilizador->path_imagem != "images/default_user.png") {
                unlink($utilizador->path_imagem); // apagar a imagem antiga
            }
        }

        $utilizador->delete();
        session()->flush();
        return redirect('/');
    }

}
