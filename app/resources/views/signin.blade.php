<?php

// dd(session()->all());
// session()->forget('user_google_id');

Session::put('login_ou_registo', "login");
?>

<link rel="stylesheet" href="css/login.css">
@extends('layouts.page_default')

@section('background')
      
  <link rel="stylesheet" href="css/login.css">

  <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div id="borderDiv" class="row align-items-center g-lg-5 mt-2 py-2">
          <div class="col-lg-7 text-center text-lg-start">
            <img src="images/logo5.png" width="600" alt="">

            
            <p class="col-lg-10 fs-4">A EcoSmart Store permite-te comprar aquilo que tu quiseres, 
              considerando todos os custos associados.
            </p>
            

          </div>
          <div class="col-md-10 mx-auto col-lg-5" >
            <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="{{ route('login-controller') }}">
              @csrf

              @if(session()->get('user_google_id')==null) 
                <h1 class="h3 mb-2 font-weight-normal">Autentique-se para usufruir  de todas as funcionalidades da EcoSmart Store!</h1>
              @else
                <h1 class="col-lg-10 fs-4">Olá de volta <?php echo session()->get('user_nome')?>!</h1>
              @endif

              <br>

              <label for="inlineRadioOptions" class="form-label">Tipo de conta a autenticar</label>
              <select class="form-select mb-3" name ="inlineRadioOptions" aria-label="Default select example">
                <option selected value="consumidor">Consumidor</option>
                <option value="transportadora">Transportadora</option>
                <option value="fornecedor">Fornecedor</option>
              </select>

              <hr class="my-4">
            
              @if(session()->get('user_google_id')==null) 
                <div class="form-floating mb-3">
                  <input v-model="email" @input="validateForm()" type="email" name="usernameLogin" id="loginEmail" class="form-control"  placeholder="Email de utilizador">
                  <label for="loginEmail">Email</label>
                </div>

                <div class="form-floating mb-3">
                  <input v-model="password" @input="validateForm()" type="password" class="form-control" name="passwordLogin" id="password" placeholder="Palavra-passe" autofocus="">
                  <label for="password">Palavra-passe</label>
                </div>
              @else
                <div class="form-floating mb-3">
                  <input v-model="password" @input="validatePass()" type="password" class="form-control" name="passwordLogin" id="password" placeholder="Palavra-passe" autofocus="">
                  <label for="password">Palavra-passe</label>
                </div>
              @endif

              <div class="checkbox mb-3">
                <label>
                  <input type="checkbox" value="remember-me"> Lembrar-me
                </label>
              </div>

              @if (Session::has('failed_login'))
                <div class="alert alert-danger" role="alert">
                  <p>A sua palavra-passe está incorreta ou a sua conta nao existe. Por favor <a href="#">altere a usa palavra-passe</a> ou <a href="{{ route('register-url')}}">crie uma conta nova.</a></p>
                </div>
                <?php
                session()->forget('failed_login');
                ?>
              @endif

              <button :disabled="!validForm" class="w-100 btn btn-lg btn-color mt-4" type="submit">Entrar</button>

              @if(session()->get('user_google_id')==null) 
                <hr class="my-4">

                <div class="text-center">
                  <a href="{{ route('auth/google') }}">
                    <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                  </a>
                </div>
              @endif
              
              
            </form>
          </div>
        </div>
  </div>
  
  <script src="./js/signin.js"></script>

@endsection