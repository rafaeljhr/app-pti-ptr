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

            
            @if(!file_exists(session()->get('base')['base_path_imagem']))
                <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="images/default_base.jpg" referrerpolicy="no-referrer">
            @else
                <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('base')['base_path_imagem'] ?>" referrerpolicy="no-referrer">
            @endif

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
                        <div class="col">
                            <label class="mb-2" for="preco">Preço cobrado por entrega</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="preco" type="number" name="preco" class="form-control mb-3" value="<?php echo session()->get('base')['base_preco'] ?>" :disabled="!editable">
                                <i v-show="preco_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um preço"></i>
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

                    <br>

                    @if(Session::get('base_veiculos') != [])
                    <div id='todasVeiculos'>

                        <h3 class="mt-3 mb-5 text-center">Veículos associados à base</h3>

                        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
                          
                            @for($i = 0; $i < sizeOf(session()->get('base_veiculos')); $i++)
                              <div class="col">
                                <div class="card">

                                    @if(!file_exists(session()->get('base_veiculos')[$i]['veiculo_path_imagem']))
                                        <img class="card-img-top imagem_da_card" src='images/default_veiculo.png'>
                                    @else
                                        <img class="card-img-top imagem_da_card" src='<?php echo session()->get('base_veiculos')[$i]['veiculo_path_imagem'] ?>'>
                                    @endif
                                  
                  
                                  <h4 class="card-title mt-3 text-center"><?php echo session()->get('base_veiculos')[$i]['veiculo_nome'] ?></h4>
                  
                                  <div class="card-body text-center">
                                    <div class="row">
                                      <p class="ml-2"> Nº de veículos: <?php echo session()->get('base_veiculos')[$i]['veiculo_quantidade'] ?></p>
                                    </div>
                  
                                    <div class="row">
                                      <p> Combustível: <?php echo session()->get('base_veiculos')[$i]['veiculo_tipoCombustivel'] ?></p>
                                    </div>
                  
                                    <div class="row">
                                      <p>
                                        <?php 
                                        if (session()->get('base_veiculos')[$i]['veiculo_tipoCombustivel'] == "Eletricidade") {
                                          echo session()->get('base_veiculos')[$i]['veiculo_consumo_por_100km']." kWh/100km";
                                        } else {
                                          echo session()->get('base_veiculos')[$i]['veiculo_consumo_por_100km']." L/100km";
                                        }
                                        ?>
                                      </p>
                                    </div>
                  
                                    <div class="row">
                                      <p>
                                        <?php 
                                        foreach (session()->get('tipos_combustivel') as $tipo) {
                  
                                          if ($tipo['tipos_combustivel_nome'] == session()->get('base_veiculos')[$i]['veiculo_tipoCombustivel']) {
                                            $tipo_combustivel_co2_por_km = $tipo['tipos_combustivel_co2_por_km'];
                                            break;
                                          }
                  
                                        }
                                        echo $tipo_combustivel_co2_por_km." CO₂/km";
                                        ?>
                                      </p>
                                    </div>
                                  
                                    <a href="{{ URL::to('veiculo/'.session()->get('base_veiculos')[$i]['veiculo_id']) }}">
                                      <button type="button" class="btn btn-info botoes_veiculos">Detalhes do veiculo</button>
                                    </a>
                                  </div>
                    
                                </div>
                              </div>
                            @endfor
                  
                        </div>
                      </div>
                      @endif

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

    <script src="./js/informacoes_base.js"></script>
        
@endsection