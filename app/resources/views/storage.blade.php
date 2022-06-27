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

    <div class="row w-100 mt-4 mb-4">

      <div class="col">
        <h1>Os seus armazéns</h1>
      </div>
      <div class="col-auto">
        <a id="hideAnchor" href="{{ URL::to('/armazemCreate')}}">
          <button class="btn btn-success" id="btn-id">Criar armazém</button>
        </a>
      </div>
      
    </div>
  
   
    <div class="container p-0 mt-5 mb-5">
  
        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
        
          @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++) 

            <?php 
              $sum =  0;
              $id =  session()->get('armazens')[$i]['armazem_id'];
              
              if(session()->get('all_fornecedor_produtos')  !=  null) {
                for($p = 0; $p < sizeOf(session()->get('all_fornecedor_produtos')); $p++) {
                  if($id == session()->get('all_fornecedor_produtos')[$p]['produto_id_armazem']) {
                    $sum = $sum + session()->get('all_fornecedor_produtos')[$p]['produto_kwh_consumidos_por_dia'];
                  }
                }
              }
            ?>
            
            <div class="col">
              <div class="card">
                <h5 class="card-title"><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></h5>
                
                @if(!file_exists(session()->get('armazens')[$i]['armazem_path_imagem']))
                  <img class="card-img-top imagem_da_card" src='images/default_armazem.jpg'>
                @else
                  <img class="card-img-top imagem_da_card" src='<?php echo session()->get('armazens')[$i]['armazem_path_imagem'] ?>'>
                @endif

                <div class="card-body text-center">
                
                  <h4 class="card-text"><?php echo session()->get('armazens')[$i]['armazem_morada'] ?></h4>
                  
                  <p>Consumo total: <?php echo $sum ?> kwh por dia</p>

                  <a href="{{ URL::to('storage/'.session()->get('armazens')[$i]['armazem_id']) }}">
                    <button id="storageInfo" type="button" class="btn btn-outline-primary">Detalhes do armazém</button>
                  </a>  

                  <br>  
                  
                  {{-- <button type="button" id='buttonApagarArmazemWarning' name="{{ route('armazem-delete-warning')}}" onclick="deleteWarning('<?php echo session()->get('armazens')[$i]['armazem_id'] ?>', '<?php echo session()->get('armazens')[$i]['armazem_nome'] ?>')" data-bs-toggle="modal" data-bs-target="#modalApagar" class="btn btn-outline-danger">Apagar</button>
                 --}}
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




<div class="modal fade" id="modalApagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalApagarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <p id="fraseWarning">Tem a certeza que deseja apagar o armazém</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

        <form method="post" action="{{ route('armazem-delete-controller')}}">
        @csrf
          <div id="buttonApagar"></div>
        </form>
      </div>
  </div>
  </div>
</div>


<script src="./js/storage.js"></script>

@endsection