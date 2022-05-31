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

<div id="fundoDivOpac"  class="backgroundSee"></div>


<div id="apresentação" class="mx-auto mt-4 mb-4">

  @if(session()->get('veiculos') != null)
  <div class="container p-0 mt-5 mb-5">

    <div class="row w-100 mt-4 mb-4">

      <div class="col">
        <h1>Os seus veículos</h1>
      </div>
      <div class="col-auto">
          <button class="btn btn-success" onclick="criar()" id="botao_criar">Criar veículo</button>
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
        <p>As veículos são necessárias para poder realizar entregas, então crie um primeiramente!</p>
        <br>
        <button class="btn btn-success" onclick="criar()" id="botao_criar">Criar veiculo</button>
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

</div>


<div id="criar" class="base">
  <button type="button" onclick="criar()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <form method="post" action="{{ route('veiculo-register-controller')}}" enctype="multipart/form-data">
    @csrf
    <h1 class="text-center mb-3 mt-2">CRIAR VEÍCULO</h1>

      <label for="nome" class="form-label">Nome do veículo</label>
      <div class="input-group mb-3">  
          <input type="text" class="form-control" name="nome" id="morada"  aria-describedby="basic-addon1" required>
      </div>

      <label for="image" class="form-label">Imagem do veículo:</label>
      <div class="input-group mb-3">       
          <input type="file" class="form-control" name="path_imagem" id="image" aria-label="file" aria-describedby="basic-addon1">
      </div>


      <div class="row">

          <div class="col">
            <label for="tipo_combustivel" class="form-label">Combustível</label>
            <select class="form-control" name="tipo_combustivel" required>
              <option class="text-center" value="">-- Selecione o tipo de combustível --</option>
              @for($i = 0; $i < sizeOf(session()->get('tipos_combustivel')); $i++)
              <option class="text-center" value='<?php echo session()->get('tipos_combustivel')[$i]['tipos_combustivel_nome'] ?>'><?php echo session()->get('tipos_combustivel')[$i]['tipos_combustivel_nome'] ?></option>              
              @endfor
            </select>
          </div>

          <div class="col">
            <label for="consumo_por_100km" class="form-label">Consumo (L) por 100Km</label>
            <div class="input-group mb-3">  
              <input name="consumo_por_100km" class="form-control" type="number" step="any" required>
            </div>
          </div>
      </div>

      <div class="row">
          <div class="col">
            <label for="id_base" class="form-label">Base do veículo</label>
            <select class="form-control" name="id_base" list="input-bases" required>
              <option class="text-center" value="">-- Selecione a base do veículo --</option>
              @for($i = 0; $i < sizeOf(session()->get('bases')); $i++)
              <option class="text-center" value=<?php echo session()->get('bases')[$i]['base_id']?>><?php echo session()->get('bases')[$i]['base_nome'] ?></option>
              @endfor
            </select>
          </div>

          <div class="col">
              <label for="quantidade" class="form-label">Número de veículos</label>
              <div class="input-group mb-3">  
                <input name="quantidade" class="form-control" type="number" step="any" required>
              </div>
          </div>
      </div>
  
    <button class="w-100 btn btn-lg btn-success mt-3" id ="but-pad" type="submit">Adicionar veículo</button>
  </form>

</div>
</div>



<script src="./js/base_veiculo.js"></script>

  
@endsection