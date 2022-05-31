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
  
  

 
  <div id="apresentação" class="mx-auto mt-4 mb-4">
  
  
   
    <div class="container p-0 mt-5 mb-5">
      <div class="row w-100 mt-4 mb-4">
    <h4>Bem vindo <?php echo  session()->get('user_nome')?>!</h4>
    <div class="float-left">
      <h5>Aqui pode ver as principais  diferencas entre os produtos <?php echo session()->get('produto_comparar1')['produto_nome']?> e <?php echo session()->get('produto_comparar2')['produto_nome']?> </h5> 
    </div>
    
    

  </div>

  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card">
            
            
            <img src='<?php echo session()->get('produto_comparar1')['produto_path_imagem'] ?>' class="imagemProduto card-img-top" alt="...">
            
            <h3 class="card-title mt-3 text-center">Nome: <?php echo session()->get('produto_comparar1')['produto_nome'] ?></h3>
            <h4 class="card-text text-center">Preço: <?php echo session()->get('produto_comparar1')['produto_preco'] ?> €</h4>
            <h4 class="card-text text-center">Categoria: <?php echo session()->get('produto_comparar1')['produto_nome_categoria'] ?></h4>
            <h4 class="card-text text-center">Subcategoria: <?php echo session()->get('produto_comparar1')['produto_nome_subcategoria'] ?></h4>
            <div class="card-body text-center">
            <h4 class="card-text text-center text-danger">Kwh consumidos pelo armazenamento por dias: <?php echo session()->get('produto_comparar1')['produto_kwh_consumidos_por_dia'] ?></h4>
            <h4 class="card-text text-center text-danger">Co2 gerado pelas cadeias: <?php echo session()->get('produto_comparar1')['poluicao_evento_co2'] ?></h4>  
            <h4 class="card-text text-center text-danger">Kwh consumidos pelas cadeias: <?php echo session()->get('produto_comparar1')['poluicao_evento_kwh'] ?></h4>
            
            <h4 class="card-text">Informação adicional: <?php echo session()->get('produto_comparar1')['produto_informacoes_adicionais'] ?></h4>
  
        </div>
          </div>
      </div>
      <div class="col">
        <div class="card">
            <img src='<?php echo session()->get('produto_comparar2')['produto_path_imagem'] ?>' class="imagemProduto card-img-top" alt="...">
            
            <h3 class="card-title mt-3 text-center">Nome: <?php echo session()->get('produto_comparar2')['produto_nome'] ?></h3>
            <h4 class="card-text text-center">Preço: <?php echo session()->get('produto_comparar2')['produto_preco'] ?> €</h4>
            <h4 class="card-text text-center">Categoria: <?php echo session()->get('produto_comparar2')['produto_nome_categoria'] ?></h4>
            <h4 class="card-text text-center">Subcategoria: <?php echo session()->get('produto_comparar2')['produto_nome_subcategoria'] ?></h4>
            <div class="card-body text-center">
                <h4 class="card-text text-center text-danger">Kwh consumidos pelo armazenamento por dias: <?php echo session()->get('produto_comparar2')['produto_kwh_consumidos_por_dia'] ?></h4>
            <h4 class="card-text text-center text-danger">Co2 gerado pelas cadeias: <?php echo session()->get('produto_comparar2')['poluicao_evento_co2'] ?></h4>  
            <h4 class="card-text text-center text-danger">Kwh consumidos pelas cadeias: <?php echo session()->get('produto_comparar2')['poluicao_evento_kwh'] ?></h4>
            
            <h4 class="card-text">Informação adicional: <?php echo session()->get('produto_comparar2')['produto_informacoes_adicionais'] ?></h4>
          </div>
      </div>
    </div>
    </div>
        


</div>
</div>


</div>
</div>
@endsection