<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

// dd(session()->all());

?>

<link rel="stylesheet" href="css/storage.css">


@extends('layouts.page_default')

@section('background') 
 
  @if(sizeOf(session()->get('armazens')) > 0)
    <div class="container p-0 mt-5 mb-5">

      <div class="row w-100 mt-4 mb-4">

        <div class="col">
          <h1>Os seus armazéns</h1>
        </div>
        <div class="col-auto">
          <a id="hideAnchor" href="{{ URL::to('/armazemCreate')}}">
            <button class="btn btn-success" id="botao_criar">Criar armazém</button>
          </a>
        </div>
        
      </div>
      
      <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">

        @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++)
        <div class="col">
          <div class="card">


            @if(!file_exists(session()->get('armazens')[$i]['armazem_path_imagem']))
              <img class="card-img-top imagem_da_card" src='images/default_armazem.jpg'>
            @else
              <img class="card-img-top imagem_da_card" src='<?php echo session()->get('armazens')[$i]['armazem_path_imagem'] ?>'>
            @endif

            <h4 class="card-title mt-3 text-center"><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></h4>

            <div class="card-body text-center">
                <div class="row">
                  <p>
                    <?php

                      $num_produtos = 0;
                      foreach (session()->get('all_fornecedor_produtos') as $produto) {

                        if ($produto['produto_id_armazem'] == session()->get('armazens')[$i]['armazem_id']) {
                          $num_produtos += $produto['produto_quantidade'];
                        }

                      }

                      echo 'Nº de produtos no armazém: ' . $num_produtos;

                    ?>
                  </p>
                </div>
            
                <a href="{{ URL::to('storage/'.session()->get('armazens')[$i]['armazem_id']) }}">
                  <button type="button" class="btn btn-info botoes_armazens">Detalhes</button>
                </a>
            </div>

          </div>
        </div>
      @endfor

      </div>
    </div>
  
  @else

    <div id="noStorage">

      <div align="center">
        <img src="images/armazens.png" class="sem_armazens_img">
        <br>
        <br>
        <h2>Parece que não possui armazéns!</h2>
        <p>Os armazéns são necessários para possuir produtos, então crie uma primeiramente!</p>
        <br>
        <a id="hideAnchor" href="{{ URL::to('/armazemCreate')}}">
          <button class="btn btn-success" id="botao_criar">Criar armazém</button>
        </a>
        
      </div>
      
    
    </div>

  @endif


<script src="./js/storage.js"></script>

@endsection