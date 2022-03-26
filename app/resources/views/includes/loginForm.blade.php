<div class="container py-5">
    <form class="form-signin" method="post" action="{{ route('login') }}">
        @csrf
        
        <div class="limit-width mx-auto">  
            <img class="logo" src="images/logo.png" alt="EcoSmart Logo">

            <h1 class="h3 mb-2 font-weight-normal">Autentique-se para usufruir  de todas as funcionalidades!</h1>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="consumidorSelect" value="consumidor">
                <label class="form-check-label" for="inlineRadio1">Consumidor</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="transportadoraSelect" value="transportadora">
                <label class="form-check-label" for="inlineRadio1">Transportadora</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="fornecedorSelect" value="fornecedor">
                <label class="form-check-label" for="inlineRadio1">Fornecedora</label>
            </div>
            <div>
            <label for="loginName" class="sr-only text-light"><h4>Email</h4></label>
            <input type="text" name="usernameLogin" id="loginName" class="form-control form-control-lg" placeholder="Nome de utilizador" autofocus="">
            </div>
            <label for="password" class="sr-only text-light"><h4>Password</h4></label>
            <input type="password" name="passwordLogin" id="password" class="form-control form-control-lg" placeholder="Password"  autofocus="">

            <button class="btn btn-lg btn-secondary btn-block mt-3" type="submit">Entrar</button>
        </div>
    </form>
</div>