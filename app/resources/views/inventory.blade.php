<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="css/inventory.css">
</head>

<?php
//dd(session()->all());
?>


@extends('layouts.page_default')

@section('background') 

<!-- Modal Apagar Base -->
<div class="modal fade" id="modalComparar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCompararProdutos" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="modalApagarLabel">Comparar produtos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <br>
      <div class="modal-body">
          <form method="post" action="{{ route('comparar-produtos') }}">
            @csrf
  
            <label for="comparar_categoria" class="form-label">Qual a categoria de produtos que deseja comparar?</label>
            <div class="input-group mb-3">
              <select class="form-control" @change="changeSubcat($event)" name="comparar_categoria" id="novo_produto_categoria" required>
                <option value="">-- Selecione uma categoria --</option>
                @for($i = 0; $i < sizeOf(session()->get('categories')); $i++)
                <?php $category= session()->get('categories')[$i] ?>
                <option value='<?php echo session()->get('categories')[$i]['category_nome'] ?>'><?php echo session()->get('categories')[$i]['category_nome'] ?></option>              
                @endfor
              </select>
            </div>

            <br>
            <hr>

            <button type="submit" class="btn btn-success">Confirmar</button>
        </form>
      </div>
  </div>
  </div>
</div>

@if(sizeOf(session()->get('all_fornecedor_produtos')) <=0 && session()->get('armazens') != null)

  <div id="noProdutos">

    <div align="center">
      <img src="images/armazens.png" class="sem_produtos_img">
      <br>
      <br>
      <h2>Parece que não possui produtos!</h2>
      <p>Pode criar um usando o botão abaixo!</p>
      <br>
      <a id="hideAnchor" href="{{ URL::to('/prodCreate')}}">
        <button class="btn btn-success" id="botao_criar">Criar produto</button>
      </a>
      
    </div>
    
  
  </div>



@elseif(session()->get('armazens') == null || sizeOf(session()->get('armazens'))  == 0)

  <div id="noProdutos">

    <div align="center">
      <img src="images/armazens.png" class="sem_produtos_img">
      <br>
      <br>
      <h2>Parece que não armazéns!</h2>
      <p>Armazéns são necessários para possuir produtos, então crie um primeiramente!</p>
      <br>
      <a id="hideAnchor" href="{{ URL::to('/armazemCreate')}}">
        <button class="btn btn-success botao_criar" id="botao_criar">Criar armazém</button>
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
        <button class="btn btn-success botao_criar" id="botao_comparar" data-bs-toggle="modal" data-bs-target="#modalComparar">Comparar produtos</button>
      </div>
      <div class="col-auto">
        <a id="hideAnchor" href="{{ URL::to('/prodCreate')}}">
          <button class="btn btn-success botao_criar" id="botao_criar">Criar produto</button>
        </a>
      </div>
      
    </div>



  {{-- MOSTRAR PRODUTOS --}}

    <div id='todosProdutos'>
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

                    @if (session()->get('all_fornecedor_produtos')[$i]['produto_tem_eventos_logisticos'] == 0)
                      <p><span style="color: yellow;">&#9888;</span> <br> Crie a cadeia logística do produto, para que o mesmo fique à venda!</p>
                    @else
                      <p><span style="color: green;">&#10003;</span> <br> Este produto encontra-se atualmente à venda a consumidores!</p>
                    @endif

                    <a class="text-decoration-none" id="hideAnchor" href="{{ URL::to('cadeias/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
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

