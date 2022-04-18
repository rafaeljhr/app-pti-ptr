<?php

//dd(session()->all());

$arrayTestCadeia = array(array("name" => "Teste nome","description" => "teste descricao" ), array("name" => "Teste nome","description" => "teste descricao" ), array("name" => "Teste nome","description" => "teste descricao" ), array("name" => "Teste nome","description" => "teste descricao" ));
Session::put('cadeiasLogisticas', $arrayTestCadeia);
$arrayTestArmazem = array(array("morada" => "Teste  morada","recursos" => "teste recursos" ), array("morada" => "Teste morada","recursos" => "teste recursos" ), array("morada" => "Teste morada","recursos" => "teste recursos" ), array("morada" => "Teste morada","recursos" => "teste recursos" ));
Session::put('armazensFornecedor', $arrayTestArmazem);
?>
@extends('layouts.page_default')

@section('background')
    
<div v-show="fundoDivOpac" class="backgroundSee"></div>
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
          <label for="nome" class="form-label">Nome do seu produto:</label>
          <input type="text" class="form-control" name="nome" placeholder="Nome do produto" aria-label="Username" aria-describedby="addon-wrapping" required>
        </div>
        <div class="col">
          <label for="armazem" class="form-label">Armazem do produto</label>
          <input class="form-control" list="datalistOptions" name="armazem" placeholder="Type to search...">
          <datalist id="datalistOptions">
            @for($i = 0; $i < sizeOf(session()->get('armazensFornecedor')); $i++)
            <option value='<?php echo session()->get('armazensFornecedor')[$i]["recursos"] ?>'>
            @endfor
          </datalist>
            
        
        </div>
      </div>

        <div class="row" >
          <div class="col">
            <label for="nome_categoria" class="form-label">Categoria do produto</label>
            <select class="form-control" name="categoria">
              
              @for($i = 0; $i < sizeOf(session()->get('categories')); $i++)
              <?php $category= session()->get('categories')[$i] ?>
              <option @click="changeSubcat('$category')" value='<?php echo session()->get('categories')[$i] ?>'><?php echo session()->get('categories')[$i] ?></option>
              
              @endfor
            </select>
           <?php /* echo "@click=changeSubcat('$category')" */?> 
          </div>
          <div class="col">
            <label for="nome_categoria" class="form-label">Subcategoria</label>
            <select class="form-control" name="subcategoria">
              <option selected>Selecione uma categoria</option>
              @if(session()->get('subcategoriesSelect') !=  null)
              @for($i = 0; $i < sizeOf(session()->get('subcategoriesSelect')); $i++)
              <?php $subcategory= session()->get('subcategoriesSelect')[$i][1] ?>
              <option v-if="category={{$subcategory}}" value='<?php echo session()->get('subcategoriesSelect')[$i][0] ?>'><?php echo session()->get('subcategoriesSelect')[$i][0] ?></option>
              @endfor
              @endif
              
              
              
            </select> 
          
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

{{-- div para apresentar as cadeias logisticas associadas ao  produto acabado de criar e poder criar mais--}}
<div v-show="fundoDiv" v-if="step==2" class="forForm">
  <button type="button" @click="openAdd()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <h3>As cadeias logisticas associadas ao produto</h3>
  <div class="row">
  @for($i = 0; $i < sizeOf(session()->get('cadeiasLogisticas')); $i++)  
    <div class="col">
      <div class="card"  style="width: 18rem;"> 
        <div class="card-body">
          <h5 class="card-title"><?php echo session()->get('cadeiasLogisticas')[$i]["name"] ?></h5>
          <p class="card-text"><?php echo session()->get('cadeiasLogisticas')[$i]["description"] ?></p>         
        </div>
      </div>
    </div>

  @if($i > 0 && $i % 3==0)
  <?php echo '</div>' ?>
  <?php echo '<div class="row">' ?>
  @endif
  
  @endfor
  <button type="button" @click="openCadeia()" class="btn btn-primary" id="addCadeia">+</button>
  </div>


    <div class="row">
      <div class="col">
        <button @click="previousStep()" class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Passo anterior</button>
      </div>
      <div class="col">
        <button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Submeter</button>
      </div>
    </div>



</div>


{{-- div para adicionar cadeia logistica --}}
<div v-show="cadeiaDiv" class="cadeiaLogistica">
<button type="button" @click="openCadeia()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
<form>
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
<label for="image" class="form-label">Quantidade:</label>
<div class="input-group mb-3">       
  <input type="text" class="form-control" name="quantidadeRecurso" id="image" aria-describedby="basic-addon1" required>
</div>


<button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Submeter</button>
</form>
</div>


{{-- div para apresentar armzens  e criar  novos --}}
<div v-show="armazemDiv" class="forForm">
  <button type="button" @click="openAddArmazem()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <h3>Os seus armazens:</h3>
  <div class="row">
  @for($i = 0; $i < sizeOf(session()->get('armazensFornecedor')); $i++)
    
    <div class="col">
      <div class="card"  style="width: 18rem;"> 
        <div class="card-body">
          <h5 class="card-title"><?php echo session()->get('armazensFornecedor')[$i]["morada"] ?></h5>
          <p class="card-text"><?php echo session()->get('armazensFornecedor')[$i]["recursos"] ?></p>         
        </div>
      </div>
    </div>

  @if($i > 0 && $i % 3==0)
  <?php echo '</div>' ?>
  <?php echo '<div class="row">' ?>
  @endif
  
  @endfor
  <button type="button" @click="openArmazem()" class="btn btn-primary" id="addCadeia">+</button>
  </div>


</div>

<div v-show="armazemAddDiv" class="cadeiaLogistica">
  <button type="button" @click="openArmazem()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <form>
    <h3>Armazem:</h3>
    <label for="morada" class="form-label">Morada do armazém</label>
    <div class="input-group mb-3">  
    <input type="text" class="form-control" name="moradaArmazem" id="morada"  aria-describedby="basic-addon1" required>
      </div>
    <label for="image" class="form-label">Recursos consumidos diariamente pelo armazem</label>
    <div class="input-group mb-3">       
        <input type="text" class="form-control" name="recursosArmazem" id="image" aria-describedby="basic-addon1" required>
      </div> 
  
  <button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Submeter</button>
  </form>
  </div>





<button type="button" @click ="openAdd()" class="btn btn-dark" id="btn-id" >Adicionar produto</button>
<button type="button" @click ="openAddArmazem()" class="btn btn-dark" id="btn-id" >Criar armazens</button>

<script src="./js/inventory.js"></script>
    
@endsection

