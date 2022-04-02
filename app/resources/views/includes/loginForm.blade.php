<div class="container py-5">
    <form class="form-signin" method="post" action="{{ route('login-controller') }}">
        @csrf
        
        <div class="limit-width mx-auto">  
            <img class="logo" src="images/logo4.png" alt="EcoSmart Logo">

            <h1 class="h3 mb-2 font-weight-normal">Autentique-se para usufruir  de todas as funcionalidades!</h1>


            <div class="form-group row">
                <select class="form-select" name="selectedOption" aria-label="Default select example">
                    <option selected value="consumidor">Consumidor</option>
                    <option value="transportadora">Transportadora</option>
                    <option value="fornecedor">Fornecedora</option>
                </select>
            </div>

            

            <div class="form-group row">
                



                <label for="loginName" class="col-sm-2 col-form-label"><h6 class="form-label">Email</h3></label>
                <div class="col-sm-10">
                  <div class="input-group">
                  <div class="input-group-text">@</div>
                  <input type="text" name ="usernameLogin" class="form-control" id="loginName" placeholder="Nome de utilizador">
                  </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="loginName" class="col-sm-2 col-form-label"><h6 class="form-label">Password</h3></label>
                <div class="col-sm-10">
                  <input type="password" name ="passwordLogin" class="form-control" id="password" placeholder="Password">
                </div>
            </div>

            
            

            <button class="btn btn-lg btn-secondary btn-block mt-3" type="submit">Entrar</button>
        </div>
    </form>
</div>