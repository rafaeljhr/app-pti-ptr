<div class="container">
    <form class="form-signin">
        <div class="form-div mx-auto my-2 px-3">  
            <img class="logo" src="images/logo.png" alt="EcoSmart Logo">

            <h1 class="h3 mb-2 font-weight-normal">Junte-se ao grupo EcoSmart!</h1>

            <div class="row px-3">
                <div class="form-check form-check-inline col">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="consumidorSelect" value="optionConsumidor" checked>
                    <label class="form-check-label text-light" for="inlineRadio1">Consumidor</label>
                </div>

                <div class="form-check form-check-inline col">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="transportadoraSelect" value="optionTransportadora">
                    <label class="form-check-label text-light" for="inlineRadio1">Transportadora</label>
                </div>

                <div class="form-check form-check-inline col">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="fornecedorSelect" value="optionFornecedor">
                    <label class="form-check-label text-light" for="inlineRadio1">Fornecedora</label>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="inputName" class="sr-only text-light">Nome</label>
                    <input type="text" id="inputName" class="form-control form-control-sm mb-2" placeholder="João Carvalho" required="" autofocus="">
                </div>
                <div class="col">
                    <label for="inputEmail" class="sr-only text-light">Email</label>
                    <input type="email" id="inputEmail" class="form-control form-control-sm mb-2" placeholder="eco@smart.com" required="" autofocus="">
                </div>                    
            </div>

            <div class="row">
                <div class="col">
                    <label for="inputTel" class="sr-only text-light">Telemóvel</label>
                    <input type="text" id="inputTel" class="form-control form-control-sm mb-2" placeholder="987654321" size="9" required="" autofocus="">
                </div>
                <div class="col">
                    <label for="inputNIF" class="sr-only text-light">NIF</label>
                    <input type="text" id="inputNIF" class="form-control form-control-sm mb-2" placeholder="123456789" size="9" required="" autofocus="">
                </div>                    
            </div>
            
            <div class="row">
                <div class="col">
                    <label for="inputAdress" class="sr-only text-light">Morada</label>
                    <input type="text" id="inputAdress" class="form-control form-control-sm mb-2" placeholder="Rua Avenida Nº7 6ºE" maxlength="200" required="" autofocus="">
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