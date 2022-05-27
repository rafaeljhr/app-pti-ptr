<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

//dd(session()->all());

//session()->forget('produto_cadeia_logistica');

?>

<link rel="stylesheet" href="css/storage.css">


@extends('layouts.page_default')

@section('background') 
  
  <div id="fundoDivOpac"  class="backgroundSee"></div>

 
  <div id="apresentação" class="mx-auto mt-4 mb-4">
  @if(session()->get('armazens') != null)
  
   
    <div class="container p-0 mt-5 mb-5">
      <div class="row w-100 mt-4 mb-4">
    <h4>Bem vindo <?php echo  session()->get('user_nome')?>!</h4>
    <div class="float-left">
      <h5>Aqui pode ver todos os armazéns que se encontram associados à sua conta de momento </h5> 
    </div>
    
    <div class="float-rigth">
    <button class="btn btn-dark" @click="criarUmArmazem()" id="btn-id">Criar armazens</button>
    </div>

  </div>
  
        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
  
        
          @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++) 

          <?php 
          $sum =  0;
          $id =  session()->get('armazens')[$i]['armazem_id'];
          if(session()->get('all_fornecedor_produtos')  !=  null)
            for($p = 0; $p < sizeOf(session()->get('all_fornecedor_produtos')); $p++)
              if($id == session()->get('all_fornecedor_produtos')[$p]['produto_id_armazem'])
                $sum = $sum + session()->get('all_fornecedor_produtos')[$p]['produto_kwh_consumidos_por_dia'] ;
          ?>
          
            <div class="col">
              <div class="card">
                <h5 class="card-title"><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></h5>
                
                <img src='<?php echo session()->get('armazens')[$i]['armazem_path_imagem'] ?>' class="imagemProduto card-img-top" alt="...">
                <div class="card-body text-center">
                
                <h4 class="card-text"><?php echo session()->get('armazens')[$i]['armazem_morada'] ?></h4>
                
                <p>Consumo total: <?php echo $sum ?> kwh por dia</p>
                <a href="{{ URL::to('storage/'.session()->get('armazens')[$i]['armazem_id']) }}">
                  <button id="storageInfo" type="button" class="btn btn-outline-primary">Detalhes do armazém</button>
                </a>  
                <br>  
                
                
                  <button type="button" id='buttonApagarArmazemWarning' name="{{ route('armazem-delete-warning')}}" onclick="deleteWarning('<?php echo session()->get('armazens')[$i]['armazem_id'] ?>', '<?php echo session()->get('armazens')[$i]['armazem_nome'] ?>')" data-bs-toggle="modal" data-bs-target="#modalApagar" class="btn btn-outline-danger">Apagar</button>
                
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

@else

<div id="noStorage">

  <div align="center">
    <img src="images/armazens.png" class="sem_bases_img" alt="">
    <br>
    <br>
    <h2>Parece que não possui nenhum armazém.</h2>
    <p>Armazéns são necessários para criar produtos, então crie um primeiramente.</p>
    <br>
    <button class="btn btn-dark" @click="criarUmArmazem()" id="btn-id">Criar armazens</button>
  </div>
  

</div>

@endif
</div>
</div>





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


<div id="criarUmArmazem" class="armazem">
  <button type="button" @click="criarUmArmazem()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <form method="post" action="{{ route('armazem-register-controller')}}" enctype="multipart/form-data">
    @csrf
    <h3>Armazem:</h3>

    <label for="nome" class="form-label">Nome</label>
    <div class="input-group mb-3">  
    <input type="text" class="form-control" name="nome" id="nome"  aria-describedby="basic-addon1" required>
    </div>

    <label for="image" class="form-label">Imagem do seu armazém:</label>
    <div class="input-group mb-3">       
        <input type="file" class="form-control" name="path_imagem_armazem" id="image" aria-label="file" aria-describedby="basic-addon1">
      </div>
    



      <div class="row" >
        <div class="col">
          <label for="morada" class="form-label">Morada do armazém</label>
      <input type="text" class="form-control" name="morada" id="morada"  aria-describedby="basic-addon1" required>
      </div>

        <div class="col">
          
          <label for="codigo_postal" style="display: table-cell;" class="text-dark">Código Postal</label>
          <div class="inline-icon">
          <input  type="text" name ="codigo_postal_1" class="form-control w-50" style="display: inline-block;" maxlength="4" placeholder="xxxx">
        
          <input  type="text" name ="codigo_postal_2" class="form-control w-50" style="display: inline-block;" maxlength="3" placeholder="xxx">
        </div>
        </div>

      </div>

      <div class="row" >
        <div class="col">
          <label for="cidade" class="form-label">Cidade</label>
      <input type="text" class="form-control" name="cidade" id="cidade"  aria-describedby="basic-addon1" required>
      </div>

        <div class="col">
          <label for="pais" class="form-label">País</label>
          <input type="text" name ="pais"  id="pais" class="form-control" aria-describedby="basic-addon1" required>
          
          </div>

      </div>
    
  
  <button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Adicionar armazém</button>
  <button id='spinnerAdicionarArmazem' class="w-100 btn btn-lg btn-primary" ><a class="spinner-border text-light"></a></button>
  
  </form>
</div>











<script src="./js/storage.js"></script>

    
@endsection