




<div v-show="fundoDiv" class="backgroundSee"></div>


<div v-show="fundoDiv" v-if="step==1" class="forForm">
  <button type="button" @click="openAdd()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <h2>Informação principal do produto</h2>
   

    <label for="image" class="form-label">Imagem do seu produto:</label>
    <div class="input-group mb-3">       
        <input type="file" class="form-control" name="image" id="image" aria-label="file" aria-describedby="basic-addon1" required>
      </div>
      
      

        <div class="row" >
          <div class="col">
            <label for="nomeProduto" class="form-label">Imagem do seu produto:</label>
            <input type="text" class="form-control" name="nomeProduto" placeholder="Nome do produto" aria-label="Username" aria-describedby="addon-wrapping" required>
          </div>
          <div class="col">
            <label for="categoriaProduto" class="form-label">Categoria do produto</label>
            <input class="form-control" list="datalistOptions" name="categoriaProduto" placeholder="Type to search..." required>
            <datalist id="datalistOptions">
              <option value="Pão">
              <option value="Pão">
              <option value="Pão">
              <option value="Pão">
              <option value="Pão">
            </datalist>
          </div>
        </div>
        
     
      <div class="input-group mb-3">
        <span class="input-group-text">€</span>
        <span class="input-group-text">0.00</span>
        <input type="text" class="form-control" name="precoProduto" placeholder="Preço do seu produto" aria-label="Dollar amount (with dot and two decimal places)" required>
      </div>



      <div class="row">
        <div class="col">
          <label for="dataProduto" class="form-label">Data de fabrico do produto:</label>
          <input  name="dataProdutoFabrico" class="form-control" type="date" required>
        </div>
        <div class="col">
          <label for="dataProdutoValidade" class="form-label">Data de validade do produto:</label>
          <input  name="dataProdutoValidade" class="form-control" type="date" required>
        </div>
      </div>
  
      <div class="input-group mb-3">
        
         
        <span class="input-group-text">Informação adicional</span>
        <textarea class="form-control" name="infoAdicional" aria-label="With textarea"></textarea>
        
      
      </div>
      
      <button @click="nextStep()" class="w-100 btn btn-lg btn-primary" type="submit">Próximo passo</button>
      
</div>



<div v-show="fundoDiv" v-if="step==2" class="forForm">
  <button type="button" @click="openAdd()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <h3>Cadeia logistica associada ao produto</h3>
  
  <label for="image" class="form-label">Nome da cadeia</label>
  <div class="input-group mb-3">       
      <input type="text" class="form-control" name="nomeCadeia" id="image"  aria-describedby="basic-addon1" required>
    </div>
  <label for="image" class="form-label">Poluição gerada pelo produto</label>
  <div class="input-group mb-3">       
      <input type="text" class="form-control" name="poluicaoGerada" id="image" aria-describedby="basic-addon1" required>
    </div>
    

    <div class="input-group mb-3">
      
       
      <span class="input-group-text">Descrição</span>
      <textarea class="form-control" name="descricaoCadeia" aria-label="With textarea" required></textarea>
      
    
    </div>


    <h3>Recursos consumidos</h3>

    <label for="image" class="form-label">Nome do recurso</label>
  <div class="input-group mb-3">       
      <input type="text" class="form-control" name="nomeRecurso" id="image"  aria-describedby="basic-addon1" required>
    </div>
  <label for="image" class="form-label">Qauntidade:</label>
  <div class="input-group mb-3">       
      <input type="text" class="form-control" name="quantidadeRecurso" id="image" aria-describedby="basic-addon1" required>
    </div>

    <div class="row">
      <div class="col">
        <button @click="previousStep()" class="w-100 btn btn-lg btn-primary" type="submit">Passo anterior</button>
      </div>
      <div class="col">
        <button class="w-100 btn btn-lg btn-primary" type="submit">Submeter</button>
      </div>
    </div>
    
    
    
</div>

<button type="button" @click ="openAdd()" class="btn btn-dark" id="btn-id" >Adicionar produto</button>
<script src="./js/inventory.js"></script>

