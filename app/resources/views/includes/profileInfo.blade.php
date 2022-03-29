<?php
$clientConsumer = false;

$userName = Session::get('userName');
$userEmail = Session::get('userEmail');
$userTel = Session::get('userTel');
$userNIF = Session::get('userNIF');
$userAdress = Session::get('userAdress');
$userPassword = Session::get('userPassword');

if (Session::get('userType') == 'consumidor') {
    $clientConsumer = true;
}

/*
Função para limpar a session
function deleteUser() {
    Session::flush();
}
*/
?>

<div class="container py-5">
    
    <div class="form-div mx-auto my-2 px-3">  
        <img class="logo" src="images/logo6.png" alt="EcoSmart Logo">

        <h1 class="h3 mb-4 font-weight-normal">Os Meus Dados</h1>

        <div class="px-4 py-4">
            <form method="post" action="{{ route('profile-controller') }}">
                <div class="prof-info">
                    <div class="row" >                    
                        <div class="col-sm ">
                            <label for="nome" class="form-label text-light">Nome</label>
                            <input type="text" name="nome" class="form-control mb-3" placeholder="Introduza o seu nome" aria-label="Nome do Utilizador"
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
                            <label for="telemovel" class="form-label text-light">Telemóvel</label>
                            <div class="input-group mb-3">
                                <input name="telemovel" type="text" class="form-control" placeholder="Introduza o seu número" aria-label="Telemóvel do Utilizador"
                                    aria-describedby="Telemóvel do Utilizador" minlength="9" maxlength="9" v-model="userTel" :disabled="editable == false">
                            </div>
                        </div>
                    </div>
    
                    <div v-show="clientConsumer" class="row">              
                        <div class="col-sm">
                            <label v-if="clientConsumer" for="nif" class="sr-only text-light">NIF</label>
                            <label v-else for="nif" class="sr-only text-light">NIF da Empresa</label>
                            <input type="text" name="nifConsumidor" class="form-control mb-3" placeholder="Introduza o seu NIF" aria-label="NIF do Utilizador"
                            aria-describedby="NIF do Utilizador" minlength="9" maxlength="9" v-model="userNIF" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label v-if="clientConsumer" for="adress" class="sr-only text-light">Morada</label>
                            <label v-else for="adress" class="sr-only text-light">Morada Fiscal</label>
                            <input type="text" name="morada" class="form-control mb-3" placeholder="Introduza a sua morada" aria-label="Morada do Utilizador"
                            aria-describedby="Morada do Utilizador" v-model="userAdress" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label for="password" class="form-label text-light">Password</label>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control" placeholder="Introduza a sua password" aria-label="Password do Utilizador"
                                    aria-describedby="Password do Utilizador" v-model="userPassword" :disabled="editable == false">
                            </div>
                        </div>
                    </div>

                    <div class="my-2">
                        <button v-show="!editable" type="button" class="btn btn-primary" @click="editable = !editable">Editar Dados</button>
                        <button v-show="editable" type="submit" class="btn btn-secondary" @click="editable = !editable">Guardar Alterações</button>
                    </div>
                </div>
            </form>

            <button type="button" class="btn btn-danger">Apagar Conta</button>

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
                userPassword: @json($userPassword),
                editable: false
            }
        }
    })

    app.mount('.app')
</script>