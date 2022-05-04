<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php

    $userName = Session::get('user_nome');
    $userEmail = Session::get('user_email');
    $userTel = Session::get('user_telefone');
    $userNIF = Session::get('user_nif');
    $userAdress = Session::get('user_morada');
    $userImage = Session::get('path_imagem');

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

        <!-- Modal Apagar Conta -->
        <div class="modal fade" id="modalApagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalApagarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
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

        <!-- Modal Mudar Password -->
        <div class="modal fade" id="modalMudarPass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalMudarPassLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMudarPassLabel">Alterar Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePass" method="post" action="{{ route('update-password-controller') }}">
                        @csrf
                        <label for="oldPass" class="form-label">Password Atual:</label>
                        <input type="password" name="oldPass" class="form-control mb-3" placeholder="Introduza a sua password atual" aria-label="Password Atual"
                        aria-describedby="Nome do Utilizador">

                        <label for="newPass1" class="form-label">Nova Password:</label>
                        <input type="password" name="newPass1" class="form-control mb-3" placeholder="Introduza a sua nova password" aria-label="Nova Password"
                        aria-describedby="Nova Password">

                        <label for="newPass2" class="form-label">Confirme Nova Password:</label>
                        <input type="password" name="newPass2" class="form-control mb-3" placeholder="Confirme a sua nova password" aria-label="Confirmar Nova Password"
                        aria-describedby="Confrimar Nova Password">
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="changePass" class="btn btn-danger">Confirmar</button>
                </div>
            </div>
            </div>
        </div>
    
        <div v-show="!telephone_valid" class="alert alert-danger" role="alert">
            Telemóvel tem de ser um número!
        </div>

        <div v-show="!nif_valid" class="alert alert-danger" role="alert">
            NIF tem de ser um número!
        </div>

        <div class="form-div mx-auto my-2 px-3">  
            <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" width="300" style="border-radius: 50%;" src="<?=$userImage?>" alt="EcoSmart Logo">

            <h1 class="h3 mb-4 mx-auto d-flex justify-content-center font-weight-normal">Os Meus Dados</h1>

            <div class="px-4">
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
                                    <input @input="checkForm()" name="telefone" type="text" class="form-control" placeholder="Introduza o seu número" aria-label="Telemóvel do Utilizador"
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
                                <input @input="checkForm()" type="text" name="nif" class="form-control mb-3" placeholder="Introduza o seu NIF" aria-label="NIF do Utilizador"
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

                            <div class="col-sm">
                                <label for="foto" class="sr-only text-light">Foto de perfil</label>
                                <input type="file" id='path_imagem' name="path_imagem" class="adicionar-foto d-grid mx-auto">
                            </div>
        
                            <div class="col-sm mt-4">
                                <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#modalMudarPass">Mudar Password</button>
                            </div>
                        </div>

                        <div class="position-relative my-2">
                            <button v-show="!editable" type="button" class="btn btn-primary btn-color" @click="editable = true">Editar Dados</button>
                            <button v-show="editable" type="submit" class="btn btn-primary me-3">Guardar Alterações</button>
                            <button v-show="editable" type="button" class="btn btn-secondary" @click="cancelChanges()">Cancelar Alterações</button>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger position-absolute end-0" data-bs-toggle="modal" data-bs-target="#modalApagar">Apagar Conta</button>
                        </div>

                        
                    </div>
                </form>
            </div>
        </div>    
    </div>

    @include('includes.footer')

    <script src="./js/profile.js"></script>
        
@endsection