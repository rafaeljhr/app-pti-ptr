<link rel="stylesheet" href="css/page_default.css">
<link rel="stylesheet" href="bootstrap.min.css">


    <section class="h-100">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
              <div class="card card-registration my-4">
                <div class="row g-0">
                  <div class="col-xl-6 d-none d-xl-block">
                    <img src="images/registar2.jpg" class="img-fluid" style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;"/>
                  </div>
                  <div class="col-xl-6">
                    <div class="card-body p-md-5 text-black">
                      <h3 class="mb-5 text-uppercase">JUNTA-TE AO GRUPO ECOSMART!</h3>
                      <h2 class="h4 mb-2 font-weight-normal">Eu sou um/a:</h2>

                      <form v-show="clienteConsumidor" class="form-signin" method="post" action="{{ route('register-controller') }}">
                        @csrf
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
                            <input required type="text" name ="name" id="name" class="form-control form-control-lg" placeholder="Introduza o seu nome">
                          </div>
                        </div>
        
                        <div class="row">
                          <div class="col-md-6 mb-4">
                            <div class="form-outline">
                              <label for="phone_number" class="form-label">Telemóvel</label>
                              <input required type="text" name ="phone_number" id="phone_number" class="form-control form-control-lg" placeholder="Introduza o seu número" minlength="9" maxlength="9">
                            </div>
                          </div>
                          <div class="col-md-6 mb-4">
                            <div class="form-outline">
                              <label v-if="clientConsumer" for="nif" class="form-label">NIF</label>
                              <label v-else for="nif" class="form-label">NIF da Empresa</label>
                              <input required type="text" name ="nif" id="nif" class="form-control form-control-lg" placeholder="Introduza o seu NIF" minlength="9" maxlength="9">
                            </div>
                          </div>
                        </div>
      
                        <div class="form-outline mb-4">
                           <label v-if="clientConsumer" for="address" class="form-label">Morada</label>
                           <label v-else for="address" class="form-label">Morada Fiscal</label>  
                           <input required type="text" id="address" name="address" class="form-control form-control-lg" placeholder="Introduza a sua morada" autofocus="">  
                        </div>
  
                        <div class="form-outline mb-4">
                          <label for="email" class="form-label">Email</label>
                          <input required type="email" name ="email" id="email" class="form-control form-control-lg" placeholder="Introduz o seu email">
                        </div>
  
                        <div class="row">
                          <div class="form-outline mb-4">
                            <label for="passwordConsumer" class="form-label">Password</label>
                            <input type="password" id="password" name ="password" class="form-control form-control-lg" placeholder="Introduza a sua password" required autofocus="">
                          </div>
                        </div>

                        <div class="row">
                          <button type="button" id="ola" class="btn btn-primary btn-lg btn-block">Registar</button>
                        </div>
                        
                      </form>
                      

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

<!-- <script>
    let app = Vue.createApp({
        data: function() {
            return {
                clientConsumer: true
            }
        },
        methods: {
            switchSelect(event) {
                if (event.target.value == "consumidor") {
                    this.clientConsumer = true;
                } else {
                    this.clientConsumer = false;
                }
            }
        }
    })

    app.mount('.app')
</script>
 -->