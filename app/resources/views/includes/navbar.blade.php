
<?php
Session_start();
?>

<link rel="stylesheet" href="css/page_default.css">
<script src="./js/page_default.js"></script>

<header class="site-header sticky-top py-2">
    
    {{-- <a href="{{ route('home-url') }}"><img class="navbar_image" src="images/logo6.png"/></a> --}}

    <nav id="navbarPrincipal" class="container d-flex flex-column flex-md-row justify-content-between">  
        {{-- <a href="{{ route('home-url') }}"><img src="images/logo6.png" class="main-logo" width="140"/></a> --}}
        <a class="py-2 d-none d-md-inline-block" href="{{ route('home-url') }}">HOME</a>
        <a class="py-2 d-none d-md-inline-block" href="{{ route('products') }}">LOJA</a>

        @if(Session::get('loggedIn') != null)
            <a href="{{ route('home-url') }}"><img class="navbar_image" src="images/imagem_tab.png"/></a>
        @endif

        <a class="py-2 d-none d-md-inline-block" href="{{ route('about-url') }}">SOBRE</a>

        @if(Session::get('loggedIn') == null)
            <a href="{{ route('home-url') }}"><img class="navbar_image" src="images/imagem_tab.png"/></a>
        @endif

        <a class="py-2 d-none d-md-inline-block" href="{{ route('contact-url') }}">CONTACTOS</a>

        @if(Session::get('loggedIn') == null)
            <a class="py-2 d-none d-md-inline-block" href="{{ route('signin-url') }}">ENTRAR</a>
            <a class="py-2 d-none d-md-inline-block" href="{{ route('register-url') }}">REGISTAR</a>
        @endif


        @if(Session::get('loggedIn') == 'yes')
       
            <div class="dropdown" id="menu_perfil_utilizador">
                    
                <a style="text-decoration:none;" class="dropdown-toggle" id="drop" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img id="foto_navbar" src="<?php echo session()->get('user_path_imagem') ?>" referrerpolicy="no-referrer">
                </a>
                
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                    <li class="text-center"> Olá <?php echo session()->get('user_primeiro_nome') ?>!</li>

                    <li><hr class="dropdown-divider"></li>

                    <li><a class="dropdown-item text-center" href="{{ route('profile-url') }}">CONTA</a></li>

                    @if(Session::get('userType') == 'fornecedor')
                    <li><a class="dropdown-item" href="#">Encomendas</a></li>
                    <li><a class="dropdown-item" href="{{ route('inventory') }}">Inventário</a></li>
                    <li><a class="dropdown-item" {{-- href="{{ route('storage') }}" --}}>Armazéns</a></li>
                    @endif
                    @if(Session::get('userType') == 'transportadora')
                    <li><a class="dropdown-item text-center" href="#">ENCOMENDAS</a></li>
                    <li><a class="dropdown-item text-center" href="#">BASES</a></li>
                    <li><a class="dropdown-item text-center" href="#">VEÍCULOS</a></li>
                    @endif
                    @if(Session::get('userType') == 'consumidor')
                    <li><a class="dropdown-item text-center" href="#">ENCOMENDAS</a></li>
                    @endif

                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center" href="{{ route('logout-controller') }}">LOGOUT</a></li>
                </ul>
            </div>
            
        @endif

    </nav>

</header>
       
