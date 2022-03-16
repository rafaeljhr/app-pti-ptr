<div class="container">
    
    <div class="form-div mx-auto my-2 px-3">  
        <img class="logo" src="images/logo.png" alt="EcoSmart Logo">

        <h1 class="h3 mb-4 font-weight-normal">Junte-se ao grupo EcoSmart!</h1>

        <h2 class="h4 mb-2 font-weight-normal text-light">Eu sou um/a:</h1>

        <div class="row px-3">
            <div class="form-check form-check-inline col">
                <input @click="clienteConsumidor = true" class="form-check-input" type="radio" name="inlineRadioOptions" id="consumidorSelect" value="optionConsumidor" checked>
                <label class="form-check-label text-light" for="inlineRadio1">Consumidor/a</label>
            </div>

            <div class="form-check form-check-inline col">
                <input @click="clienteConsumidor = false" class="form-check-input" type="radio" name="inlineRadioOptions" id="transportadoraSelect" value="optionTransportadora">
                <label class="form-check-label text-light" for="inlineRadio1">Transportador/a</label>
            </div>

            <div class="form-check form-check-inline col">
                <input @click="clienteConsumidor = false" class="form-check-input" type="radio" name="inlineRadioOptions" id="fornecedorSelect" value="optionFornecedor">
                <label class="form-check-label text-light" for="inlineRadio1">Fornecedor/a</label>
            </div>
        </div>

        <form v-show="clienteConsumidor" class="form-signin">
            <div class="row">
                <div class="col">
                    <label for="inputNameConsumer" class="sr-only text-light">Nome</label>
                    <input type="text" id="inputNameConsumer" class="form-control form-control-sm mb-2" placeholder="João Carvalho" required="" autofocus="">
                </div>
                <div class="col">
                    <label for="inputEmailConsumer" class="sr-only text-light">Email</label>
                    <input type="email" id="inputEmailConsumer" class="form-control form-control-sm mb-2" placeholder="eco@smart.com" required="" autofocus="">
                </div>                    
            </div>

            <div class="row">
                <div class="col">
                    <label for="inputTelConsumer" class="sr-only text-light">Telemóvel</label>
                    <input type="text" id="inputTelConsumer" class="form-control form-control-sm mb-2" placeholder="987654321" size="9" required="" autofocus="">
                </div>
                <div class="col">
                    <label for="inputNIFConsumer" class="sr-only text-light">NIF</label>
                    <input type="text" id="inputNIFConsumer" class="form-control form-control-sm mb-2" placeholder="123456789" size="9" required="" autofocus="">
                </div>                    
            </div>
            
            <div class="row">
                <div class="col">
                    <label for="inputAdressConsumer" class="sr-only text-light">Morada</label>
                    <input type="text" id="inputAdressConsumer" class="form-control form-control-sm mb-2" placeholder="Rua Avenida Nº7 6ºE" maxlength="200" required="" autofocus="">
                </div>
                <div class="col">
                    <label for="passwordConsumer" class="sr-only text-light">Password</label>
                    <input type="password" id="passwordConsumer" class="form-control form-control-sm mb-2" placeholder="**********" required="" autofocus="">
                </div>                    
            </div>
        
            <button class="btn btn-lg btn-secondary btn-block my-2" type="submit">Registar</button>
        </form>
    
    
        <form v-show="!clienteConsumidor" class="form-signin">
            <div class="limit-width mx-auto">
                
                <div class="row">
                    <div class="col">
                        <label for="inputNameNonConsumer" class="sr-only text-light">Nome</label>
                        <input type="text" id="inputNameNonConsumer" class="form-control form-control-sm mb-2" placeholder="JC S.A" required="" autofocus="">
                    </div>
                    <div class="col">
                        <label for="inputEmailNonConsumer" class="sr-only text-light">Email</label>
                        <input type="email" id="inputEmailNonConsumer" class="form-control form-control-sm mb-2" placeholder="eco@smart.com" required="" autofocus="">
                    </div>                    
                </div>

                <div class="row">
                    <div class="col">
                        <label for="inputTelNonConsumer" class="sr-only text-light">Telemóvel</label>
                        <input type="text" id="inputTelNonConsumer" class="form-control form-control-sm mb-2" placeholder="987654321" size="9" required="" autofocus="">
                    </div>
                    <div class="col">
                        <label for="inputNIFNonConsumer" class="sr-only text-light">NIF da Empresa</label>
                        <input type="text" id="inputNIFNonConsumer" class="form-control form-control-sm mb-2" placeholder="123456789" size="9" required="" autofocus="">
                    </div>                    
                </div>
                
                <div class="row">
                    <div class="col">
                        <label for="inputAdressNonConsumer" class="sr-only text-light">Morada Fiscal</label>
                        <input type="text" id="inputAdressNonConsumer" class="form-control form-control-sm mb-2" placeholder="R. Sebastião e Mendes  50 e 51A" maxlength="200" required="" autofocus="">
                    </div>
                    <div class="col">
                        <label for="password" class="sr-only text-light">Password</label>
                        <input type="password" id="password" class="form-control form-control-sm mb-2" placeholder="**********" required="" autofocus="">
                    </div>                    
                </div>

                <button class="btn btn-lg btn-secondary btn-block my-2" type="submit">Registar</button>
            </div>
        </form>
    </div>
</div>

<script>
    let app = Vue.createApp({
        data: function() {
            return {
                clienteConsumidor: true
            }
        }
    })

    app.mount('.app')
</script>
