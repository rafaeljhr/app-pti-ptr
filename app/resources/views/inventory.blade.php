<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="css/inventory.css">
</head>

<?php
//dd(session()->all());
?>


@extends('layouts.page_default')

@section('background') 

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

    <div class="row w-100 mt-4 mb-4">

      <div class="col">
        <h1>Os seus produtos</h1>
      </div>
      <div class="col-auto">
        <a id="hideAnchor" href="{{ URL::to('/prodCreate')}}">
          <button class="btn btn-success" id="botao_criar">Criar produto</button>
        </a>
      </div>
      
    </div>



  {{-- MOSTRAR PRODUTOS --}}

    <div id='todosProdutos'>
      <form id="compareForm" method="post" action="{{ route('compare-products')}}">
        @csrf

        <button v-show="!editable" type="button" class="btn btn-long btn-success" @click="editable = true">COMPARAR PRODUTOS</button>
        <button v-show="editable" type="submit" class="btn btn-long btn-warning me-3" id="guardar_alteracoes" disabled>FAZER COMPARAÇÃO</button>
        <button v-show="editable" type="button" class="btn btn-long btn-primary" @click="cancelCompare()">CANCELAR COMPARAÇÃO</button>
          
        <div id="prodDisplay" class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">

          @for($i = 0; $i < sizeOf(session()->get('all_fornecedor_produtos')); $i++) 
        
            <div>
              <div class="col">
                <div class="card">

                  @if(!file_exists(session()->get('all_fornecedor_produtos')[$i]['produto_path_imagem']))
                    <a href="{{ URL::to('produtosEdit/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
                      <img src="images/default_produto.jpg" class="imagemProduto card-img-top">
                    </a>
                  @else
                    <a href="{{ URL::to('produtosEdit/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
                      <img src="<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_path_imagem'] ?>" class="imagemProduto card-img-top">
                    </a>
                  @endif

                  <h5 class="card-title mt-3 text-center"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_nome'] ?></h5>
                  <h4 class="card-text text-center"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_preco'] ?> €</h4>
                  
                  <div class="card-body text-center">
                    
                    <a id="hideAnchor" href="{{ URL::to('cadeias/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
                      <button type="button" id="addCadeia" class="btn btn-info botao_cadeia">Cadeia Logística</button>
                    </a>

                  </div>

                </div>
              </div>
            </div>

            @if($i > 0 && $i % 3==0)
              </div>
              <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
            @endif

          @endfor

        </div>
    </div>

  </div>

@endif

<script src="./js/inventory.js"></script>
    
@endsection

