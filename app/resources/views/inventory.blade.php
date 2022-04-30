<?php

// dd(session()->all());

$arrayTestCadeia = array(array("name" => "Teste nome","description" => "teste descricao" ), array("name" => "Teste nome","description" => "teste descricao" ), array("name" => "Teste nome","description" => "teste descricao" ), array("name" => "Teste nome","description" => "teste descricao" ));
Session::put('cadeiasLogisticas', $arrayTestCadeia);


// $armazens = array(array("aaa", "teste", "teste", "testeNome" ), array("aaa", "teste", "teste", "testeNome" ), array("aaa", "teste", "teste", "testeNome" ), array("aaa", "teste", "teste", "testeNome" ));
// Session::put('armazens', $armazens);
// ISTO JA TA OK, BASTA CRIAR ARMAZENS E JA IRAO APARECER NA CRIACAO DE PRODUTOS


// $produtos = array(array("images/teste.jpg", "nome teste", "50",  "descricao teste"),
// array("images/teste.jpg", "nome teste", "50",  "descricao teste"),
// array("images/teste.jpg", "nome teste", "50",  "descricao teste"),
// array("images/teste.jpg", "nome teste", "50",  "descricao teste"),  
// array("images/teste.jpg", "nome teste", "50",  "descricao teste"));
// Session::put('produtos', $produtos);
// ISTO JA TA OK, BASTA CRIAR PRODUTOS E JA IRAO APARECER

?>
@extends('layouts.page_default')

@section('background')
<?php $passo= session()->get('passo') ?>    

<div v-show="fundoDivOpac" class="backgroundSee"></div>

<div v-show="fundoDiv" v-if="step == 1" class="forForm">
  <button type="button" @click="openAdd()" class="btn-close" id="button-close-div"  aria-label="Close"></button>

  {{-- Criar produto--}}
  <form id="productForm" enctype="multipart/form-data">
    @csrf
    <h2>Informação principal do produto</h2>
      
      <div class="row" >
        <div class="col">
          <label for="nome" class="form-label">Nome do seu produto:</label>
          <input type="text" ref="nome" class="form-control"  name="nome" placeholder="Nome do produto" aria-label="Username" aria-describedby="addon-wrapping" required>
        </div>

        <div class="col">
          <label for="path_imagem_produto" class="form-label">Imagem do seu produto:</label>
          <input type="file" ref="imagem" class="form-control"  name="path_imagem_produto" id="image" aria-label="file">
        </div>

        <div class="col">
          <label for="id_armazem" class="form-label">Armazem do produto</label>
          <select ref="armazem" class="form-control"  name="id_armazem" id='selected_armazem' list="input-armazens" placeholder="Type to search...">
            <option selected="selected">Selecione o armazem do produto</option>
            @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++)
            <option value=<?php echo session()->get('armazens')[$i]['armazem_id']?>><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></option>
            @endfor
          </select>
        </div>
      </div>

        <div class="row" >
          <div class="col">
            <label for="nome_categoria" class="form-label">Categoria do produto</label>
            <select ref="categoria" class="form-control"  @change="changeSubcat($event)" name="nome_categoria">
              <option selected>Selecione uma categoria</option>
              @for($i = 0; $i < sizeOf(session()->get('categories')); $i++)
              <?php $category= session()->get('categories')[$i] ?>
              <option value='<?php echo session()->get('categories')[$i]['category_nome'] ?>'><?php echo session()->get('categories')[$i]['category_nome'] ?></option>              
              @endfor
            </select>
          </div>

          <div class="col">
            <label for="nome_categoria" class="form-label">Subcategoria</label>
            <select ref="subcategoria" class="form-control"  name="nome_subcategoria">
              <option selected>Selecione uma subcategoria</option>             
              @for($i = 0; $i < sizeOf(session()->get('subcategories')); $i++)
              <?php $subcategory= session()->get('subcategories')[$i]['subcategory_nome_categoria'] ?>
              @if($subcategory=="mobilidade")
              <option v-if="mobilidade" value='<?php echo session()->get('subcategories')[$i]['subcategory_nome'] ?>'><?php echo session()->get('subcategories')[$i]['subcategory_nome'] ?></option>
              @endif
              @if($subcategory=="computadores")
              <option v-if="computadores" value='<?php echo session()->get('subcategories')[$i]['subcategory_nome'] ?>'><?php echo session()->get('subcategories')[$i]['subcategory_nome'] ?></option>
              @endif
              @if($subcategory=="componentes")
              <option v-if="componentes" value='<?php echo session()->get('subcategories')[$i]['subcategory_nome'] ?>'><?php echo session()->get('subcategories')[$i]['subcategory_nome'] ?></option>
              @endif 
              @if($subcategory=="periféricos")
              <option v-if="perifericos" value='<?php echo session()->get('subcategories')[$i]['subcategory_nome'] ?>'><?php echo session()->get('subcategories')[$i]['subcategory_nome'] ?></option>
              @endif              
              @endfor               
            </select>         
          </div>

        </div>

      <div class="input-group mb-3">
        <span class="input-group-text">€</span>
        <span class="input-group-text">0.00</span>
        <input type="number" ref="preco" step="any" class="form-control"  name="preco" placeholder="Preço do seu produto" aria-label="Dollar amount (with dot and two decimal places)" required>
      </div>

      <div class="row">
        <div class="col">
          <label for="data_producao_do_produto" class="form-label">Data de fabrico do produto:</label>
          <input ref="dataFabrico" name="data_producao_do_produto" class="form-control" type="date" required>
        </div>
        
        <div class="col">
          <label for="data_insercao_no_site" class="form-label">Data de inserção no site do produto:</label>
          <input ref="dataEntrada" name="data_insercao_no_site" class="form-control" type="date" required>
        </div>
      </div>


      <div class="row">
        <div class="col">
          <label for="kwh_consumidos_por_dia" class="form-label">Kwh consumidos por dia</label>
          <input ref="kwh" name="kwh_consumidos_por_dia" class="form-control" type="number" step="any" required>
        </div>

        <div class="col">
          <label for="quantidade" class="form-label">Quantidade que deseja criar</label>
          <input ref="quant" name="quantidade" class="form-control" type="number" step="any" required>
        </div>
      </div>


      <div class="input-group mb-3">
        
          <div class="input-group-prepend">
            <span class="input-group-text">With textarea</span>
          </div>

          <textarea ref="info" name="informacoes_adicionais" class="form-control" aria-label="With textarea"></textarea>
        
      </div>

      <button class="w-100 btn btn-lg btn-primary" @click="createProduct()" type="submit">Próximo passo</button>
  
  </form>

