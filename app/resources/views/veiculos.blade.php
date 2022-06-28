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

@if(session()->get('veiculos') != null)
<div class="container p-0 mt-5 mb-5">

  <div class="row w-100 mt-4 mb-4">

    <div class="col">
      <h1>Os seus veículos</h1>
    </div>
    <div class="col-auto">
      <a id="hideAnchor" href="{{ URL::to('/veiculoCreate')}}">
        <button class="btn btn-success" id="botao_criar">Criar veiculo</button>
      </a>
    </div>
    
  </div>

  <div id='todasBases'>
    <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
      
        @for($i = 0; $i < sizeOf(session()->get('veiculos')); $i++)
          <div class="col">
            <div class="card">
              <img class="card-img-top imagem_da_card" src='<?php echo session()->get('veiculos')[$i]['veiculo_path_imagem'] ?>' alt="Card image cap">

              <h4 class="card-title mt-3 text-center"><?php echo session()->get('veiculos')[$i]['veiculo_nome'] ?></h4>

              <div class="card-body text-center">
                <div class="row">
                  <p class="ml-2"> Nº de veículos: <?php echo session()->get('veiculos')[$i]['veiculo_quantidade'] ?></p>
                </div>

                <div class="row">
                  <p> Combustível: <?php echo session()->get('veiculos')[$i]['veiculo_tipoCombustivel'] ?></p>
                </div>

                <div class="row">
                  <p>
                    <?php 
                    if (session()->get('veiculos')[$i]['veiculo_tipoCombustivel'] == "Eletricidade") {
                      echo session()->get('veiculos')[$i]['veiculo_consumo_por_100km']." kWh/100km";
                    } else {
                      echo session()->get('veiculos')[$i]['veiculo_consumo_por_100km']." L/100km";
                    }
                    ?>
                  </p>
                </div>

                <div class="row">
                  <p>
                    <?php 
                    foreach (session()->get('tipos_combustivel') as $tipo) {

                      if ($tipo['tipos_combustivel_nome'] == session()->get('veiculos')[$i]['veiculo_tipoCombustivel']) {
                        $tipo_combustivel_co2_por_km = $tipo['tipos_combustivel_co2_por_km'];
                        break;
                      }

                    }
                    echo $tipo_combustivel_co2_por_km." CO₂/km";
                    ?>
                  </p>
                </div>
              
                <a href="{{ URL::to('veiculo/'.session()->get('veiculos')[$i]['veiculo_id']) }}">
                  <button type="button" class="btn btn-info botoes_veiculos">Detalhes do veiculo</button>
                </a>
                <a href="{{ URL::to('base/'.session()->get('veiculos')[$i]['veiculo_id_base']) }}">
                  <button type="button" class="btn btn-info mt-2 botoes_veiculos">Base do veículo</button>
                </a>
              </div>

            </div>
          </div>
        @endfor

    </div>
  </div>
</div>

@else

  @if(session()->get('bases') != null) 

    <div id="noBases">

      <div align="center" class="mx-auto">
        <img src="images/veiculos.png" class="sem_bases_img" alt="">
        <br>
        <br>
        <h2>Parece que não possui veiculos.</h2>
        <p>Os veículos são necessários para poder realizar entregas, então crie um primeiramente!</p>
        <br>
        <a id="hideAnchor" href="{{ URL::to('/veiculoCreate')}}">
          <button class="btn btn-success" id="botao_criar">Criar veiculo</button>
        </a>
        
      </div>

    </div>

  @else

    <div id="noBases">

      <div align="center" class="mx-auto">
        <img src="images/armazens.png" class="sem_bases_img" alt="">
        <br>
        <br>
        <h2>Parece que não possui bases.</h2>
        <p>As bases são necessárias para possuir veículos, então crie uma primeiramente!</p>
        <br>
        <a href="{{ route('bases') }}"><button class="btn btn-success" id="botao_criar">Ir para bases</button></a>
        
      </div>

    </div>

  @endif

@endif





<script src="./js/base_veiculo.js"></script>

  
@endsection