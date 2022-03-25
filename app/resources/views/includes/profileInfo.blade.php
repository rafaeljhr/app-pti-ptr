<?php
$clientConsumer = false;

if (Session::get('userType') == 'consumidor') {
    $clientConsumer = true;
}
?>

<div class="container">
    
    <div class="form-div mx-auto my-2 px-3">  
        <img class="logo" src="images/logo.png" alt="EcoSmart Logo">

        <h1 class="h3 mb-4 font-weight-normal">Os Meus Dados</h1>

        <div class="px-4 py-4">
            <form>
            
                <div class="prof-info">
                    <div class="row" >                    
                        <div class="col-sm ">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control mb-3" placeholder="Nome" value="João Carvalho" aria-label="Nome do Utilizador"
                            aria-describedby="Nome do Utilizador" value="Francisco Pimenta" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group mb-3">
                                <input name="email" type="email" class="form-control" placeholder="eco@smart.com" aria-label="Email do Utilizador"
                                    aria-describedby="Email do Utilizador" value="fpimenta@gmail.com" :disabled="editable == false">
                            </div>
                        </div>
    
                        <div class="col-sm">
                            <label for="telemovel" class="form-label">Telemóvel</label>
                            <div class="input-group mb-3">
                                <input name="telemovel" type="text" class="form-control" placeholder="987654321" aria-label="Telemóvel do Utilizador"
                                    aria-describedby="Telemóvel do Utilizador" value="910219301" :disabled="editable == false">
                            </div>
                        </div>
                    
                    </div>
    
                    <div v-show="clientConsumer" class="row">              
                        <div class="col-sm">
                            <label for="nifConsumidor" class="form-label">NIF</label>
                            <input type="text" name="nifConsumidor" class="form-control mb-3" placeholder="123456789" aria-label="NIF do Utilizador"
                            aria-describedby="NIF do Utilizador" value="251191699" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label for="morada" class="form-label">Morada</label>
                            <input type="text" name="morada" class="form-control mb-3" placeholder="Rua Eco Smart Nº4 Lote 4" aria-label="Morada do Utilizador"
                            aria-describedby="Morada do Utilizador" value="Av. Fernando Ricardo Ribeiro Leitão" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control" placeholder="*********" aria-label="Password do Utilizador"
                                    aria-describedby="Password do Utilizador" value="xisco" :disabled="editable == false">
                            </div>
                        </div>
                    </div>

                    <div v-show="!clientConsumer" class="row">              
                        <div class="col-sm">
                            <label for="nifConsumidor" class="form-label">NIF da Empresa</label>
                            <input type="text" name="nifConsumidor" class="form-control mb-3" placeholder="123456789" aria-label="NIF da Empresa"
                            aria-describedby="NIF do Utilizador" value="251191699" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label for="morada" class="form-label">Morada Fiscal</label>
                            <input type="text" name="morada" class="form-control mb-3" placeholder="Rua Eco Smart Nº4 Lote 4" aria-label="Morada Fiscal da Empresa"
                            aria-describedby="Morada do Utilizador" value="Av. Fernando Ricardo Ribeiro Leitão" :disabled="editable == false">
                        </div>
    
                        <div class="col-sm">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control" placeholder="*********" aria-label="Password da Empresa"
                                    aria-describedby="Password do Utilizador" value="xisco" :disabled="editable == false">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary"@click="editable = !editable">Editar Dados</button>

                </div>
            </form>
        </div>
    </div>    
</div>

<script>
    let app = Vue.createApp({
        data: function() {
            return {
                clientConsumer: @json($clientConsumer),
                editable: false
            }
        }
    })

    app.mount('.app')
</script>