<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

//dd(session()->all());

//session()->forget('produto_cadeia_logistica');

?>

<link rel="stylesheet" href="css/inventory.css">

@extends('layouts.page_default')

@section('background') 

<div id="fundoDivOpac" v-show="fundoDivOpac" class="backgroundSee"></div>
<p class="lead">
  Bem vindo à sua área de produtos <?php echo session()->get('user_nome')?>!
</p>

@if(sizeOf(session()->get('armazens'))  == 0)
<p>Não possui nenhum armazém associado à sua conta logo não pode criar produtos!</p>
<p>Diriga-se à página dos armazens onde poderá criar um ou mais</p>
@endif



{{-- dropdown menu para selecionar o armazem --}}
<label for="nome_categoria" class="form-label">Filtrar por armazém</label>
<select class="form-control" @change="filterStorage($event)" name="{{ route('product-filter') }}" id="filtroA" required>
  <option default value="reset">-- Todos os produtos --</option>
  @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++)
  <?php $category= session()->get('armazens')[$i] ?>
  <option value='<?php echo session()->get('armazens')[$i]['armazem_id'] ?>'><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></option>              
  @endfor
</select>

@if(sizeOf(session()->get('armazens'))  >  0)
<button type="submit"  @click ="mostrarCriarProduto()" class="btn btn-dark" id="btn-id" >Adicionar produto</button>
@else

<button type="submit"  @click ="mostrarCriarProduto()" disabled class="btn btn-dark" id="btn-id" >Adicionar produto</button>

@endif



{{-- mostrar todos os produtos --}}
<div class="container p-0 mt-5 mb-5">
  <div id='todosProdutos'>

    <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">

      @if(session()->get('all_fornecedor_produtos')!=null)
        @for($i = 0; $i < sizeOf(session()->get('all_fornecedor_produtos')); $i++) 
        <?php
        $comCadeia = 0;
        $id  = session()->get('all_fornecedor_produtos')[$i]['produto_id'];
        if(session()->get('produto_cadeia_logistica')  !=  null)
          for($c = 0; $c < sizeOf(session()->get('produto_cadeia_logistica')); $c++)
            if($id == session()->get('produto_cadeia_logistica')[$c]['evento_id_produto']) 
              $comCadeia = 1;
        ?>
        
          <div class="col">
            <div class="card">
              <img src='<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_path_imagem'] ?>' class="imagemProduto card-img-top" alt="...">
              <h5 class="card-title mt-3 text-center"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_nome'] ?></h5>
              <h4 class="card-text text-center"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_preco'] ?> €</h4>
              
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_informacoes_adicionais'] ?></h5>
                @if($comCadeia == 0)
                <p>Este produto não possui cadeias logisticas</p>
                <img src="images/warning.png" class="warning card-img-top" alt="...">
                @endif
                <button type="button" id="showProductInfo"  class="btn btn-outline-primary">Ver informações do produto</button>
                <br>
                
                <a id="hideAnchor" href="{{ URL::to('produto/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
                <button type="button" id="addCadeia" class="btn btn-outline-primary">Adicionar cadeias</button>
                </a>
                <br>
                <button type="button" id='buttonApagarProdutoWarning' name="{{ route('product-delete-warning')}}" onclick="deleteWarning('<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_id'] ?>','<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_nome'] ?>')" data-bs-toggle="modal" data-bs-target="#modalApagar" class="btn btn-outline-danger">Apagar</button>
                
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
              <label for="nome_subcategoria" class="form-label">Selecione uma categoria</label>
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



<div id="infoAdicional" >
  <button type="button" @click="hideShowInfoProduct()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
 <div class="row">
   <div class="col">
  <h3>O armazém:</h3>

  <div id="produtoArmazens"></div>
 
  
  <h3>As suas cadeias Logisticas</h3>
  <div id="produtoCadeias"></div></div>


  <h4>Informação principal do produto</h4>
<div class="col" id="descriptionGeral"></div>

</div>

  
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

