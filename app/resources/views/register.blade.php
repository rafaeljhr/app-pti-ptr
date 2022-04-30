<link rel="stylesheet" href="css/register.css">
@extends('layouts.page_default')

@section('background')
    
    <link rel="stylesheet" href="css/page_default.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

        <section class="h-100">

            <div v-show="!telephone_valid" class="alert alert-danger" role="alert">
                Telemóvel tem de ser um número!
            </div>

            <div v-show="!nif_valid" class="alert alert-danger" role="alert">
                NIF tem de ser um número!
            </div>

            <div class="container-form wow fadeInUp mt-5" data-wow-delay="0.5s">
                <div class="row">
                    <div class="col">
                        <form id="regForm" class="form-signin" method="post"  action="{{ route('register-controller') }}">
                            <h1 id="registar">REGISTAR COM</h1>
                            <div class="all-steps" id="all-steps"> <span class="step"></span> <span class="step"></span> <span class="step"></span> <span class="step"></span> </div>
                            <div class="tab">

                                <div class="row">
                                
                                    <div class="col d-flex justify-content-center align-items-center">
                                        
                                        <p>Registar com:</p>
                                    </div>

                                    <div class="col d-flex justify-content-center align-items-center">
                                
                                    <p>Registar através do email:</p>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col d-flex justify-content-center align-items-center">
                                        
                                        <button class="btn btn-lg" id="google" type="submit">
                                            <i class="fab fa-google me-2"></i> Google
                                        </button>
                                    </div>

                                    <div class="col d-flex justify-content-center align-items-center">
                                
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-outline mb-4">
                                                    <label for="email" class="form-label">Email</label>
                                                    <i class="bi-asterisk ms-1 text-danger" aria-hidden="true"></i>
                                                    <input required type="email" name ="email" id="email" class="form-control form-control-lg" placeholder="Introduz o seu email">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="tab">

                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <select @change="switchSelect($event)" class="form-select" name="selectedOption" aria-label="Tipo de Utilizador">
                                            <option selected value="consumidor">Consumidor</option>
                                            <option value="transportadora">Transportadora</option>
                                            <option value="fornecedor">Fornecedora</option>
                                        </select>
                                    </div> 
                                </div>

                                <div class="row"> 
                                    <div class="form-outline mb-4">
                                        <label for="nome" class="form-label">Nome</label>
                                        <i class="bi-asterisk ms-1 text-danger" aria-hidden="true"></i>
                                        <input required type="text" name ="name" id="name" class="form-control form-control-lg" placeholder="Introduza o seu nome">
                                    </div>
                                
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label for="phone_number" class="form-label">Telemóvel</label>
                                            <i class="bi-asterisk ms-1 text-danger" aria-hidden="true"></i>
                                            <input @input="checkForm()" ref="userTel" required type="text" name ="phone_number" id="phone_number" class="form-control form-control-lg" placeholder="Introduza o seu número" minlength="9" maxlength="9">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label v-if="clientConsumer" for="nif" class="form-label">NIF</label>
                                            <label v-else for="nif" class="form-label">NIF da Empresa</label>
                                            <i class="bi-asterisk ms-1 text-danger" aria-hidden="true"></i>
                                            <input @input="checkForm()" ref="userNIF" required type="text" name ="nif" id="nif" class="form-control form-control-lg" placeholder="Introduza o seu NIF" minlength="9" maxlength="9">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <label v-if="clientConsumer" for="address" class="form-label">Morada</label>
                                        <label v-else for="address" class="form-label">Morada Fiscal</label>
                                        <i class="bi-asterisk ms-1 text-danger" aria-hidden="true"></i>
                                        <input required type="text" id="address" name="address" class="form-control form-control-lg" placeholder="Introduza a sua morada" autofocus="">  
                                    </div>
                                </div>

                                
                            </div>
                            <div class="tab">
                                
                                <div class="row">
                                    <div class="form-outline mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <ul>
                                            <li :class="[{'checked': contains_eight_characters}]">Pelo menos 8 caracteres</li>
                                            <li :class="[{'checked': contains_number}]">Pelo menos um número</li>
                                            <li :class="[{'checked': contains_uppercase}]">Pelo menos uma letra maiúscula</li>
                                            <li :class="[{'checked': contains_special_character}]">Pelo menos um caracter especial</li>
                                        </ul>
                                        <input v-model="password" @input="checkPassword()" type="password" id="password" name ="password" class="form-control form-control-lg mb-2" placeholder="Introduza a sua password" required autocomplete="off">
                                        <input v-model="password2" @input="checkPassword()" type="password" id="password2" name ="password2" class="form-control form-control-lg" placeholder="Confirme a password" required autocomplete="off">
                                        <p v-show="diff_password" class="text-danger">As duas passwords não coincidem!</p>
                                    </div>

                                    <p><i class="bi-asterisk ms-1 text-danger" aria-hidden="true"></i> Obrigatório</p>
                                </div>
                            </div>
                            
                            <div class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
                                <h3>Thanks for your Donation!</h3> <span>Your donation has been entered! We will contact you shortly!</span>
                            </div>
                            <div style="overflow:auto;" id="nextprevious">
                                <div style="float:right;"> <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button> <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        @include('includes.footer')

    <script src="./js/register.js"></script>
    
@endsection


