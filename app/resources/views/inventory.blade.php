<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

//dd(session()->all());

$filtroArmazem = -1;
$filtroCat = "";

?>

<link rel="stylesheet" href="css/inventory.css">

@extends('layouts.page_default')

@section('background') 

<div id="fundoDivOpac" {{-- v-show="fundoDivOpac" --}} class="backgroundSee"></div>
<div id="apresentação" class="mx-auto mt-4 mb-4">

@if(session()->get('all_fornecedor_produtos')==null && session()->get('armazens') != null)

<div id="noProdutos">

  <div align="center">
    <img src="images/armazens.png" class="sem_bases_img" alt="">
    <br>
    <br>
    <h2>Parece que não possui nenhum produto.</h2>
    <p>Pode criar um produto nesta página usando o botão abaixo!.</p>
    <button @click ="mostrarCriarProduto()" class="btn btn-dark" id="btn-id" >Adicionar produto</button>
  </div>
  

</div>



@elseif(session()->get('armazens') == null || sizeOf(session()->get('armazens'))  == 0)

<div id="noProdutos">

  <div align="center">
    <img src="images/armazens.png" class="sem_bases_img" alt="">
    <br>
    <br>
    <h2>Parece que não possui nenhum armazém.</h2>
    <p>Armazéns são necessários para criar produtos, então crie um primeiramente.</p>
    <a id="hideAnchor" href="{{ URL::to('storage')}}">
    <button type='button' class="btn btn-success"  id="botao_criar">Criar Armazém</button>
    </a>
  </div>
  

</div>





@else


<div class="container p-0 mt-5 mb-5">
  <div class="row">
    <div class="col">
  {{-- dropdown menu para selecionar o armazem --}}
  <label for="nome_categoria" class="form-label">Filtrar por armazém</label>
  <select class="form-control" @change="filterStorage($event)" name="{{ route('product-filter') }}" id="filtroA" required>
    <option default value="reset">-- Todos os armazens --</option>
    @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++)
    <?php $category= session()->get('armazens')[$i] ?>
    <option value='<?php echo session()->get('armazens')[$i]['armazem_id'] ?>'><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></option>              
    @endfor
  </select>
</div>
<div class="col">
  <form @submit.prevent="searchCat" method = "post" action="{{ route('search-cat-controller')}}">  
  <label for="categoria" class="form-label">Pesquisar por categoria</label>
  <div class="input-group mb-3">
    <input class="form-control" name ="categoria" type="text" placeholder="Pesquise qualquer produto por categoria...">
     <div class="input-group-append">
      <button type="submit"  class="w-20 btn btn-primary" >Pesquisar</button>
    </div>
  </div>
</form>



</div>
</div>

  <div class="row w-100 mt-4 mb-4">
    <h4>Bem vindo <?php echo  session()->get('user_nome')?>!</h4>
    <div class="float-left">
      <h5>Aqui pode ver todos os produtos que se encontram associados à sua conta de momento </h5> 
    </div>
    
    

    <div class="float-right">
      <button type="submit" @click ="mostrarCriarProduto()" class="btn btn-dark" id="btn-id" >Adicionar produto</button>
      </div>

  </div>



{{-- mostrar todos os produtos --}}


  <div id='todosProdutos'>
    <form id="compareForm" method="post" action="{{ route('compare-products')}}">
      @csrf
      <button v-show="!editable" type="button" class="btn btn-long btn-success" @click="editable = true">COMPARAR PRODUTOS</button>
      <button v-show="editable" type="submit" class="btn btn-long btn-warning me-3" id="guardar_alteracoes" disabled>GUARDAR ALTERAÇÕES</button>
      <button v-show="editable" type="button" class="btn btn-long btn-primary" @click="cancelCompare()">CANCELAR ALTERAÇÕES</button>
        
    <div id="prodDisplay" class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">

      @include('apresentacao_produtos')
         
    

          
  </div>
</div>
</div>
@endif
</div>


        
  </div>






