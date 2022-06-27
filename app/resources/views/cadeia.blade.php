<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="css/inventory.css">
</head>
  
  
<?php
// dd(session()->all());
?>

@extends('layouts.page_default')

@section('background') 


@if(sizeOf(session()->get('produto_cadeia_logistica')) > 0)
  <div class="container mt-5 mb-5 p-0">

    <div class="row w-100 mt-4 mb-4">

      <div class="col">
        <h1>EVENTOS LOGÍSTICO DO PRODUTO <b><?php echo session()->get('prod_nome_cadeia_actual')?></b></h1>
      </div>
      <div class="col-auto">
        <a id="hideAnchor" href="{{ URL::to('/eventoLogisticoCreate')}}">
          <button class="btn btn-success" id="botao_criar">Criar evento logístico</button>
        </a>
      </div>
      
    </div>

    <p  class="mt-5"><?php echo sizeOf(session()->get('produto_cadeia_logistica')) ?> evento(s) logistíco(s)</p>

    @for($i = 0; $i < sizeOf(session()->get('produto_cadeia_logistica')); $i++)

      @if($i == 0)

        <div class="row mt-4 mx-auto w-100">

      @else 

        <div class="row mx-auto w-100">

      @endif

          <div class="col">
              <h5>Evento logístico Nº <?php echo $i+1 ?> - <?php echo session()->get('produto_cadeia_logistica')[$i]['evento_nome'] ?></h5>
              <br>
              <div class="row">
                  <div class="col-4">
                      <h6>CO2(kg) produzido pelo evento</h6>
                  </div>

                  <div class="col-4">
                      <h6>KWh consumidos pelo evento</h6>
                  </div>
              </div>

              <div class="row">
                  <div class="col-4">
                      <p><?php echo session()->get('produto_cadeia_logistica')[$i]['evento_co2_produzido'] ?> kg</p>
                  </div>

                  <div class="col-4">
                      <p><?php echo session()->get('produto_cadeia_logistica')[$i]['evento_kwh_consumidos'] ?> KWh</p>
                  </div>
              </div>

              <div class="row">
                <h6>Descrição</h6>
              </div>

              <div class="row">
                <p><?php echo session()->get('produto_cadeia_logistica')[$i]['evento_descricao_do_evento'] ?></p>
              </div>
          </div>

          <div class="col-3 mx-auto my-auto">
              <a href="{{ URL::to('cadeiaInfo/'.session()->get('produto_cadeia_logistica')[$i]['evento_id']) }}">
                  <h5 class="detalhes">VER DETALHES</h5>
              </a>
          </div>

      </div>

      <br>

      <hr class="dropdown-divider" style="margin: auto;">

      <br>
  @endfor

@else

  <div id="noCadeias">

    <div align="center">
      <img src="images/armazens.png" class="sem_cadeias_img">
      <br>
      <br>
      <h2>Nenhum evento logístico associado ao produto <b><?php echo session()->get('prod_nome_cadeia_actual')?></b>!</h2>
      <p>O produto será colocado à venda, quando possuir pelo menos 1 evento logístico.</p>
      <br>
      <a id="hideAnchor" href="{{ URL::to('/eventoLogisticoCreate')}}">
        <button class="btn btn-success" id="botao_criar">Criar evento logístico</button>
      </a>
      
    </div>

  </div>
  


@endif

<script src="./js/inventory.js"></script>

@endsection