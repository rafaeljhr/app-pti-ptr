<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php

    

    //dd(session()->all());

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
                <form method="post" action="{{ route('product-remove') }}">
                    @csrf
                    <input hidden value="<?php echo session()->get('produto_atual')['produto_id']?>" name="id_produto">
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
                        <img src="<?php echo session()->get('produto_atual')['produto_path_imagem'] ?>" id="imagem_a_alterar" class="mx-auto" alt="">
                    </div>
                </div>

                <form id="changeAvatar" method="post" action="{{ route('update-imagem-produto-controller') }}" enctype="multipart/form-data">
                    @csrf
                    <input onchange="alterarImagem(event)" ref="redUploadImagem" type="file" name="mudar_path_imagem" class="w-50 adicionar-foto d-grid mx-auto">
                </form>

                <div id="submitChangeAvatar" class="modal-footer" style="display: none">
                    <button type="submit" form="changeAvatar" class="btn btn-danger">Confirmar</button>
                    
                </div>

            </div>
            </div>
        </div>

{{-- /////////////////////////////////////////////////////////////////////////////////// --}}
        <div class="form-div mx-auto my-1 px-3">

            <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">INFORMAÇÕES DO PRODUTO</h1>

            <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('produto_atual')['produto_path_imagem'] ?>" referrerpolicy="no-referrer">
            <div class="mt-2 w-25 mx-auto">
                <button type="button" class="btn form-control alterar_imagem_botao" data-bs-toggle="modal" data-bs-target="#modalMudarAvatar">ALTERAR IMAGEM</button>
            </div>

            <br>

            <div class="px-4">
                

                    <br>

                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    @if(Session::get('cadeias_produto_atual') != [])
                    

                        <h3 class="mt-3 mb-5 text-center">Cadeias associadas ao seu produto</h3>

                        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
                          
                            @for($i = 0; $i < sizeOf(session()->get('cadeias_produto_atual')); $i++)
                            <div class="col">
                                <div class="evento-size card">
                                  <h5 class="card-title"><?php echo session()->get('cadeias_produto_atual')[$i]['evento_nome'] ?></h5>
                                  <h4 class="card-text ">CO2 criados: <?php echo session()->get('cadeias_produto_atual')[$i]['evento_co2'] ?></h4>             
                                  <h4 class="card-text ">Kwh consumidos: <?php echo session()->get('cadeias_produto_atual')[$i]['evento_kwh'] ?></h4>
                                  <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo session()->get('cadeias_produto_atual')[$i]['evento_desc'] ?></h5>
                                  </div>
                    
                                </div>
                              </div>
                            @endfor
                  
                        
                      </div>
                      @endif
                    



                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}{{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}

                    <br><br>

                    <div class="position-relative my-1">
                        <button v-show="!editable" type="button" class="btn btn-long btn-success" @click="editable = true">EDITAR PRODUTO</button>
                        <button v-show="editable" type="submit" class="btn btn-long btn-warning me-3" id="guardar_alteracoes" disabled>GUARDAR ALTERAÇÕES</button>
                        <button v-show="editable" type="button" class="btn btn-long btn-primary" @click="cancelChanges()">CANCELAR ALTERAÇÕES</button>
                        <button type="button" class="btn btn-danger position-absolute end-0" data-bs-toggle="modal" data-bs-target="#modalApagar">APAGAR PRODUTO</button>
                    </div>

                
                </div>
            </div>
        </div>  

    </div>

@include('includes.footer')

<script src="./js/informacoes_armazem.js"></script>
    
@endsection