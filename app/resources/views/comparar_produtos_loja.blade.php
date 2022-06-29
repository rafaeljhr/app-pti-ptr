<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="css/inventory.css">
    <link rel="stylesheet" href="css/comparar_produtos.css">
  </head>
  
  <?php
  //dd(session()->all());
  ?>
  
  
  @extends('layouts.page_default')
  
  @section('background') 
  
  @if(sizeOf(session()->get('produtos_comparar')) <=0)
  
    <div id="noProdutos">
  
      <div align="center">
        <img src="images/armazens.png" class="sem_produtos_img">
        <br>
        <br>
        <h2>Parece que não existem em loja produtos desta categoria!</h2>
        
      </div>
      
    
    </div>
  
  @else
  
    <div class="container p-0 mt-5 mb-5">

      <div class="row w-100 mt-4 mb-4">

        <div class="col">
          <h1>Comparando produtos da categoria <b><?php echo session()->get('categoria_a_comparar') ?></b></h1>
        </div>
        <div class="col-auto">
          <a id="hideAnchor" href="#">

            <form method="post" action="{{ route('comparar-2-produtos') }}">
              @csrf

              <input hidden value="default" name="produto1" id="produto0" class="inputs_produto">
              <input hidden value="default" name="produto2" id="produto1" class="inputs_produto">

              <button class="btn btn-success botao_criar" id="comparar" class="text-decoration-none">Comparar</button>

            </form>

          </a>
        </div>
        
      </div>
      <h6>Selecione 2 produtos a comparar...</h6>

      <br>

    {{-- MOSTRAR PRODUTOS --}}
  
      <div id='todosProdutos'>
          <div id="prodDisplay" class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
  
            @for($i = 0; $i < sizeOf(session()->get('produtos_comparar')); $i++)
                @if(session()->get('produtos_comparar')[$i]['produto_nome_categoria'] == session()->get('categoria_a_comparar'))
            
                    <div>
                        <div class="col">
                          <a @click="selecionarProduto(<?php echo session()->get('produtos_comparar')[$i]['produto_id'] ?>)" class="text-decoration-none text-dark produto_select">
                            <div id="card_<?php echo session()->get('produtos_comparar')[$i]['produto_id'] ?>" class="card">
            
                                @if(!file_exists(session()->get('produtos_comparar')[$i]['produto_path_imagem']))
                                  <img src="images/default_produto.jpg" class="imagemProduto card-img-top">
                                @else
                                  <img src="<?php echo session()->get('produtos_comparar')[$i]['produto_path_imagem'] ?>" class="imagemProduto card-img-top">
                                @endif
            
                                <h5 class="card-title mt-3 text-center"><?php echo session()->get('produtos_comparar')[$i]['produto_nome'] ?></h5>
                                <h4 class="card-text text-center"><?php echo session()->get('produtos_comparar')[$i]['produto_preco'] ?> €</h4>
                                
            
                            </div>
                          </a>
                        </div>
                    </div>
        
                    @if($i > 0 && $i % 3==0)
                        </div>
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
                    @endif
                @endif
            @endfor
  
          </div>
        </div>
  
    </div>
  
  @endif
  
  <script src="./js/inventory.js"></script>
      
  @endsection
  
  