
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  </head>
  
  
  <?php
  
  //dd(session()->all());
  
  //session()->forget('produto_cadeia_logistica');
  
  ?>
  
  <link rel="stylesheet" href="css/inventory.css">
  
  @extends('layouts.page_default')
  
  @section('background') 


  
<div id="fundoDivOpac" v-show="fundoDivOpac" class="backgroundSee"></div>
<div id="apresentação" class="mx-auto mt-4 mb-4">
    <?php
    $checker =  0;
    foreach(session()->get('produto_cadeia_logistica')  as $el){
        if($el['evento_id_produto'] == session()->get('prod_cadeia_actual')){
            $checker = 1;
        }
    }
    
    ?>
    @if($checker == 1)
    <div class="container p-0 mt-5 mb-5">

      <div class="row w-100 mt-4 mb-4">

        <div class="col">
          <h1>As cadeias do produto <?php echo session()->get('prod_nome_cadeia_actual')?></h1>
        </div>
        <div class="col-auto">
            <button class="btn btn-success" @click="criarUmaCadeiaLogistica()" id="botao_criar">Criar cadeia</button>
        </div>
        
      </div>



      {{-- ///////////////////// --}}{{-- mostrar todos os produtos --}}
    <div class="container p-0 mt-5 mb-5">
        <div id='todasCadeias'>
    
        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
    
          @for($i = 0; $i < sizeOf(session()->get('produto_cadeia_logistica')); $i++) 
          
          @if(session()->get('produto_cadeia_logistica')[$i]['evento_id_produto'] == session()->get('prod_cadeia_actual'))
            <div class="col">
              <div class="evento-size card">
                <h5 class="card-title"><?php echo session()->get('produto_cadeia_logistica')[$i]['evento_nome'] ?></h5>
                <h4 class="card-text ">CO2 criados: <?php echo session()->get('produto_cadeia_logistica')[$i]['evento_co2_produzido'] ?></h4>             
                <h4 class="card-text ">Kwh consumidos: <?php echo session()->get('produto_cadeia_logistica')[$i]['evento_kwh_consumidos'] ?></h4>
                <div class="card-body text-center">
                  <h5 class="card-title"><?php echo session()->get('produto_cadeia_logistica')[$i]['evento_descricao_do_evento'] ?></h5>
                </div>
                <a href="{{ URL::to('cadeiaInfo/'.session()->get('produto_cadeia_logistica')[$i]['evento_id']) }}">
                  <button id="cadeiaInfo" type="button" class="btn btn-outline-primary">Detalhes da cadeia</button>
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
  </div>


    @else

    <div id="noCadeias">

      <div align="center" class="mx-auto">
        <img src="images/armazens.png" class="sem_cadeias_img" alt="">
        <br>
        <br>
        <h2>Parece que não possui cadeias logisticas associadas ao produto <?php echo session()->get('prod_nome_cadeia_actual')?>.</h2>
        <p>Para o seu produto ser colocado para venda necessita deve ter no mínimo, uma cadeia logistica associada!</p>
        <br>
        <button class="btn btn-success" @click="criarUmaCadeiaLogistica()" id="botao_criar">Criar cadeia</button>
      </div>
      

    </div>


    @endif




{{-- div para adicionar cadeia logistica --}}
<div id="criarUmaCadeiaLogistica" class="forForm">
    <button type="button" @click="criarUmaCadeiaLogistica()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
    <form method="post" action="{{ route('product-add-event-controller')}}">
      @csrf
  
      <h3>Adicionar novo evento à cadeia logística do novo produto</h3>
      <label for="image" class="form-label">Nome do novo evento</label>
      <div class="input-group mb-3">  
        <input type="text" class="form-control" name="nomeCadeia" id="image"  aria-describedby="basic-addon1" required>
      </div>
  

        <label for="co2_produzido" class="form-label">CO2(kg) produzido pelo evento</label>
        <div class="input-group mb-3">       
          <input type="number" min="0" step  ="any" class="form-control" name="co2_produzido" id="co2_produzido" aria-describedby="basic-addon1" >
        </div>
      
  
      
        <label for="kwh_consumidos" class="form-label">KWh de energia consumidos</label>
        <div class="input-group mb-3">       
          <input type="number"  min="0" step ="any" class="form-control" name="kwh_consumidos" id="kwh_consumidos" aria-describedby="basic-addon1">
        </div>
      
  
      <br>
      <div class="input-group mb-3"> 
        <span class="input-group-text">Descrição</span>
        <textarea class="form-control" name="descricaoCadeia" aria-label="With textarea" required></textarea>
      </div>
  
      <button class="w-100 btn btn-lg btn-primary" id='botaoAdicionarEvento' type="submit">Adicionar</button>
  
  
    </form>
  </div>
  



</div>
</div>
  <script src="./js/inventory.js"></script>

    
@endsection