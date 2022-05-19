<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

//dd(session()->all());
//session()->forget('bases');

?>

<link rel="stylesheet" href="css/bases.css">

@extends('layouts.page_default')

@section('background') 
  
  <div id="fundoDivOpac"  class="backgroundSee"></div>

 
  <div id="apresentação" class="mx-auto mt-4 mb-4">
  
    @if(session()->get('bases') != null)
    <div class="container p-0 mt-5 mb-5">

      <div class="row w-100 mt-4 mb-4">

        <div class="float-left">
          <h1>As suas bases</h1>
        </div>
        <div class="float-rigth">
          <button class="btn btn-primary" onclick="criarUmaBase()" id="botao_criar_base_sem_bases">Criar base</button>
        </div>
        
      </div>

      <div id='todasBases'>
        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
          
            @for($i = 0; $i < sizeOf(session()->get('bases')); $i++)
              <div class="col">
                <div class="card">
                  <h5 class="card-title"><?php echo session()->get('bases')[$i]['base_nome'] ?></h5>
                  
                  <img src='<?php echo session()->get('bases')[$i]['base_path_imagem'] ?>' class="imagem_da_base card-img-top">

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
  
                            echo 'Nº de veículos: ' . $num_veiculos;
  
                          ?>
                        </p>
                      </div>
                    </div>
                  
                    <a href="{{ URL::to('base/'.session()->get('bases')[$i]['base_id']) }}">
                      <button type="button" class="btn btn-outline-primary">Detalhes da base</button>
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
        <img src="images/armazens.png" class="sem_bases_img" alt="">
        <br>
        <br>
        <h2>Parece que não possui nenhuma base.</h2>
        <p>As bases são necessárias para criar veículos, então crie uma primeiramente.</p>
        <br>
        <button class="btn btn-primary" onclick="criarUmaBase()" id="botao_criar_base_sem_bases">Criar base</button>
      </div>
      

    </div>


    @endif

  </div>
  

  <div id="criarUmaBase" class="base">
    <button type="button" onclick="criarUmaBase()" class="btn-close" id="button-close-div"  aria-label="Close"></button>
    <form method="post" action="{{ route('base-register-controller')}}" enctype="multipart/form-data">
      @csrf
        <h3>Criar nova base</h3>

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
</div>



<script src="./js/base.js"></script>

    
@endsection