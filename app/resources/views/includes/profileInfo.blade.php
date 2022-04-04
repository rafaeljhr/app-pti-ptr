<?php

$userName = Session::get('user_nome');
$userEmail = Session::get('user_email');
$userTel = Session::get('user_telemovel');
$userNIF = Session::get('user_nif');
$userAdress = Session::get('user_morada');

if (Session::get('userType') == 'consumidor') {
    $clientConsumer = true;
} else {
    $clientConsumer = false;
}

?>

<div class="container py-5">
    
    <div class="form-div mx-auto my-2 px-3">  
        <img class="logo" src="images/logo6.png" alt="EcoSmart Logo">

        <h1 class="h3 mb-4 font-weight-normal">Os Meus Dados</h1>

        <div class="px-4 py-4">
            <form method="post" action="{{ route('edit-profile-controller') }}">
                @csrf
                <div class="prof-info">
                    <div class="row" >                    
                        <div class="col-sm ">
                            <label for="name" class="form-label text-light">Nome</label>
                            <input type="text" name="name" class="form-control mb-3" placeholder="Introduza o seu nome" aria-label="Nome do Utilizador"
                            aria-describedby="Nome do Utilizador" v-model="userName" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label for="email" class="form-label text-light">Email</label>
                            <div class="input-group mb-3">
                                <input name="email" type="email" class="form-control" placeholder="Introduza o seu email" aria-label="Email do Utilizador"
                                    aria-describedby="Email do Utilizador" v-model="userEmail" :disabled="editable == false">
                            </div>
                        </div>
    
                        <div class="col-sm">
                            <label for="phone_number" class="form-label text-light">Telemóvel</label>
                            <div class="input-group mb-3">
                                <input name="phone_number" type="text" class="form-control" placeholder="Introduza o seu número" aria-label="Telemóvel do Utilizador"
                                    aria-describedby="Telemóvel do Utilizador" minlength="9" maxlength="9" v-model="userTel" :disabled="editable == false">
                            </div>
                        </div>
                    </div>
    
                    <div v-show="clientConsumer" class="row">              
                        <div class="col-sm">
                            <label v-if="clientConsumer" for="nif" class="sr-only text-light">NIF</label>
                            <label v-else for="nif" class="sr-only text-light">NIF da Empresa</label>
                            <input type="text" name="nif" class="form-control mb-3" placeholder="Introduza o seu NIF" aria-label="NIF do Utilizador"
                            aria-describedby="NIF do Utilizador" minlength="9" maxlength="9" v-model="userNIF" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label v-if="clientConsumer" for="address" class="sr-only text-light">Morada</label>
                            <label v-else for="address" class="sr-only text-light">Morada Fiscal</label>
                            <input type="text" name="address" class="form-control mb-3" placeholder="Introduza a sua morada" aria-label="Morada do Utilizador"
                            aria-describedby="Morada do Utilizador" v-model="userAdress" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label for="password" class="form-label text-light">Password</label>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control" placeholder="Introduza a sua password" aria-label="Password do Utilizador"
                                     aria-describedby="Password do Utilizador" :disabled="editable == false"> 
                                     {{-- Não faz sentido mostrar aqui a password do Utilizador. Se fosse guardada na sessão, estaria na forma de hash! --}}
                            </div>
                        </div>
                    </div>

                    <div class="my-2">
                        <button v-show="!editable" type="button" class="btn btn-primary" @click="editable = !editable">Editar Dados</button>
                        <button v-show="editable" type="submit" class="btn btn-secondary" @click="editable = !editable">Guardar Alterações</button>
                    </div>
                </div>
            </form>

            <form method="post" action="{{ route('delete-profile-controller') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Apagar Conta</button>
            </form>

        </div>
    </div>    
</div>

<script>
    let app = Vue.createApp({
        data: function() {
            return {
                clientConsumer: @json($clientConsumer),
                userName: @json($userName),
                userEmail: @json($userEmail),
                userTel: @json($userTel),
                userNIF: @json($userNIF),
                userAdress: @json($userAdress),
                editable: false
            }
        }
    })

    app.mount('.app')
</script>