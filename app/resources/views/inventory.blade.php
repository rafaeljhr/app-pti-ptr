<?php
$arrayTest = array(array("name" => "Teste nome","description" => "teste descricao" ), array("name" => "Teste nome","description" => "teste descricao" ));
Session::put('cadeiasLogisticas', $arrayTest);
?>
@extends('layouts.page_default')

@section('background')
    
<div v-show="fundoDiv" class="backgroundSee"></div>
<div v-show="fundoDiv" v-if="step==1" class="forForm">
  <button type="button" @click="openAdd()" class="btn-close" id="button-close-div"  aria-label="Close"></button>

  <form {{-- method="post" action="{{ route('product-register-controller') }}" --}}>
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
            <input class="form-control" list="datalistOptions" name="categoriaProduto" placeholder="Type to search...">
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
          <input  name="dataProduto" class="form-control" type="date" required>
        </div>
        <div class="col">
          <label for="dataProdutoValidade" class="form-label">Data de validade do produto:</label>
          <input  name="dataProdutoValidade" class="form-control" type="date" required>
        </div>
      </div>

      <div class="input-group mb-3">
      </div>
      <button @click="nextStep()" class="w-100 btn btn-lg btn-primary" type="submit">Próximo passo</button>

</div>
</form>


<div v-show="fundoDiv" v-if="step==2" class="forForm">
  <button type="button" @click="openAdd()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  
  @for($i = 0; $i < sizeOf(session()->get('cadeiasLogisticas')); $i++)
  

  <div class="card"  style="width: 18rem;">
    
    <div class="card-body">
      <h5 class="card-title"><?php echo session()->get('cadeiasLogisticas')[$i]["name"] ?></h5>
      <p class="card-text"><?php echo session()->get('cadeiasLogisticas')[$i]["description"] ?></p>
      
    </div>
  </div>
  @endfor


  {{-- <form method="post" action="{{ route('login-controller') }}">
  <h2>Cadeia logistica associada ao produto</h2>


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


    </div> --}}

    <div class="row">
      <div class="col">
        <button @click="previousStep()" class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Passo anterior</button>
      </div>
      <div class="col">
        <button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Submeter</button>
      </div>
    </div>



</div>

<button type="button" @click ="openAdd()" class="btn btn-dark" id="btn-id" >Adicionar cadeia logistica</button>
</form>
<script src="./js/inventory.js"></script>
    
@endsection

