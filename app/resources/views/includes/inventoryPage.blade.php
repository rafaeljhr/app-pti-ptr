




<div v-show="fundoDiv" class="backgroundSee"></div>


<div v-show="fundoDiv" class="forForm">
    <button type="button" @click="openAdd()" class="btn-close" id="button-close-div"  aria-label="Close"></button>

    <label for="image" class="form-label">Imagem do seu produto:</label>
    <div class="input-group mb-3">       
        <input type="file" class="form-control" name="image" id="image" aria-label="file" aria-describedby="basic-addon1" required>
      </div>
      
      <div class="input-group mb-3">
        <span class="input-group-text" id="addon-wrapping">Name</span>
        <input type="text" class="form-control" name="nomeProduto" placeholder="Nome do produto" aria-label="Username" aria-describedby="addon-wrapping" required>
      </div>  
      <div class="input-group mb-3">
        <span class="input-group-text">£</span>
        <span class="input-group-text">0.00</span>
        <input type="text" class="form-control" name="precoProduto" placeholder="Preço do seu produto" aria-label="Dollar amount (with dot and two decimal places)" required>
      </div>

      <label for="image" class="form-label">Data de fabrico do produto:</label>
      <div class="input-group mb-3">
        
         
        <input  name="dataProduto" class="form-control" type="date" required>
        
      
      </div>

      <div class="input-group mb-3">
        
         
        <span class="input-group-text">Informação adicional</span>
        <textarea class="form-control" aria-label="With textarea"></textarea>
        
      
      </div>
      
      <button class="w-100 btn btn-lg btn-primary" type="submit">Submeter</button>
      
</div>

<button type="button" @click ="openAdd()" class="btn btn-dark" id="btn-id" >Adicionar produto</button>
<script src="./js/inventory.js"></script>

