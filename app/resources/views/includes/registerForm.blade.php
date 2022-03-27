<div class="container py-5">

    <div class="form-div mx-auto my-2 px-3">  

        <img class="logo" src="images/logo.png" alt="EcoSmart Logo">

        <h1 class="h3 mb-4 font-weight-normal">Junte-se ao grupo EcoSmart!</h1>

        <h2 class="h4 mb-2 font-weight-normal text-light">Eu sou um/a:</h1>
        
        <form class="form-signin" method="post" action="{{ route('register-controller') }}">
            @csrf

            <div class="form-group row px-3">
                <select class="form-select" name="selectedOption" aria-label="Tipo de Utilizador">
                    <option @click="clientConsumer = true" selected value="consumidor">Consumidor</option>
                    <option @click="clientConsumer = false" value="transportadora">Transportadora</option>
                    <option @click="clientConsumer = false" value="fornecedor">Fornecedora</option>
                </select>
            </div>

            <div class="form-group" v-show="clientConsumer">
                <div class="row">
                    <div class="col">
                        <label for="inputNameConsumer" class="sr-only text-light">Nome</label>
                        <input type="text" name ="inputNameConsumer" id="inputNameConsumer" class="form-control form-control-sm mb-2" placeholder="João Carvalho">
                    </div>
                    <div class="col">
                        <label for="inputEmailConsumer" class="sr-only text-light">Email</label>
                        <input type="email" name ="inputEmailConsumer" id="inputEmailConsumer" class="form-control form-control-sm mb-2" placeholder="eco@smart.com">
                    </div>                    
                </div>

                <div class="row">
                    <div class="col">
                        <label for="inputTelConsumer" class="sr-only text-light">Telemóvel</label>
                        <input type="text" name ="inputTelConsumer" id="inputTelConsumer" class="form-control form-control-sm mb-2" placeholder="987654321" size="9">
                    </div>
                    
                    <div class="col">
                        <label for="inputNIFConsumer" class="sr-only text-light">NIF</label>
                        <input type="text" name ="inputNIFConsumer" id="inputNIFConsumer" class="form-control form-control-sm mb-2" placeholder="123456789" size="9">
                    </div>                 
                </div>
                
                <div class="row form-group">
                    <div class="col">
                        if consumid
                        <label for="inputAdressConsumer" class="sr-only text-light">Morada</label>
                        if 
                        <input type="text" name ="inputAdressConsumer" id="inputAdressConsumer" class="form-control form-control-sm mb-2" placeholder="Rua Avenida Nº7 6ºE" maxlength="200">
                    </div>
                    <div class="col">
                        <label for="passwordConsumer" class="sr-only text-light">Password</label>
                        <input type="password" name ="passwordConsumer" id="passwordConsumer" class="form-control form-control-sm mb-2" placeholder="**********">
                    </div>                    
                </div>
            </div>


            
            <div class="form-group" v-show="!clientConsumer">
                <div class="row">
                    <div class="col">
                        <label for="inputNameNonConsumer" class="sr-only text-light">Nome</label>
                        <input type="text" name ="inputNameNonConsumer" id="inputNameNonConsumer" class="form-control form-control-sm mb-2" placeholder="JC S.A">
                    </div>
                    <div class="col">
                        <label for="inputEmailNonConsumer" class="sr-only text-light">Email</label>
                        <input type="email" name ="inputEmailNonConsumer" id="inputEmailNonConsumer" class="form-control form-control-sm mb-2" placeholder="eco@smart.com">
                    </div>                    
                </div>

                <div class="row">
                    <div class="col">
                        <label for="inputTelNonConsumer" class="sr-only text-light">Telemóvel</label>
                        <input type="text" name ="inputTelNonConsumer" id="inputTelNonConsumer" class="form-control form-control-sm mb-2" placeholder="987654321" size="9">
                    </div>
                    <div class="col">
                        <label for="inputNIFNonConsumer" class="sr-only text-light">NIF da Empresa</label>
                        <input type="text" name ="inputNIFNonConsumer" id="inputNIFNonConsumer" class="form-control form-control-sm mb-2" placeholder="123456789" size="9">
                    </div>                    
                </div>
                
                <div class="row">
                    <div class="col">
                        <label for="inputAdressNonConsumer" class="sr-only text-light">Morada Fiscal</label>
                        <input type="text" name ="inputAdressNonConsumer" id="inputAdressNonConsumer" class="form-control form-control-sm mb-2" placeholder="R. Sebastião e Mendes  50 e 51A" maxlength="200">
                    </div>
                    <div class="col">
                        <label for="password" class="sr-only text-light">Password</label>
                        <input type="password" name ="password" id="password" class="form-control form-control-sm mb-2" placeholder="**********">
                    </div>                    
                </div>
            </div>

            <button class="btn btn-lg btn-secondary btn-block my-2" type="submit">Registar</button>
        </form>
    </div>
</div>

<script>
    let app = Vue.createApp({
        data: function() {
            return {
                clientConsumer: true
            }
        }
    })

    app.mount('.app')
</script>
