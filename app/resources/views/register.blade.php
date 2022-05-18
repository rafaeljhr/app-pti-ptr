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
                <input v-model="user_google_id" type="hidden" id="user_google_id" name="1">
            @else 
                <input v-model="user_google_id" type="hidden" id="user_google_id" name="0">
            @endif           

            <div class="container-form">
                <div class="row">
                    <div class="col"> <br><br>
                        <form @submit.prevent="finalizarRegisto" id="regForm" class="form-signin" method="post"  action="{{ route('register-controller') }}" enctype="multipart/form-data">
                            @csrf
                            <h1 ref="header" id="registar">REGISTAR</h1> <br>
                            <div ref="all_steps" id="all-steps"> <span class="step"></span> <span class="step"></span> <span class="step"></span>  <span class="step"></span> </div>
                            
                            <div class="tab" id="tab_1">
                                <div class="row d-flex justify-content-center">

                                        <div class="form-outline mb-4 text-center">
                                            <a href="{{ route('auth/google') }}">
                                                <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                                            </a>
                                        </div>

                                        <hr>
                                        
                                        <div class="form-outline col-sm-7">
                                            <i class="ms-1 text-danger" aria-hidden="true"></i>
                                            <input @input="checkEmail()" ref="userEmail" type="text" name="email_first" id="email" class="form-control mt-2 mb-2" placeholder="Introduza o seu email">
                                        </div>
                                </div>
                            </div>
                            
                            <div class="tab">

                                <br><br>
                                <h3>Dados Principais</h3>
                                <hr class="my-4">

                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <label for="nome" class="form-label">Tipo de conta a registar</label>
                                        <select @change="switchSelect($event)" class="form-select" name="selectedOption" aria-label="Tipo de Utilizador">
                                            <option selected value="consumidor">Consumidor</option>
                                            <option value="transportadora">Transportadora</option>
                                            <option value="fornecedor">Fornecedor</option>
                                        </select>
                                    </div> 
                                </div>
                                
                                <div class="row"> 
                                    <div class="form-outline mb-4">
                                        <label for="nome" class="form-label">Email</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <input ref="userInputEmail" type="text" name="email" id="user_input_email" class="form-control" value="<?php echo session()->get('user_email')?>" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="primeiro_nome" class="form-label">Primeiro Nome</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <div class="inline-icon">
                                            @if(session()->get('user_google_id')==null) 
                                                <input @input="checkForm()" ref="primeiro_nome" type="text" name ="primeiro_nome" id="primeiro_nome" class="form-control">
                                            @else
                                                <input @input="checkForm()" ref="primeiro_nome" type="text" name ="primeiro_nome" id="primeiro_nome" class="form-control" value="<?php echo session()->get('user_nome')?>">
                                            @endif
                                            <i v-show="first_name_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir o primeiro nome"></i>
                                            <i v-show="first_name_valid === true" class="bi bi-check check-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="ultimo_nome" class="form-label">Último Nome</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <div class="inline-icon">
                                            <input @input="checkForm()" ref="ultimo_nome" type="text" name ="ultimo_nome" class="form-control">
                                            <i v-show="last_name_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir o último nome"></i>
                                            <i v-show="last_name_valid === true" class="bi bi-check check-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label v-if="clientConsumer" for="telemovel" class="form-label">Telemóvel</label>
                                            <label v-else for="telemovel" class="form-label">Telemóvel da Empresa</label>
                                            <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                            <div class="inline-icon">
                                                <input @input="checkForm()" ref="userTel" type="text" name ="telemovel" class="form-control" maxlength="9">
                                                <i v-show="telephone_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Telemóvel inválido"></i>
                                                <i v-show="telephone_valid === true" class="bi bi-check check-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label v-if="clientConsumer" for="numero_contribuinte" class="form-label">Número de contribuinte</label>
                                            <label v-else for="numero_contribuinte" class="form-label">Número de contribuinte da Empresa</label>
                                            <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                            <div class="inline-icon">
                                                <input @input="checkForm()" ref="user_numero_contribuinte" type="text" name ="numero_contribuinte" class="form-control" maxlength="9">
                                                <i v-show="numero_contribuinte_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Número de contribuinte inválido"></i>
                                                <i v-show="numero_contribuinte_valid === true" class="bi bi-check check-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <h3>Morada Principal</h3>
                                <hr class="my-4">

                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <label v-if="clientConsumer" for="address" class="form-label">Morada</label>
                                        <label v-else for="morada" class="form-label">Morada Fiscal</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <div class="inline-icon">
                                            <input @input="checkForm()" ref="userMorada" type="text" name="morada" class="form-control">
                                            <i v-show="morada_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" title="Tem de introduzir uma morada"></i>
                                            <i v-show="morada_valid === true" class="bi bi-check check-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="form-outline">
                                            <label for="cidade" class="form-label">Cidade</label>
                                            <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                            <div class="inline-icon">
                                                <input @input="checkForm()" ref="userCidade" type="text" name ="cidade" class="form-control">
                                                <i v-show="cidade_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir uma cidade"></i>
                                                <i v-show="cidade_valid === true" class="bi bi-check check-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="form-outline">
                                            <label for="codigo_postal" class="form-label">Código Postal</label>
                                            <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                            <div class="inline-icon">
                                                <input @input="checkForm()" ref="userCod_Postal_1" type="text" name ="codigo_postal_1" class="form-control" maxlength="4" placeholder="xxxx">
                                                <input @input="checkForm()" ref="userCod_Postal_2" type="text" name ="codigo_postal_2" class="form-control" maxlength="3" placeholder="xxx">
                                                <i v-show="codigo_postal_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Código postal inválido"></i>
                                                <i v-show="codigo_postal_valid === true" class="bi bi-check check-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="pais" class="form-label">País</label>
                                        <select class="form-control"  name="pais">
                                            <option selected>Portugal</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        
                            <div class="tab" style="display:none;">
                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <label for="password" class="form-label">Palavra-passe</label>
                                        <i class="bi-asterisk ms-1 asterisk-icon text-danger" aria-hidden="true"></i>
                                        <div class="inline-icon">
                                            <input v-model="password" @input="validPasswords()" type="password" id="password" name ="password" class="form-control mb-2 me-1" placeholder="Introduza a sua password" autocomplete="off">
                                            <i v-show="strong_password === 'no'" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" 
                                            title="Pelo menos 8 caracteres<br>Pelo menos um número<br>Pelo menos uma maiúscula<br>Pelo menos um carácter especial"></i>
                                            <i v-show="strong_password === 'yes'" class="bi bi-check check-icon"></i>
                                        </div>
                                        
                                        <div class="inline-icon">
                                            <input v-model="password2" @input="validPasswords()" type="password" id="password2" name ="password2" class="form-control me-1" placeholder="Confirme a password" autocomplete="off">
                                            <i v-show="diff_password === 'yes'" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="As duas passwords não coincidem!"></i>
                                            <i v-show="diff_password === 'no'" class="bi bi-check check-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div ref="tab_imagem" class="tab" id='tab_da_imagem'>
                                @if(session()->get('user_google_id')==null) 
                                    <div class="form-outline mb-4 text-center">
                                        <br>
                                        <h3>O seu avatar</h3>
                                        <img src="images/default_user.png" id="image_do_utilizador" width="200" class="d-grid mx-auto" alt="">
                                    
                                        <input onchange="alterarImagemUser(event)" ref="redUploadImagem" type="file" id='path_imagem' name="path_imagem" class="w-25 adicionar-foto d-grid mx-auto">
                                    </div>
                                @else
                                    <div class="form-outline mb-4 text-center">
                                        <br>
                                        <h3>O seu avatar Google</h3>
                                        <img src="<?php echo session()->get('user_path_imagem')?>" id='path_imagem' name="path_imagem" width="200" class="d-grid mx-auto mb-3" referrerpolicy="no-referrer">
                                    </div>
                                @endif

                            </div>
                            
                            <div ref="text_message" class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
                                <h3>Conta criada com sucesso!</h3> <span>Pode agora desfrutar das funcionalidades todas do site!</span>
                            </div>

                            <div ref="next_previous" style="overflow:auto;" id="nextprevious">
                                <div class="gap-2 d-grid mx-auto col-4"> 
                                    <button ref="prevBtn" type="button" class="btn" id="prevBtn" @click="back_track = true; nextPrev(-1);">Anterior</button> 
                                    <button ref="nextBtn" :disabled="!form_valid" type="button" class="btn btn-color" id="nextBtn" @click="nextPrev(1)">Seguinte</button>
                                    <button ref="btn_finalizar" type="submit" class="btn btn-color" id="btn-finalizar">Finalizar</button>
                                
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    <script src="./js/register.js"></script>
    
@endsection

