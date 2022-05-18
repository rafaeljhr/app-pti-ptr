<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>



<?php
Session_start();
//session()->flush();
//dd(session()->all());
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

                <a href="{{ route('checkout-url') }}" style="text-decoration:none; margin-right: 15px;">
                    <img class="icons_navbar" src="images/carrinho_de_compras.png">
                </a>

                <a style="text-decoration:none; margin-right: 15px;" class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="icons_navbar" src="images/notification.png">
                    <span id='numNotificacoes' class="badge badge-light"><?php echo sizeOf(session()->get('notificacoes')) ?></span>
                </a>

                <ul class="dropdown-menu" id='notificationsDiv'>

                    <h4 style="margin-left: 10px;" class="text-center">
                         <p>As suas notificações</p>
                    </h4>

                    <hr class="dropdown-divider" style="width: 90%; margin: auto;">


                    @if(Session::get('notificacoes') == [])

                        <li class='notificationElement mt-3 text-center'>
                            <p class='textoNotificacao'>Não possui notificações!</p>
                        </li>

                    @else 

                        @for($i = 0; $i < sizeOf(session()->get('notificacoes')); $i++)

                                <li class='notificationElement mt-3' id="li_<?php echo session()->get('notificacoes')[$i]['notificacao_id'] ?>">

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-10">
                                                <p class='textoNotificacao'><?php echo session()->get('notificacoes')[$i]['notificacao_mensagem'] ?></p>
                                            </div>
            
                                            <div class="col align-items-center">
                                                <a onclick="apagarNotificacao('<?php echo session()->get('notificacoes')[$i]['notificacao_id'] ?>', '{{ route('delete-notification') }}' )" class='anchorNotificacao'>
                                                    <button type="button" class="dropdown-item btn-close" id="button-close-div"  aria-label="Close"></button>
                                                </a>
                                            </div>
            
                                        </div>
                                    </div>
                                    
                                </li>
                                
                                
                                @if($i+1 < sizeOf(session()->get('notificacoes')))

                                    <hr id='hr_<?php echo session()->get('notificacoes')[$i]['notificacao_id'] ?>' class="dropdown-divider" style="width: 90%; margin: auto;">

                                @endif  

                            @endfor

                    @endif

                    

                    {{-- <li class='notificationElement mt-3'>

                        <div class="container">
                            <div class="row">
                                <div class="col-10">
                                    <p class='textoNotificacao'>Notificação de teste Notificação de teste Notificação de testeNotificação de</p>
                                </div>

                                <div class="col align-items-center">
                                    <a href="#" class='anchorNotificacao'>
                                        <button type="button" class="dropdown-item btn-close" id="button-close-div"  aria-label="Close"></button>
                                    </a>
                                </div>

                            </div>
                        </div>
                        
                    </li>

                    <hr class="dropdown-divider" style="width: 90%; margin: auto;">

                    <li class='notificationElement mt-3'>

                        <div class="container">
                            <div class="row">
                                <div class="col-10">
                                    <p class='textoNotificacao'>Notificação de teste 2</p>
                                </div>

                                <div class="col align-items-center">
                                    <a href="#" class='anchorNotificacao'>
                                        <button type="button" class="dropdown-item btn-close" id="button-close-div"  aria-label="Close"></button>
                                    </a>
                                </div>

                            </div>
                        </div>
                        
                    </li>

                    <hr class="dropdown-divider" style="width: 90%; margin: auto;"> --}}
                    
                </ul>
                    
                <a style="text-decoration:none;" class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img id="foto_navbar" src="<?php echo session()->get('user_path_imagem') ?>" referrerpolicy="no-referrer">
                </a>
                
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                    <li class="text-center"> Olá <?php echo session()->get('user_primeiro_nome') ?>!</li>

                    <li><hr class="dropdown-divider"></li>

                    <li><a class="dropdown-item text-center" href="{{ route('profile-url') }}">CONTA</a></li>

                    @if(Session::get('userType') == 'fornecedor')
                    <li><a class="dropdown-item" href="#">ENCOMENDAS</a></li>
                    <li><a class="dropdown-item" href="{{ route('inventory') }}">INVENTÁRIO</a></li>
                    <li><a class="dropdown-item"  href="{{ route('storage') }}" >ARMAZÉNS</a></li>
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
       
