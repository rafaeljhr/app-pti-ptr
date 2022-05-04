<!DOCTYPE html>

{{-- Verifica se fez login para poder acessar esta página --}}

@if (!(session()->has('user_email')) or !(session()->has('tipo_conta')))
    @php
        header("Location: " . URL::to('/login'), true, 302);
        exit();
    @endphp
@endif

<html>
    <head>
        <meta charset="utf-8">

        <title>Web API</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <style type="text/css">
            .box{
                width: 600px;
                margin: 0 auto;
                border: 1px solid #ccc
            }
        </style>

    </head>
    <body>
        <br />
        <div class="container box">
            
            <div class="alert alert-danger success-block">
                <strong> Bem-vindo {{ session()->get('user_nome') }}</strong>
                <br />
                <a href="{{ url('/logout') }}">Logout </a>
            </div>

            <form method = "post" action="{{ url('GetToken') }}">

                {{ csrf_field() }}

                <div class="form-group">
                    <label>Token Acess</label>
                    <input name="token" class="form-control" value="{{ session()->get('token') }}"readonly/>
                </div>

                <br />

                <div class="form-group">
                    <input type="submit" name="GetToken" class="btn btn-primary" value="GetTokenAccess" />
                </div>
            </form>
        </div>  
    </body>

    {{-- Apaga o token gerado da sessão --}}
    @php
        Session::forget('token');
    @endphp
</html>