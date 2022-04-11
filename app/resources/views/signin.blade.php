<link rel="stylesheet" href="css/login.css">
@extends('layouts.page_default')

@section('background')
    
    @if (Session::has('failed_login'))
    <div class="alert alert-danger" role="alert">
        A sua palavra-passe ou email estão incorretos ou a sua conta nao existe
      </div>
    <?php
    session()->forget('failed_login');
    ?>
    @endif
    
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
              <h1 class="h3 mb-2 font-weight-normal">Autentique-se para usufruir  de todas as funcionalidades da EcoSmart Store!</h1>


              <select class="form-select mb-3" name ="inlineRadioOptions" aria-label="Default select example">
               
                <option selected value="consumidor">Consumidor</option>
                <option value="transportadora">Transportadora</option>
                <option value="fornecedor">Fornecedor</option>
              </select>
            

              <div class="form-floating mb-3">
                <input type="email" name="usernameLogin" id="loginEmail" class="form-control"  placeholder="Email de utilizador">
                <label for="loginEmail">Email</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" name="passwordLogin" id="password" placeholder="Palavra-passe" autofocus="">
                <label for="password" >Palavra-passe</label>
              </div>
              <div class="checkbox mb-3">
                <label>
                  <input type="checkbox" value="remember-me"> Lembrar-me
                </label>
              </div>
              <button class="w-100 btn btn-lg btn-color" type="submit">Entrar</button>
              <hr class="my-4">
              
            </form>
          </div>
        </div>
  </div>
    
@endsection