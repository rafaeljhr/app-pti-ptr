<?php

// dd(session()->all());
// session()->forget('user_google_id');

Session::put('login_ou_registo', "registo");
?>


<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<link rel="stylesheet" href="css/register.css">
@extends('layouts.page_default')

@section('background')
    
    <link rel="stylesheet" href="css/page_default.css">

        <section class="h-100">

            @if(session()->get('user_google_id')!=null) 
                <input v-model="user_google_id" type="hidden" id="user_google_id" name="user_google_id" value="<?php echo session()->get('user_google_id')?>">
            @endif           

            <div class="container-form">
                <div class="row">
                    <div class="col"> <br><br>
                        <form @submit.prevent="finalizarRegisto" id="regForm" class="form-signin" method="post"  action="{{ route('register-controller') }}" enctype="multipart/form-data">
                            @csrf
                            <h1 ref="header" id="registar">REGISTAR</h1> <br>
                            <div ref="all_steps" id="all-steps"> <span class="step"></span> <span class="step"></span> <span class="step"></span>  <span class="step"></span> </div>
                            
                            <div class="tab">
                                <div class="row d-flex justify-content-center">

                                        <div class="form-outline mb-4 text-center">
                                            <a href="{{ route('auth/google') }}">
                                                <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                                            </a>
                                        </div>

                                        <hr>
                                        
                                        <div class="form-outline col-sm-7">
                                            <i class="ms-1 text-danger" aria-hidden="true"></i>
                                            <input required @input="checkEmail()" ref="userEmail" type="text" name ="email" id="email" class="form-control mt-2 mb-2" placeholder="Introduza o seu email">
                                        </div>
                                </div>
                            </div>
                            
                            <div class="tab">

                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <label for="nome" class="form-label">Tipo de conta a registar</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <select @change="switchSelect($event)" class="form-select" name="selectedOption" aria-label="Tipo de Utilizador">
                                            <option selected value="consumidor">Consumidor</option>
                                            <option value="transportadora">Transportadora</option>
                                            <option value="fornecedor">Fornecedora</option>
                                        </select>
                                    </div> 
                                </div>
                                
                                <div class="row"> 
                                    <div class="form-outline mb-4">
                                        <label for="nome" class="form-label">Email</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <input ref="userInputEmail" type="text" name ="email" id="user_input_email" class="form-control" value="<?php echo session()->get('user_email')?>" disabled>
                                    </div>
                                </div>
                                
                                <div class="row"> 
                                    <div class="form-outline mb-4">
                                        <label for="nome" class="form-label">Nome</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>

                                        @if(session()->get('user_google_id')==null) 
                                            <input ref="userName" required type="text" name ="name" id="name" class="form-control" placeholder="Introduza o seu nome">
                                        @else
                                            <input type="text" name ="name" id="name" class="form-control form-control-lg" value="<?php echo session()->get('user_nome')?>" placeholder="Introduza o seu nome">
                                        @endif

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label for="phone_number" class="form-label">Telemóvel</label>
                                            <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                            <div class="inline-icon">
                                                <input @input="checkForm()" ref="userTel" required type="text" name ="phone_number" id="phone_number" class="form-control" placeholder="Introduza o seu número" maxlength="9">
                                                <i v-show="telephone_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Telemóvel tem de ser um número"></i>
                                                <i v-show="telephone_valid === true" class="bi bi-check check-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label v-if="clientConsumer" for="nif" class="form-label">NIF</label>
                                            <label v-else for="nif" class="form-label">NIF da Empresa</label>
                                            <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                            <div class="inline-icon">
                                                <input @input="checkForm()" ref="userNIF" required type="text" name ="nif" id="nif" class="form-control" placeholder="Introduza o seu NIF" maxlength="9">
                                                <i v-show="nif_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="NIF tem de ser um número"></i>
                                                <i v-show="nif_valid === true" class="bi bi-check check-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <label v-if="clientConsumer" for="address" class="form-label">Morada</label>
                                        <label v-else for="address" class="form-label">Morada Fiscal</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <div class="inline-icon">
                                            <input required @input="checkForm()" ref="userMorada" type="text" id="address" name="address" class="form-control" placeholder="Introduza a sua morada">
                                            <i v-show="morada_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" title="Tem de introduzir uma morada"></i>
                                            <i v-show="morada_valid === true" class="bi bi-check check-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="tab" style="display:none;">
                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <div class="inline-icon">
                                            <input v-model="password" @input="validPasswords()" type="password" id="password" name ="password" class="form-control mb-2 me-1" placeholder="Introduza a sua password" required autocomplete="off">
                                            <i v-show="strong_password === 'no'" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" 
                                            title="Pelo menos 8 caracteres<br>Pelo menos um número<br>Pelo menos uma maiúscula<br>Pelo menos um carácter especial"></i>
                                            <i v-show="strong_password === 'yes'" class="bi bi-check check-icon"></i>
                                        </div>
                                        
                                        <div class="inline-icon">
                                            <input v-model="password2" @input="validPasswords()" type="password" id="password2" name ="password2" class="form-control me-1" placeholder="Confirme a password" required autocomplete="off">
                                            <i v-show="diff_password === 'yes'" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="As duas passwords não coincidem!"></i>
                                            <i v-show="diff_password === 'no'" class="bi bi-check check-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div ref="tab_imagem" class="tab" id='tab_da_imagem'>

                                @if(session()->get('user_google_id')==null) 
                                    <img src="images/foto.png" width="200" class="d-grid mx-auto" alt="">
                                    <input type="file" id='path_imagem' name="path_imagem" class="adicionar-foto d-grid mx-auto">
                                @else
                                    <label for="path_imagem" class="form-label">A sua imagem Google</label>
                                    <img src="<?php echo session()->get('user_path_imagem')?>" id='path_imagem' name="path_imagem" width="200" class="d-grid mx-auto" referrerpolicy="no-referrer">
                                @endif

                            </div>
                            
                            <div ref="text_message" class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
                                <h3>Conta criada com sucesso!</h3> <span>Pode agora desfrutar das funcionalidades todas do site!</span>
                            </div>

                            <div ref="next_previous" style="overflow:auto;" id="nextprevious">
                                <div class="gap-2 d-grid mx-auto col-4"> 
                                    <button ref="prevBtn" type="button" class="btn" id="prevBtn" @click="nextPrev(-1)">Anterior</button> 
                                    <button ref="nextBtn" :disabled="!form_valid" type="button" class="btn btn-color" id="nextBtn" @click="nextPrev(1)">Seguinte</button>
                                    <button ref="btn_finalizar" type="submit" class="btn btn-color" id="btn-finalizar">Finalizar</button>
                                
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        @include('includes.footer')

    <script src="./js/register.js"></script>
    
@endsection

