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
    <a id="hideAnchor" href="{{ URL::to('/prodCreate')}}">
      <button type="submit" class="btn btn-dark" id="btn-id">Adicionar produto</button>
    </a>
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
    <h4>Bem vindo <?php echo session()->get('user_nome')?>!</h4>
    <div class="float-left">
      <h5>Aqui pode ver todos os produtos que se encontram associados à sua conta de momento </h5> 
    </div>
    
    

    <div class="float-right">
      <a id="hideAnchor" href="{{ URL::to('/prodCreate')}}">
                    
        <button type="submit" class="btn btn-dark" id="btn-id" >Adicionar produto</button>
      </a>
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

