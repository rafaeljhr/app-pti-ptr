<div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">
          <div class="col-lg-7 text-center text-lg-start">
            <img src="images/logo5.png" width="700" alt="">
            <p class="col-lg-10 fs-4">Bem-vindo à loja mais saudável. A EcoSmart Store permite-te comprar aquilo que tu quiseres, 
              considerando todos os custos associados. A saúde do planeta é muito importante!
            </p>
          </div>
          <div class="col-md-10 mx-auto col-lg-5" method="post" action="{{ route('login-controller') }}">
            <form class="p-4 p-md-5 border rounded-3 bg-light">
              <h1 class="h3 mb-2 font-weight-normal">Autentique-se para usufruir  de todas as funcionalidades da EcoSmart Store!</h1>
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

              <div class="form-floating mb-3">
                <input type="text" name="usernameLogin" id="loginName" class="form-control"  placeholder="Nome de utilizador">
                <label for="loginName">Nome de utilizador</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" name="passwordLogin" id="password" placeholder="Palavra-passe" autofocus="">
                <label for="password" >Palavra-passe</label>
              </div>
              <div class="checkbox mb-3">
                <label>
                  <input type="checkbox" value="remember-me"> Lembrar-me
                </label>
              </div>
              <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
              <hr class="my-4">
              
            </form>
          </div>
        </div>
      </div>