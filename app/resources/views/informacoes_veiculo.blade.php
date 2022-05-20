<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php

    // dd(session()->all());

    ?>

    <link rel="stylesheet" href="css/bases_veiculos.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <div class="container py-5">

        <!-- Modal Apagar Veículo -->
        <div class="modal fade" id="modalApagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalApagarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem a certeza que deseja apagar o seu veículo?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="post" action="{{ route('veiculo-delete-controller') }}">
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
                        <img src="<?php echo session()->get('veiculo')['veiculo_path_imagem'] ?>" id="imagem_a_alterar" class="mx-auto" alt="">
                    </div>
                </div>

                <form id="changeAvatar" method="post" action="{{ route('update-imagem-veiculo-controller') }}" enctype="multipart/form-data">
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

            <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">INFORMAÇÕES DO VEÍCULO</h1>

            <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('veiculo')['veiculo_path_imagem'] ?>" referrerpolicy="no-referrer">
            <div class="mt-2 w-25 mx-auto">
                <button type="button" class="btn form-control alterar_imagem_botao" data-bs-toggle="modal" data-bs-target="#modalMudarAvatar">ALTERAR IMAGEM</button>
            </div>

            <br>

            <div class="px-4">
                <form method="post" action="{{ route('veiculo-edit-controller') }}">
                    @csrf

                    <div class="row">

                        <div class="col">
                            <label class="mb-2" for="nome">Nome</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="nome" type="text" name="nome" class="form-control mb-3" value="<?php echo session()->get('veiculo')['veiculo_nome'] ?>" :disabled="!editable">
                                <i v-show="nome_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um nome"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <label for="tipo_combustivel" class="form-label">Combustível</label>
                            <select @change="checkForm()" ref="tipo_combustivel" class="form-control" name="tipoCombustivel" :disabled="!editable">
                                <?php 
                                    echo '<option value="' . session()->get('veiculo')['veiculo_tipoCombustivel'] . '">'. session()->get('veiculo')['veiculo_tipoCombustivel'] .'</option>';

                                    foreach (session()->get('tipos_combustivel') as $tipo) {

                                        if ($tipo['tipos_combustivel_nome'] != session()->get('veiculo')['veiculo_tipoCombustivel']) {
                                            echo '<option value="' . $tipo['tipos_combustivel_nome'] . '">'. $tipo['tipos_combustivel_nome'] .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col">
                            <label class="mb-2" for="consumo_por_100km">Consumo por 100Km</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="consumo_por_100km" type="text" name="consumo_por_100km" class="form-control mb-3" value="<?php echo session()->get('veiculo')['veiculo_consumo_por_100km'] ?>" :disabled="!editable">
                                <i v-show="consumo_por_100km_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um consumo válido!"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <label for="base" class="form-label">Base</label>
                            <select @change="checkForm()" ref="base" class="form-control" name="id_base" :disabled="!editable">
                                <?php 
                                    foreach (session()->get('bases') as $base) {

                                        if ($base['base_id'] == session()->get('veiculo')['veiculo_id_base']) {
                                            $base_id = $base['base_id'];
                                            $base_nome = $base['base_nome'];
                                            break;
                                        }
                                    }

                                    echo '<option value="' . $base_id . '">'. $base_nome .'</option>';

                                    foreach (session()->get('bases') as $base) {
                                        if ($base['base_id'] != session()->get('veiculo')['veiculo_id_base']) {
                                            echo '<option value="' . $base['base_id'] . '">'. $base['base_nome'] .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col">
                            <label for="quantidade" class="mb-2">Nº de veículos</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="quantidade" type="text" name="quantidade" class="form-control mb-3" value="<?php echo session()->get('veiculo')['veiculo_quantidade'] ?>" :disabled="!editable">
                                <i v-show="quantidade_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um quantidade de veículos válida!"></i>
                            </div>
                        </div>

                    </div>

                    <div id='baseDoVeiculo' class="text-center">

                        <h3 class="mt-3 mb-2 text-center">Base do veículo</h3>

                        <div class="card solo_veiculo mx-auto">
                            <img class="card-img-top imagem_da_card" src='<?php echo session()->get('veiculo_base')['base_path_imagem'] ?>'>
        
                            <h4 class="card-title mt-3 text-center"><?php echo session()->get('veiculo_base')['base_nome'] ?></h4>
        
                            <div class="card-body text-center">
                            <div class="row">
                                <div class="col">
                                <p>
                                    <?php
            
                                    $num_veiculos = 0;
                                    foreach (session()->get('veiculos') as $veiculo) {
            
                                        if ($veiculo['veiculo_id_base'] == session()->get('veiculo_base')['base_id']) {
                                        $num_veiculos += $veiculo['veiculo_quantidade'];
                                        }
            
                                    }
            
                                    echo 'Nº de veículos na base: ' . $num_veiculos;
            
                                    ?>
                                </p>
                                </div>
                            </div>
                            
                            <a href="{{ URL::to('base/'.session()->get('veiculo_base')['base_id']) }}">
                                <button type="button" class="btn btn-info botoes_veiculos">Detalhes da base</button>
                            </a>
                            </div>
            
                        </div>
                    </div>

                    <br><br>

                    <div class="position-relative my-1">
                        <button v-show="!editable" type="button" class="btn btn-long btn-success" @click="editable = true">EDITAR VEÍCULO</button>
                        <button v-show="editable" type="submit" class="btn btn-long btn-warning me-3" id="guardar_alteracoes" disabled>GUARDAR ALTERAÇÕES</button>
                        <button v-show="editable" type="button" class="btn btn-long btn-primary" @click="cancelChanges()">CANCELAR ALTERAÇÕES</button>
                        <button type="button" class="btn btn-danger position-absolute end-0" data-bs-toggle="modal" data-bs-target="#modalApagar">APAGAR VEÍCULO</button>
                    </div>

                </form>
            </div>
        </div>    
    </div>

    @include('includes.footer')

    <script src="./js/informacoes_veiculo.js"></script>
        
@endsection