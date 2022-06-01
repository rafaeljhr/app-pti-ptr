<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php
    //dd(session()->all());
    $cadeiaNome = session()->get('cadeia_atual')['nome_cadeia'];

   

    $cadeiaCo2 = session()->get('cadeia_atual')['co2_cadeia'];
    $cadeiaKwh = session()->get('cadeia_atual')['kwh_cadeia'];
    $cadeiaDesc = session()->get('cadeia_atual')['descricao_cadeia'];
    

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
                    <p>Tem a certeza que deseja apagar o seu armazém?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="post" action="{{ route('armazem-delete-controller') }}">
                    @csrf
                    <input hidden value="<?php echo session()->get('cadeia_atual')['cadeia_id']?>" name="id_cadeia">
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </form>
                </div>
            </div>
            </div>
        </div>

        

{{-- /////////////////////////////////////////////////////////////////////////////////// --}}
        <div class="form-div mx-auto my-1 px-3">

            <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">INFORMAÇÕES DA CADEIA</h1>

            

            <br>

            <div class="px-4">
                <form method="post" action="{{ route('cadeia-edit-controller') }}">
                    @csrf

                    <div class="row">

                        <div class="col">
                            <label class="mb-2" for="nome">Nome</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="nome" type="text" name="nome" class="form-control mb-3" value="<?php echo session()->get('cadeia_atual')['nome_cadeia'] ?>" :disabled="!editable">
                                <i v-show="nome_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um nome"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <label class="mb-2" for="co2">Co2 produzido</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="co2" type="number" name="co2" class="form-control mb-3" value="<?=$cadeiaCo2?>" :disabled="!editable">
                                <i v-show="co2_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um valor"></i>
                            </div>
                        </div>
                        <div class="col">
                            <label for="kwh" class="mb-2">Kwh consumidos</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="kwh" type="number" name="kwh" class="form-control" value="<?=$cadeiaKwh?>" :disabled="!editable">
                                <i v-show="kwh_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um valor"></i>
                            </div>
                        </div>
                        

                    </div>

                    <div class="row">

                        

                        <div class="col">
                            <label class="mb-2" for="desc">Descrição geral</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="desc" type="text" name="desc" class="form-control mb-3" value="<?=$cadeiaDesc?>" :disabled="!editable">
                                <i v-show="desc_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um texto"></i>
                            </div>
                        </div>

                    </div>

                    <br>

                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                   



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
                        <button v-show="!editable" type="button" class="btn btn-long btn-success" @click="editable = true">EDITAR CADEIA</button>
                        <button v-show="editable" type="submit" class="btn btn-long btn-warning me-3" id="guardar_alteracoes" disabled>GUARDAR ALTERAÇÕES</button>
                        <button v-show="editable" type="button" class="btn btn-long btn-primary" @click="cancelChanges()">CANCELAR ALTERAÇÕES</button>
                        <button type="button" class="btn btn-danger position-absolute end-0" data-bs-toggle="modal" data-bs-target="#modalApagar">APAGAR CADEIA</button>
                    </div>

                </form>
                </div>
            </div>
        </div>  

    </div>

@include('includes.footer')

<script src="./js/informacoes_cadeia.js"></script>
    
@endsection