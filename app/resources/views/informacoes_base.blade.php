<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php

    $userMorada = session()->get('base')['base_morada'];

    $userCodPostal = session()->get('base')['base_codigo_postal'];
    $userCodPostal = explode("-", $userCodPostal);
    $userCodPostal_1 = $userCodPostal[0];
    $userCodPostal_2 = $userCodPostal[1];

    $userCidade = session()->get('base')['base_cidade'];
    $userPais = session()->get('base')['base_pais'];

    // dd(session()->all());

    ?>

    <link rel="stylesheet" href="css/bases_veiculos.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <div class="container py-5">

        <!-- Modal Apagar Base -->
        <div class="modal fade" id="modalApagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalApagarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem a certeza que deseja apagar a sua base?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="post" action="{{ route('base-delete-controller') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </form>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal Mudar Avatar -->
        <div class="modal fade" id="modalMudarAvatar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalMudarPassLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMudarPassLabel">Alterar Imagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div ref="tab_imagem" class="tab" id='tab_da_imagem'>
                    <div class="form-outline mb-4 text-center">
                        <br>
                        <h3 id="titulo_imagem" class="mb-3">Imagem Atual</h3>
                        <img src="<?php echo session()->get('base')['base_path_imagem'] ?>" id="imagem_a_alterar" class="mx-auto" alt="">
                    </div>
                </div>

                <form id="changeAvatar" method="post" action="{{ route('update-imagem-base-controller') }}" enctype="multipart/form-data">
                    @csrf
                    <input onchange="alterarImagem(event)" ref="redUploadImagem" type="file" name="mudar_path_imagem" class="w-50 adicionar-foto d-grid mx-auto">
                </form>

                <div id="submitChangeAvatar" class="modal-footer" style="display: none">
                    <button type="submit" form="changeAvatar" class="btn btn-danger">Confirmar</button>
                    
                </div>

            </div>
            </div>
        </div>

        <div class="form-div mx-auto my-1 px-3">

            <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">INFORMAÇÕES DA BASE</h1>

            <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('base')['base_path_imagem'] ?>" referrerpolicy="no-referrer">
            <div class="mt-2 w-25 mx-auto">
                <button type="button" class="btn form-control alterar_imagem_botao" data-bs-toggle="modal" data-bs-target="#modalMudarAvatar">ALTERAR IMAGEM</button>
            </div>

            <br>

            <div class="px-4">
                <form method="post" action="{{ route('base-edit-controller') }}">
                    @csrf

                    <div class="row">

                        <div class="col">
                            <label class="mb-2" for="nome">Nome</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="nome" type="text" name="nome" class="form-control mb-3" value="<?php echo session()->get('base')['base_nome'] ?>" :disabled="!editable">
                                <i v-show="nome_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um nome"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <label class="mb-2" for="morada">Morada</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="morada" type="text" name="morada" class="form-control mb-3" value="<?=$userMorada?>" :disabled="!editable">
                                <i v-show="morada_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir uma morada"></i>
                            </div>
                        </div>

                        <div class="col">
                            <label class="mb-2">Código Postal</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="codigo_postal_1" type="text" name="codigo_postal_1" class="form-control w-50" style="display: inline-block;" value="<?=$userCodPostal_1?>" maxlength="4" :disabled="!editable" placeholder="xxxx">
                                <input @input="checkForm()" ref="codigo_postal_2" type="text" name="codigo_postal_2" class="form-control w-50" style="display: inline-block;" value="<?=$userCodPostal_2?>" maxlength="3" :disabled="!editable" placeholder="xxx">
                                <i v-show="codigo_postal_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Código postal inválido"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <label for="cidade" class="mb-2">Cidade</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="cidade" type="text" name="cidade" class="form-control" value="<?=$userCidade?>" :disabled="!editable">
                                <i v-show="cidade_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir uma cidade"></i>
                            </div>
                        </div>

                        <div class="col">
                            <label for="pais" class="mb-2">País</label>
                            <select class="form-control" ref="pais" name="pais" :disabled="!editable">
                                <option selected>Portugal</option>
                            </select>
                        </div>

                    </div>

                    <br><br>

                    <div class="position-relative my-1">
                        <button v-show="!editable" type="button" class="btn btn-long btn-success" @click="editable = true">EDITAR BASE</button>
                        <button v-show="editable" type="submit" class="btn btn-long btn-warning me-3" id="guardar_alteracoes" disabled>GUARDAR ALTERAÇÕES</button>
                        <button v-show="editable" type="button" class="btn btn-long btn-primary" @click="cancelChanges()">CANCELAR ALTERAÇÕES</button>
                        <button type="button" class="btn btn-danger position-absolute end-0" data-bs-toggle="modal" data-bs-target="#modalApagar">APAGAR BASE</button>
                    </div>

                </form>
            </div>
        </div>    
    </div>

    @include('includes.footer')

    <script src="./js/informacoes_base.js"></script>
        
@endsection