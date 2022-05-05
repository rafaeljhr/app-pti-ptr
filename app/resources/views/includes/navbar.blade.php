
<?php
Session_start();
?>

<link rel="stylesheet" href="css/page_default.css">

<header class="site-header sticky-top py-1">
    <nav class="container d-flex flex-column flex-md-row justify-content-between">  
        <a href="{{ route('home-url') }}"><img src="images/logo6.png" class="main-logo" width="140"/></a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('home-url') }}">HOME</a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('products') }}">PRODUTOS</a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('about-url') }}">SOBRE</a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('contact-url') }}">CONTACTOS</a>
        @if(Session::get('loggedIn') == 'yes')
       
            <li class="py-2 d-none d-md-inline-block">
                <div class="dropdown">
                    <a class="dropdown-toggle" id="drop" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    PERFIL
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('profile-url') }}">Conta</a></li>
                    @if(Session::get('userType') == 'fornecedor')
                    <li><a class="dropdown-item" href="#">Encomendas</a></li>
                    <li><a class="dropdown-item" href="{{ route('inventory') }}">Inventário</a></li>
                    @endif
                    @if(Session::get('userType') == 'transportadora')
                    <li><a class="dropdown-item" href="#">Encomendas</a></li>
                    <li><a class="dropdown-item" href="#">Bases de veiculos</a></li>
                    @endif
                    
                    @if(Session::get('userType') == 'consumidor')
                    <li><a class="dropdown-item" href="#">Encomendas</a></li>
                    @endif
                    </ul>
                </div>
            </li>

            
            <a class="py-2 d-none d-md-inline-block" href="{{ route('logout-controller') }}">LOGOUT</a>
          
        @endif
        @if(Session::get('loggedIn') == null)
        <a class="py-2 d-none d-md-inline-block" href="{{ route('signin-url') }}">ENTRAR</a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('register-url') }}">REGISTAR</a>
        @endif
    </nav>
</header>
       
