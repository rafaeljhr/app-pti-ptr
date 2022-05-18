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

 
  <div id="apresentação">
    
    <h4>Bem vindo <?php echo  session()->get('user_nome')?>!</h4>
    <h5>Aqui pode ver todos os armazéns que se encontram associados à sua conta de momento </h5> 
    <button class="btn btn-dark" @click="criarUmArmazem()" id="btn-id">Criar armazens</button>
  </div>
  

  <div id="criarUmArmazem" class="armazem">
    <button type="button" @click="criarUmArmazem()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
    <form @submit.prevent="criarArmazem" method="post" action="{{ route('armazem-register-controller')}}" enctype="multipart/form-data">
      @csrf
      <h3>Armazem:</h3>
  
      <label for="nome" class="form-label">Nome</label>
      <div class="input-group mb-3">  
      <input type="text" class="form-control" name="nome" id="morada"  aria-describedby="basic-addon1" required>
      </div>
  
      <label for="image" class="form-label">Imagem do seu armazém:</label>
      <div class="input-group mb-3">       
          <input type="file" class="form-control" name="path_imagem_armazem" id="image" aria-label="file" aria-describedby="basic-addon1">
        </div>
      <label for="morada" class="form-label">Morada do armazém</label>
      <div class="input-group mb-3">  
      <input type="text" class="form-control" name="morada" id="morada"  aria-describedby="basic-addon1" required>
        </div>
      
    
    <button class="w-100 btn btn-lg btn-primary" id ="but-pad" type="submit">Adicionar armazém</button>
    <button id='spinnerAdicionarArmazem' class="w-100 btn btn-lg btn-primary" ><a class="spinner-border text-light"></a></button>
    
    </form>
  </div>

  <div  class="container p-0 mt-5 mb-5">
    <div id='todosArmazensBefore'>
  
        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
  
        @if(session()->get('armazens') != null)
          @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++) 
          
            <div class="col">
              <div class="card">
                <h5 class="card-title"><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></h5>
                
                <img src='<?php echo session()->get('armazens')[$i]['armazem_path_imagem'] ?>' class="imagemProduto card-img-top" alt="...">
                <div class="card-body text-center">
                <h4 class="card-text"><?php echo session()->get('armazens')[$i]['armazem_morada'] ?></h4>
                
                <button id="storageInfo" name="{{ route('storage-info')}}" type="button" onclick="infoAdicional('<?php echo session()->get('armazens')[$i]['armazem_id']?>', '<?php echo session()->get('armazens')[$i]['armazem_nome'] ?>')" class="btn btn-outline-primary">info</button>
                <br>  
                <button type="button" class="btn btn-outline-primary">Editar</button>
  
                  <button type="button" id='buttonApagarArmazem' name="{{ route('armazem-delete-controller')}}" onclick="apagarArmazem('<?php echo session()->get('armazens')[$i]['armazem_id'] ?>')" class="btn btn-outline-danger">Apagar</button>
                  </div>
  
              </div>
            </div>
  
            @if($i > 0 && $i % 3==0)
              </div>
              <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
            @endif
            @endfor
  
          @endif
  
        </div>
  
      </div>

      <div id="todosArmazensAfter"></div>
  
    </div>
  </div>

  {{-- <div id="confDiv">

    <button type="button" id='' class="buttonApagarArmazem" name="{{ route('armazem-delete-controller')}}" onclick="apagarArmazem()" class="btn btn-outline-danger">Apagar</button>
    <button id='' hidden class="w-100 btn btn-lg btn-primary"><a class="spinner-border text-light"></a></button>
    </div> --}}


<div id="storage_info"> 
  <button type="button" @click="closeInfo()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <h3>Produtos do armazém:</h3>
  <p id="info"></p>
  <div id="prods"></div>
</div>

<div id="successCreate" classs="container p-5">
	<div class="row no-gutters">
		<div class="col-lg-6 col-md-12 m-auto">
			<div class="alert alert-success fade show" role="alert">
				
			 	<h4 class="alert-heading">Sucesso!</h4>
			  <p id="aviso">O seu armazem foi criado com sucesso.</p>
        <button  class="w-40 btn btn-lg btn-primary"  @click="closeSuccess()" id ="okButton" >Ok</button>
      </div>
		</div>
	</div>
</div>









<script src="./js/storage.js"></script>

    
@endsection