<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

//dd(session()->all());
//session()->forget('bases');

?>

<link rel="stylesheet" href="css/bases_veiculos.css">

@extends('layouts.page_default')

@section('background') 
  

 
  
@if(session()->get('bases') != null)
<div class="container p-0 mt-5 mb-5">

  <div class="row w-100 mt-4 mb-4">

    <div class="col">
      <h1>As suas bases</h1>
    </div>
    <div class="col-auto">
      <a id="hideAnchor" href="{{ URL::to('/baseCreate')}}">
        <button class="btn btn-success" id="botao_criar">Criar base</button>
      </a>
    </div>
    
  </div>

  <div id='todasBases'>
    <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
      
        @for($i = 0; $i < sizeOf(session()->get('bases')); $i++)
          <div class="col">
            <div class="card">


              @if(!file_exists(session()->get('bases')[$i]['base_path_imagem']))
                <img class="card-img-top imagem_da_card" src='images/default_base.jpg'>
              @else
                <img class="card-img-top imagem_da_card" src='<?php echo session()->get('bases')[$i]['base_path_imagem'] ?>'>
              @endif

              <h4 class="card-title mt-3 text-center"><?php echo session()->get('bases')[$i]['base_nome'] ?></h4>

              <div class="card-body text-center">
                <div class="row">
                  <div class="col">
                    <p>
                      <?php

                        $num_veiculos = 0;
                        foreach (session()->get('veiculos') as $veiculo) {

                          if ($veiculo['veiculo_id_base'] == session()->get('bases')[$i]['base_id']) {
                            $num_veiculos += $veiculo['veiculo_quantidade'];
                          }

                        }

                        echo 'Nº de veículos na base: ' . $num_veiculos;

                      ?>
                    </p>
                  </div>
                </div>
              
                <a href="{{ URL::to('base/'.session()->get('bases')[$i]['base_id']) }}">
                  <button type="button" class="btn btn-info botoes_veiculos">Detalhes da base</button>
                </a>
              </div>

            </div>
          </div>
        @endfor

    </div>
  </div>
</div>

@else

<div id="noBases">

  <div align="center">
    <img src="images/armazens.png" class="sem_bases_img">
    <br>
    <br>
    <h2>Parece que não possui bases.</h2>
    <p>As bases são necessárias para possuir veículos, então crie uma primeiramente!</p>
    <br>
    <a id="hideAnchor" href="{{ URL::to('/baseCreate')}}">
      <button class="btn btn-success" id="botao_criar">Criar base</button>
    </a>
    
  </div>
  

</div>

@endif



<script src="./js/base_veiculo.js"></script>

    
@endsection