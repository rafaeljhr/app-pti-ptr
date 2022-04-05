
<?php
Session_start();
/* session()->forget('loggedIn');
Session::put('loggedIn', 'yes');

Session::put('userName', 'João Carvalho');
Session::put('userEmail', 'jcarvalho@gmail.com');
Session::put('userTel', '910219301');
Session::put('userNIF', '251191699');
Session::put('userAdress', 'Av. Fernando Ricardo Ribeiro Leitão No7 6oD');
Session::put('userPassword', '1234');
echo Session::get('loggedIn');   
session()->forget('loggedIn');  */
/* Session::put('loggedIn', 'yes'); 
Session::put('Utilizador', 'fornecedora'); */
/* echo Session::get('loggedIn');  */
?>

<link rel="stylesheet" href="css/page_default.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

<header class="site-header sticky-top py-1">
    <nav class="container d-flex flex-column flex-md-row justify-content-between">  
        <img src="images/logo6.png" class="main-logo" width="140">
        <a class="py-2 d-none d-md-inline-block" href="{{ route('home-url') }}">HOME</a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('about-url') }}">SOBRE</a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('contact-url') }}">CONTACTOS</a>
        @if(Session::get('loggedIn') == 'yes')
       
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
                <a class="nav-link" href="{{ route('logout-controller') }}">Logout</a>
            </li>
        

        @endif
        @if(Session::get('loggedIn') == null)
        <a class="py-2 d-none d-md-inline-block" href="{{ route('signin-url') }}">ENTRAR</a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('register-url') }}">REGISTAR</a>
        @endif
    </nav>
</header>
       