</div>


{{-- div para apresentar as cadeias logisticas associadas ao  produto acabado de criar e poder criar mais--}}

<div v-show="fundoDiv" v-if="step == 2" class="forForm">
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
        <form method="post" action="{{ route('product-remove-last-added')}}">
          @csrf
        <button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Passo anterior</button>
        </form>
      </div>
     
    </div>
</div>


{{-- div para adicionar cadeia logistica --}}
<div v-show="cadeiaDiv" class="cadeiaLogistica">
<button type="button" @click="openCadeia()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
<form>
@csrf
  <h3>Cadeia logistica associada ao produto</h3>
  <label for="image" class="form-label">Nome da cadeia</label>
  <div class="input-group mb-3">  
  <input type="text" class="form-control" name="nomeCadeia" id="image"  aria-describedby="basic-addon1" required>
    </div>
  
    <label for="co2_produzido" class="form-label">CO2 gerado pelo produto</label>
    <div class="input-group mb-3">       
        <input type="number" min="0" step  ="any" class="form-control" name="co2_produzido" id="co2_produzido" aria-describedby="basic-addon1" required>
      </div>
      <label for="kwh_consumidos" class="form-label">KWh consumidos por dia</label>
    <div class="input-group mb-3">       
        <input type="number"  min="0" step ="any" class="form-control" name="kwh_consumidos" id="kwh_consumidos" aria-describedby="basic-addon1" required>
      </div>
  <div class="input-group mb-3"> 
    <span class="input-group-text">Descrição</span>
    <textarea class="form-control" name="descricaoCadeia" aria-label="With textarea" required></textarea>
    
  
  </div>


<button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Submeter</button>
</form>
</div>



{{-- div para apresentar armazens  e criar  novos --}}
<div v-show="armazemDiv" class="forForm">
  <button type="button" @click="openAddArmazem()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <h3>Os seus armazens:</h3>
  <div class="row">
  @if(session()->get('armazens')!=null)
  @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++) 
    <div class="col">
      <div class="card"  style="width: 18rem;"> 
        <div class="card-body">
          <h5 class="card-title"><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></h5>
          <img src='<?php echo session()->get('armazens')[$i]['armazem_path_imagem'] ?>' class="card-img-top" alt="...">
          <p class="card-text"><?php echo session()->get('armazens')[$i]['armazem_morada'] ?></p>         
        </div>
      </div>
    </div>

  @if($i > 0 && $i % 3==0)
  <?php echo '</div>' ?>
  <?php echo '<div class="row">' ?>
  @endif
  
  @endfor
  
  @endif
  <button type="button" @click="openArmazem()" class="btn btn-primary" id="addCadeia">+</button>
  </div>