{{-- /////////////////////////////////////////////////////////////////// --}}


<div id="productForm" v-show="fundoDiv" class="forForm">
  <button type="button" @click="mostrarCriarProduto();" class="btn-close" id="button-close-div"  aria-label="Close"></button>

  {{-- Criar produto--}}
  <form method="post" action="{{ route('product-register-controller') }}" id="criar_um_produto" enctype="multipart/form-data">
    @csrf
    <h2>Informação principal do produto</h2>
      
      <div class="row" >
        <div class="col">
          <label for="nome" class="form-label">Nome do produto:</label>
          <input type="text" class="form-control"  name="nome" id="novo_produto_nome" placeholder="Nome do produto" aria-label="Username" aria-describedby="addon-wrapping" required>
        </div>

        <div class="col">
          <label for="path_imagem_produto" class="form-label">Imagem do produto:</label>
          <input type="file" class="form-control" id="novo_produto_imagem" name="path_imagem_produto" aria-label="file">
        </div>

        <div class="col">
          <label for="id_armazem" class="form-label">Armazem do produto</label>
          <select class="form-control"  name="id_armazem" id='selected_armazem' list="input-armazens" required>
            <option value="">-- Selecione o armazem do produto --</option>
            @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++)
            <option value=<?php echo session()->get('armazens')[$i]['armazem_id']?>><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></option>
            @endfor
          </select>
        </div>
      </div>

        <div class="row" >
          <div class="col">
            <label for="nome_categoria" class="form-label">Categoria do produto</label>
            <select class="form-control" @change="changeSubcat($event)" name="nome_categoria" id="novo_produto_categoria" required>
              <option value="">-- Selecione uma categoria --</option>
              @for($i = 0; $i < sizeOf(session()->get('categories')); $i++)
              <?php $category= session()->get('categories')[$i] ?>
              <option value='<?php echo session()->get('categories')[$i]['category_nome'] ?>'><?php echo session()->get('categories')[$i]['category_nome'] ?></option>              
              @endfor
            </select>
          </div>

          <div class="col">
            <input id="routeSubCat" name="{{ route('product-changeSub') }}" hidden>           
            <div id="toChangeOnCmd">
              <label for="nome_subcategoria" class="form-label">Selecione uma subcategoria</label>
            <select class="form-control" disabled name="nome_subcategoria" id="novo_produto_subcategoria" required>
                <option default value="">-- Selecione uma subcategoria --</option>
              </select>
          </div>       
          </div>

        </div>
        
      {{-- Campos extra do produto consoante a sua categoria --}}
      <div id="camposExtra"></div>

      <div class="input-group mb-3">
        <span class="input-group-text">€</span>
        <span class="input-group-text">0.00</span>
        <input type="number" step="any" class="form-control" name="preco" placeholder="Preço do seu produto" aria-label="Dollar amount (with dot and two decimal places)" id="novo_produto_preco" required>
      </div>

      <div class="row">
        <div class="col">
          <label for="data_producao_do_produto" class="form-label">Data de fabrico do produto:</label>
          <input name="data_producao_do_produto" class="form-control" type="date" id="novo_produto_data_fabrico" required>
        </div>
        
        <div class="col">
          <label for="data_insercao_no_site" class="form-label">Data de inserção no site do produto:</label>
          <input name="data_insercao_no_site" class="form-control" type="date" id="novo_produto_data_insercao" required>
        </div>
      </div>


      <div class="row">
        <div class="col">
          <label for="kwh_consumidos_por_dia" class="form-label">Kwh consumidos por dia</label>
          <input name="kwh_consumidos_por_dia" class="form-control" type="number" step="any" id="novo_produto_kwh" required>
        </div>

        <div class="col">
          <label for="quantidade" class="form-label">Quantidade de produtos</label>
          <input name="quantidade" class="form-control" type="number" step="any" id="novo_produto_quantidade" required>
        </div>
      </div>


      <div class="input-group mb-3">
        
          <div class="input-group-prepend">
            <span class="input-group-text">Informações adicionais</span>
          </div>

          <textarea name="informacoes_adicionais" class="form-control" aria-label="Informações adicionais" id="novo_produto_infos_adicionais" required></textarea>
        
      </div>

      
      <button type = "submit" class="w-100 btn btn-lg btn-primary">Criar produto</button>
  
  </form>

</div>







<div class="modal fade" id="modalApagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalApagarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <p id="fraseWarning">Tem a certeza que deseja apagar o produto</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      <form method="post" action="{{ route('product-remove')}}">
        
      @csrf
      <div id="buttonApagar"></div>
      </form>
      </div>
  </div>
  </div>
</div>



<script src="./js/inventory.js"></script>

    
@endsection

