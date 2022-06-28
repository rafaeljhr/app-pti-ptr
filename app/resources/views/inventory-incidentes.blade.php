<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="css/inventory.css">
  </head>
  
  <?php
  //dd(session()->all());
  ?>
  
  
  @extends('layouts.page_default')
  
  @section('background')
  
  @if(sizeOf(session()->get('all_fornecedor_produtos_incidentes')) <=0)
  
    <div id="noProdutos">
  
      <div align="center">
        <img src="images/armazens.png" class="sem_produtos_img">
        <br>
        <br>
        <h2>Parece que não possui produtos com incidentes!</h2>
      </div>
      
    
    </div>
  
  @else
  
    <div class="container p-0 mt-5 mb-5">
      
    <h1>Os seus produtos expiradas / que tiveram problemas no transporte</h1>
        
    {{-- MOSTRAR PRODUTOS INCIDENTES --}}
  
      <div id='todosProdutos'>
          <div id="prodDisplay" class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
  
            @for($i = 0; $i < sizeOf(session()->get('all_fornecedor_produtos_incidentes')); $i++) 
          
              <div>
                <div class="col">
                  <div class="card">
  
                    @if(!file_exists(session()->get('all_fornecedor_produtos_incidentes')[$i]['produto_path_imagem']))
                      <a href="{{ URL::to('produtosEdit/'.session()->get('all_fornecedor_produtos_incidentes')[$i]['produto_id']) }}">
                        <img src="images/default_produto.jpg" class="imagemProduto card-img-top">
                      </a>
                    @else
                      <a href="{{ URL::to('produtosEdit/'.session()->get('all_fornecedor_produtos_incidentes')[$i]['produto_id']) }}">
                        <img src="<?php echo session()->get('all_fornecedor_produtos_incidentes')[$i]['produto_path_imagem'] ?>" class="imagemProduto card-img-top">
                      </a>
                    @endif
  
                    <h5 class="card-title mt-3 text-center"><?php echo session()->get('all_fornecedor_produtos_incidentes')[$i]['produto_nome'] ?></h5>
                    <h4 class="card-text text-center"><?php echo session()->get('all_fornecedor_produtos_incidentes')[$i]['produto_preco'] ?> €</h4>
                    
                    <div class="card-body text-center">
  
                      <a class="text-decoration-none" id="hideAnchor" href="{{ URL::to('cadeias/'.session()->get('all_fornecedor_produtos_incidentes')[$i]['produto_id']) }}">
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
  
  