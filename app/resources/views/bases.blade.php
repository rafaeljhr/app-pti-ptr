<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

//dd(session()->all());

//session()->forget('produto_cadeia_logistica');

?>

<link rel="stylesheet" href="css/bases.css">

@extends('layouts.page_default')

@section('background') 
  
  <div id="fundoDivOpac"  class="backgroundSee"></div>

 
  <div id="apresentação" class="mx-auto mt-4">
    
    <h4>Bem vindo <?php echo  session()->get('user_nome')?>!</h4>
    <h5>Aqui pode ver todos as bases que se encontram associados à sua conta de momento</h5> 
    <button class="btn btn-dark" onclick="criarUmaBase()" id="btn-id">Criar base</button>
  </div>
  

  <div id="criarUmaBase" class="armazem">
    <button type="button" onclick="criarUmaBase()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
    <form method="post" action="{{ route('armazem-register-controller')}}" enctype="multipart/form-data">
      @csrf
        <h3>Base:</h3>

        <label for="nome" class="form-label">Nome da base</label>
        <div class="input-group mb-3">  
            <input type="text" class="form-control" name="nome" id="morada"  aria-describedby="basic-addon1" required>
        </div>

        <label for="image" class="form-label">Imagem da sua base:</label>
        <div class="input-group mb-3">       
            <input type="file" class="form-control" name="path_imagem" id="image" aria-label="file" aria-describedby="basic-addon1">
        </div>


        <div class="row">
            <div class="col">
                <label for="morada" class="form-label">Morada da base</label>
                <div class="input-group mb-3">  
                    <input type="text" class="form-control" name="morada" id="morada"  aria-describedby="basic-addon1" required>
                </div>
            </div>
            <div class="col">
                <div class="form-outline">
                    <label for="codigo_postal" class="form-label">Código postal da base</label>
                    <div class="inline-icon">
                        <input type="text" name ="codigo_postal_1" class="form-control w-50" maxlength="4" placeholder="xxxx" style="display: inline-block;">
                        <input type="text" name ="codigo_postal_2" class="form-control w-50" maxlength="3" placeholder="xxx" style="display: inline-block;">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-outline">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" name ="cidade" class="form-control">
                </div>
            </div>
            <div class="col">
                <label for="pais" class="form-label">País</label>
                <select class="form-control"  name="pais">
                    <option selected>Portugal</option>
                </select>
            </div>
        </div>
    
    <button class="w-100 btn btn-lg btn-primary mt-5" id ="but-pad" type="submit">Adicionar base</button>
    </form>

  </div>

  <div class="container p-0 mt-5 mb-5">
    <div id='todosArmazensBefore'>
  
        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
  
        @if(session()->get('bases') != null)
          @for($i = 0; $i < sizeOf(session()->get('bases')); $i++) 
          
            <div class="col">
              <div class="card">
                <h5 class="card-title"><?php echo session()->get('bases')[$i]['armazem_nome'] ?></h5>
                
                <img src='<?php echo session()->get('bases')[$i]['armazem_path_imagem'] ?>' class="imagemProduto card-img-top">
                <div class="card-body text-center">
                <h4 class="card-text"><?php echo session()->get('bases')[$i]['armazem_morada'] ?></h4>
                
                <button id="storageInfo" name="{{ route('storage-info')}}" type="button" onclick="infoAdicional('<?php echo session()->get('bases')[$i]['armazem_id']?>', '<?php echo session()->get('bases')[$i]['armazem_nome'] ?>')" class="btn btn-outline-primary">info</button>
                <br>  
                <button type="button" class="btn btn-outline-primary">Editar</button>
  
                  <button type="button" id='buttonApagarArmazemWarning' name="{{ route('armazem-delete-warning')}}" onclick="deleteWarning('<?php echo session()->get('bases')[$i]['armazem_id'] ?>', '<?php echo session()->get('bases')[$i]['armazem_nome'] ?>')" class="btn btn-outline-danger">Apagar</button>
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

      {{-- <div id="todosArmazensAfter"></div> --}}
  
    </div>
  </div>


<div id="storage_info"> 
  <button type="button" @click="closeInfo()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
  <h3>Produtos do armazém:</h3>
  <p id="info"></p>
  <div id="prods"></div>
</div>



<script src="./js/base.js"></script>

    
@endsection