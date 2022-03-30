<div class="container py-5">

    <div class="form-div mx-auto my-2 px-3">  

        <img class="logo" src="images/logo4.png" alt="EcoSmart Logo">

        <h1 class="h3 mb-4 font-weight-normal">Junte-se ao grupo EcoSmart!</h1>

        <h2 class="h4 mb-2 font-weight-normal text-light">Eu sou um/a:</h2>
        
        <form class="form-signin" method="post" action="{{ route('register-controller') }}">
            @csrf
            <div class="form-group row px-3">
                <select @change="switchSelect($event)" class="form-select" name="selectedOption" aria-label="Tipo de Utilizador">
                    <option selected value="consumidor">Consumidor</option>
                    <option value="transportadora">Transportadora</option>
                    <option value="fornecedor">Fornecedora</option>
                </select>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="nome" class="sr-only text-light">Nome</label>
                        <input required type="text" name ="name" id="name" class="form-control form-control-sm mb-2" placeholder="Introduza o seu nome">
                    </div>
                    <div class="col">
                        <label for="email" class="sr-only text-light">Email</label>
                        <input required type="email" name ="email" id="email" class="form-control form-control-sm mb-2" placeholder="Introduz o seu email">
                    </div>                    
                </div>

                <div class="row">
                    <div class="col">
                        <label for="phone_number" class="sr-only text-light">Telemóvel</label>
                        <input required type="text" name ="phone_number" id="phone_number" class="form-control form-control-sm mb-2" placeholder="Introduza o seu número" minlength="9" maxlength="9">
                    </div>
                    
                    <div class="col">
                        <label v-if="clientConsumer" for="nif" class="sr-only text-light">NIF</label>
                        <label v-else for="nif" class="sr-only text-light">NIF da Empresa</label>
                        <input required type="text" name ="nif" id="nif" class="form-control form-control-sm mb-2" placeholder="Introduza o seu NIF" minlength="9" maxlength="9">
                    </div>                 
                </div>
                
                <div class="row form-group">
                    <div class="col">
                        <label v-if="clientConsumer" for="address" class="sr-only text-light">Morada</label>
                        <label v-else for="address" class="sr-only text-light">Morada Fiscal</label>
                        <input required type="text" name ="address" id="address" class="form-control form-control-sm mb-2" placeholder="Introduza a sua morada" maxlength="200">
                    </div>
                    <div class="col">
                        <label for="password" class="sr-only text-light">Password</label>
                        <input required type="password" name ="password" id="password" class="form-control form-control-sm mb-2" placeholder="Introduza a sua password">
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
