
<?php
Session_start();
session()->forget('loggedIn');
Session::put('loggedIn', 'yes');
Session::put('userType', 'consumidor');
Session::put('userName', 'João Carvalho');
Session::put('userEmail', 'jcarvalho@gmail.com');
Session::put('userTel', '910219301');
Session::put('userNIF', '251191699');
Session::put('userAdress', 'Av. Fernando Ricardo Ribeiro Leitão No7 6oD');
Session::put('userPassword', '1234');
echo Session::get('loggedIn'); 
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    
    <img src="images/logo6.png" class="main-logo">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="{{ route('home-url') }}">HOME</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ route('about-url') }}">SOBRE</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ route('contact-url') }}">CONTACTOS</a>
            </li>
        </ul>
    </div>


    @if(Session::get('loggedIn') == 'yes')
    <div class="collapse navbar-collapse flex-row-reverse login">
        <ul class="navbar-nav">
            <li class="nav-item">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      Perfil
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="{{ route('profile-url') }}">Conta</a></li>
                      @if(Session::get('Utilizador') == 'fornecedora')
                      <li><a class="dropdown-item" href="#">Encomendas</a></li>
                      <li><a class="dropdown-item" href="#">Inventário</a></li>
                      @endif
                      @if(Session::get('Utilizador') == 'transportadora')
                      <li><a class="dropdown-item" href="#">Encomendas</a></li>
                      <li><a class="dropdown-item" href="#">Bases de veiculos</a></li>
                      @endif
                      @if(Session::get('Utilizador') == 'consumidor')
                      <li><a class="dropdown-item" href="#">Encomendas</a></li>
                      @endif
                    </ul>
                  </div>
            </li>
            <li class="nav-item">
                {{-- <a class="nav-link" href="{{ route('logout') }}">Logout</a> --}}
                <a class="nav-link" href="#">Logout</a>
            </li>
        </ul>
    </div>

    @endif
    @if(Session::get('loggedIn') == null)
    <div class="collapse navbar-collapse flex-row-reverse login">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('signin-url') }}">ENTRAR</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register-url') }}">REGISTAR</a>
            </li>
        </ul>
    </div>
    @endif

</nav>