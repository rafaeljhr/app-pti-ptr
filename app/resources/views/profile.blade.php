<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php

    $userEmail = Session::get('user_email');
    $userPrimeiroNome = Session::get('user_primeiro_nome');
    $userUltimoNome = Session::get('user_ultimo_nome');
    $userImage = Session::get('user_path_imagem');
    $userTel = Session::get('user_numero_telemovel');
    $userNumContribuinte = Session::get('user_numero_contribuinte');
    $userMorada = Session::get('user_morada');

    $userCodPostal = Session::get('user_codigo_postal');
    $userCodPostal = explode("-", $userCodPostal);

    $userCodPostal_1 = $userCodPostal[0];
    $userCodPostal_2 = $userCodPostal[1];

    $userCidade = Session::get('user_cidade');
    $userPais = Session::get('user_pais');
    

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

        <!-- Modal Mudar Avatar -->
        <div class="modal fade" id="modalMudarAvatar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalMudarPassLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMudarPassLabel">Alterar Avatar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div ref="tab_imagem" class="tab" id='tab_da_imagem'>
                    <div class="form-outline mb-4 text-center">
                        <br>
                        <h3 id="titulo_image_do_utilizador">Avatar Atual</h3>
                        <img src="<?php echo session()->get('user_path_imagem') ?>" id="image_do_utilizador" width="200" class="d-grid mx-auto" alt="">
                    </div>
                </div>


                <div class="modal-body">
                    <form id="changeAvatar" method="post" action="{{ route('update-avatar-controller') }}" enctype="multipart/form-data">
                        @csrf
                        <input onchange="alterarImagemUser(event)" ref="redUploadImagem" type="file" id='path_imagem' name="mudar_path_imagem" class="w-50 adicionar-foto d-grid mx-auto">
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="changeAvatar" id="submitChangeAvatar" class="btn btn-danger" style="display: none">Confirmar</button>
                </div>
            </div>
            </div>
        </div>

        <div class="form-div mx-auto my-2 px-3">

            <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('user_path_imagem') ?>" referrerpolicy="no-referrer">

            <h1 class="h3 mb-4 mx-auto d-flex justify-content-center font-weight-normal">O MEU PERFIL</h1>

            <div class="px-4">
                <form method="post" action="{{ route('edit-profile-controller') }}">
                    @csrf
                    <div class="row">                    
                        <div class="col">
                            <label for="primeiro_nome" class="form-label text-dark">Primeiro nome</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="userPrimeiroNome" type="text" name="primeiro_nome" class="form-control mb-3" value="<?=$userPrimeiroNome?>" :disabled="!editable">
                                <i v-show="pnome_valid === false && editable === true" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Primeiro nome não pode ficar vazio"></i>
                                <i v-show="pnome_valid === true && editable === true" class="bi bi-check check-icon"></i>
                            </div>
                        </div>

                        <div class="col">
                            <label for="ultimo_nome" class="form-label text-dark">Último nome</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="userUltimoNome" type="text" name="ultimo_nome" class="form-control mb-3" value="<?=$userUltimoNome?>" :disabled="!editable">
                                <i v-show="unome_valid === false && editable === true" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Último nome não pode ficar vazio"></i>
                                <i v-show="unome_valid === true && editable === true" class="bi bi-check check-icon"></i>
                            </div>
                            
                        </div>
    
                        <div class="col">
                            <label for="email" class="form-label text-dark">Email</label>
                            <div class="input-group mb-3 inline-icon">
                                <input ref="userEmail" name="email" type="email" class="form-control" value="<?=$userEmail?>" disabled>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <label for="telemovel" class="form-label text-dark">Telemóvel</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="userTel" name="telemovel" type="text" class="form-control" minlength="9" maxlength="9" value="<?=$userTel?>" :disabled="!editable">
                                <i v-show="telephone_valid === false && editable === true" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Telemóvel tem de ser um número e não pode ficar vazio"></i>
                                <i v-show="telephone_valid === true && editable === true" class="bi bi-check check-icon"></i>
                            </div>
                            
                        </div>

                        <div class="col">
                            @if ($clientConsumer) 
                                <label for="numero_contribuinte" class="form-label text-dark">Número de Contribuinte</label>
                            @else
                                <label for="numero_contribuinte" class="form-label text-dark">Número de Contribuinte da Empresa</label>
                            @endif
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="userNumContribuinte" type="text" name="numero_contribuinte" class="form-control" minlength="9" maxlength="9" value="<?=$userNumContribuinte?>" :disabled="!editable">
                                <i v-show="nif_valid === false && editable === true" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="NIF não pode ficar vazio e tem de ter 9 digitos"></i>
                                <i v-show="nif_valid === true && editable === true" class="bi bi-check check-icon"></i>
                            </div>
                        </div>

                        <div class="col">
                            <label for="pais" class="sr-only text-dark">País</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="userPais" type="text" name="pais" class="form-control mb-3" value="<?=$userPais?>" :disabled="!editable">
                                <i v-show="pais_valid === false && editable === true" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Pais não pode ficar vazio"></i>
                                <i v-show="pais_valid === true && editable === true" class="bi bi-check check-icon"></i>
                            </div>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            @if ($clientConsumer)
                                <label for="morada" class="sr-only text-dark">Morada</label>
                            @else
                                <label for="morada" class="sr-only text-dark">Morada Fiscal</label>
                            @endif
                            
                            <input ref="userMorada" type="text" name="morada" class="form-control mb-3" value="<?=$userMorada?>" :disabled="!editable">
                        </div>

                        <div class="col">
                            <label class="text-dark" style="display: table-cell;">Código Postal</label>
                            <div class="inline-icon">
                                <input ref="userCodPostal_1" type="text" name="codigo_postal_1" class="form-control w-50" style="display: inline-block;" value="<?=$userCodPostal_1?>" maxlength="4" :disabled="!editable" placeholder="xxxx">
                                <input ref="userCodPostal_2" type="text" name="codigo_postal_2" class="form-control w-50" style="display: inline-block;" value="<?=$userCodPostal_2?>" maxlength="3" :disabled="!editable" placeholder="xxx">
                                <i v-show="codigo_postal_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Código postal inválido"></i>
                            </div>
                        </div>

                        <div class="col">
                            <label for="cidade" class="sr-only text-dark">Cidade</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="userCidade" type="text" name="cidade" class="form-control mb-3" value="<?=$userCidade?>" :disabled="!editable">
                                <i v-show="cidade_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir uma cidade"></i>
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-dark form-control" data-bs-toggle="modal" data-bs-target="#modalMudarAvatar">Alterar Fotografia</button>
                        </div>
    
                        <div class="col-sm">
                            <button type="button" class="btn btn-dark form-control" data-bs-toggle="modal" data-bs-target="#modalMudarPass">Mudar Password</button>
                        </div>
                    </div>


                    <br><br>


                    <div class="position-relative my-2">
                        <button v-show="!editable" type="button" class="btn btn-primary btn-color" @click="editable = true">Editar Dados</button>
                        <button v-show="editable" type="submit" class="btn btn-warning me-3">Guardar Alterações</button>
                        <button v-show="editable" type="button" class="btn btn-primary" @click="cancelChanges()">Cancelar Alterações</button>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger position-absolute end-0" data-bs-toggle="modal" data-bs-target="#modalApagar">Apagar Conta</button>
                    </div>

                </form>
            </div>
        </div>    
    </div>

    @include('includes.footer')

    <script src="./js/profile.js"></script>
        
@endsection