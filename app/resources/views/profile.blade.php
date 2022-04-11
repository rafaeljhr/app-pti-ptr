<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php

    $userName = Session::get('user_nome');
    $userEmail = Session::get('user_email');
    $userTel = Session::get('user_telemovel');
    $userNIF = Session::get('user_nif');
    $userAdress = Session::get('user_morada');

    if (Session::get('userType') == 'consumidor') {
        $clientConsumer = true;
    } else {
        $clientConsumer = false;
    }

    // dd(session()->all());

    ?>

    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <div class="container py-5">

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Atenção!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem a certeza que deseja apagar a sua conta?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="post" action="{{ route('delete-profile-controller') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </form>
                </div>
            </div>
            </div>
        </div>
    
        <div class="form-div mx-auto my-2 px-3">  
            <img class="logo" src="images/logo6.png" alt="EcoSmart Logo">

            <h1 class="h3 mb-4 font-weight-normal">Os Meus Dados</h1>

            <div class="px-4 py-4">
                <form method="post" action="{{ route('edit-profile-controller') }}">
                    @csrf
                    <div class="prof-info">
                        <div class="row" >                    
                            <div class="col-sm ">
                                <label for="nome" class="form-label text-light">Nome</label>
                                <input type="text" name="nome" class="form-control mb-3" placeholder="Introduza o seu nome" aria-label="Nome do Utilizador"
                                aria-describedby="Nome do Utilizador" ref="userName" value="<?=$userName?>" :disabled="!editable">
                            </div>
        
                            <div class="col-sm">
                                <label for="email" class="form-label text-light">Email</label>
                                <div class="input-group mb-3">
                                    <input name="email" type="email" class="form-control" placeholder="Introduza o seu email" aria-label="Email do Utilizador"
                                        aria-describedby="Email do Utilizador" ref="userEmail" value="<?=$userEmail?>" :disabled="!editable">
                                </div>
                            </div>
        
                            <div class="col-sm">
                                <label for="telefone" class="form-label text-light">Telemóvel</label>
                                <div class="input-group mb-3">
                                    <input name="telefone" type="text" class="form-control" placeholder="Introduza o seu número" aria-label="Telemóvel do Utilizador"
                                        aria-describedby="Telemóvel do Utilizador" minlength="9" maxlength="9" ref="userTel" value="<?=$userTel?>" :disabled="!editable">
                                </div>
                            </div>
                        </div>
        
                        <div class="row">              
                            <div class="col-sm">
                                @if ($clientConsumer) 
                                    <label for="nif" class="sr-only text-light">NIF</label>
                                @else
                                    <label for="nif" class="sr-only text-light">NIF da Empresa</label>
                                @endif
                                
                                <input type="text" name="nif" class="form-control mb-3" placeholder="Introduza o seu NIF" aria-label="NIF do Utilizador"
                                aria-describedby="NIF do Utilizador" minlength="9" maxlength="9" ref="userNIF" value="<?=$userNIF?>" :disabled="!editable">
                            </div>
        
                            <div class="col-sm">
                                @if ($clientConsumer)
                                    <label for="morada" class="sr-only text-light">Morada</label>
                                @else
                                    <label for="morada" class="sr-only text-light">Morada Fiscal</label>
                                @endif
                                
                                <input type="text" name="morada" class="form-control mb-3" placeholder="Introduza a sua morada" aria-label="Morada do Utilizador"
                                aria-describedby="Morada do Utilizador" ref="userAdress" value="<?=$userAdress?>" :disabled="!editable">
                            </div>
        
                            {{-- <div v-show="editable" class="col-sm">
                                <label for="password" class="form-label text-light">Mudar Password</label>
                                <div class="input-group mb-3">
                                    <input name="password" type="password" class="form-control" placeholder="Introduza a sua nova password" aria-label="Password do Utilizador"
                                        aria-describedby="Password do Utilizador" :disabled="!editable"> 
                                </div>
                            </div> --}}
                        </div>

                        <div class="my-2">
                            <button v-show="!editable" type="button" class="btn btn-primary" @click="editable = true">Editar Dados</button>
                            <button v-show="editable" type="submit" class="btn btn-primary me-3">Guardar Alterações</button>
                            <button v-show="editable" type="button" class="btn btn-secondary" @click="cancelChanges()">Cancelar Alterações</button>
                        </div>
                    </div>
                </form>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Apagar Conta</button>
            </div>
        </div>    
    </div>

    @include('includes.footer')

    <script src="./js/profile.js"></script>
        
@endsection