</div>


{{-- criar armazem --}}
<div v-show="armazemAddDiv" class="cadeiaLogistica">
  <button type="button" @click="openArmazem()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <form method="post" action="{{ route('armazem-register-controller')}}" enctype="multipart/form-data">
    @csrf
    <h3>Armazem:</h3>
    <label for="nome" class="form-label">Nome</label>
    <div class="input-group mb-3">  
    <input type="text" class="form-control" name="nome" id="morada"  aria-describedby="basic-addon1" required>
    </div>

    <label for="image" class="form-label">Imagem do seu armazém:</label>
    <div class="input-group mb-3">       
        <input type="file" class="form-control" name="path_imagem_armazem" id="image" aria-label="file" aria-describedby="basic-addon1">
      </div>
    <label for="morada" class="form-label">Morada do armazém</label>
    <div class="input-group mb-3">  
    <input type="text" class="form-control" name="morada" id="morada"  aria-describedby="basic-addon1" required>
      </div>
    
  
  <button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Submeter</button>
  </form>
  </div>


<div class="dropdown" id="">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    Filtrar por armazem
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="#">Todos</a></li>
    @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++)
    
    <li><a class="dropdown-item" href="#"><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></a></li>
    @endfor

  </ul>
</div>

<button type="submit"  @click ="openAdd()" class="btn btn-dark" id="btn-id" >Adicionar produto</button>

<button type="button" @click ="openAddArmazem()" class="btn btn-dark" id="btn-id" >Criar armazens</button>


<div class="container p-0 mt-5 mb-5">
  <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
  @if(session()->get('all_fornecedor_produtos')!=null)
  @for($i = 0; $i < sizeOf(session()->get('all_fornecedor_produtos')); $i++) 
  
    <div class="col">
      <div class="card">
        <button type="button" class="btn-close" id="button-close-div"  aria-label="Close"></button>
        <h5 class="card-title"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_nome'] ?></h5>
          <h4 class="card-text text-danger"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_preco'] ?> €</h4>
        <img src='<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_path_imagem'] ?>' class="card-img-top" alt="...">
        <div class="card-body text-center">
          <h5 class="card-title"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_informacoes_adicionais'] ?></h5>
          <button type="button" class="btn btn-outline-primary">Editar</button>
          <button type="button" class="btn btn-outline-primary">informações adicionais</button>
        </div>
      </div>
    </div>
    @if($i > 0 && $i % 3==0)
    </div>
    <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
    @endif
    @endfor


    @endif
  </div>
</div>
{{-- 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

<script>
$('#productForm').on('submit',function(e){
  e.preventDefault();

  let nome = $('#nome').val();
  let path_imagem_produto = $('#path_imagem_produto').val();
  let id_armazem = $('#id_armazem').val();
  let nome_categoria = $('#nome_categoria').val();
  let nome_subcategoria = $('#nome_subcategoria').val();
  let preco = $('#preco').val();
  let data_producao_do_produto = $('#data_producao_do_produto').val();
  let data_insercao_no_site = $('#data_insercao_no_site').val();
  let kwh_consumidos_por_dia = $('#kwh_consumidos_por_dia').val();
  let quantidade = $('#quantidade').val();
  let informacoes_adicionais = $('#informacoes_adicionais').val();


  $.ajax({
    url: "/product-register-controller",
    type:"POST",
    data:{
      "_token": "{{ csrf_token() }}",
      nome:nome,
      path_imagem_produto:path_imagem_produto,
      id_armazem:id_armazem,
      nome_categoria:nome_categoria,
      nome_subcategoria:nome_subcategoria,
      preco:preco,
      data_producao_do_produto:data_producao_do_produto,
      data_insercao_no_site:data_insercao_no_site,
      kwh_consumidos_por_dia:kwh_consumidos_por_dia,
      quantidade:quantidade,
      informacoes_adicionais:informacoes_adicionais,
    },
    success:function(response){
      console.log(response);
      if (response) {
        $('#success-message').text(response.success); 
        
      }
    },
    error: function(response) {
      $('#nome-error').text(response.responseJSON.errors.nome);
     
     }
   });
  });
  
  </script> --}}
<script src="./js/inventory.js"></script>
    
@endsection

