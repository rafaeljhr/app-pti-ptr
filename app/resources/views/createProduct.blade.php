


<link rel="stylesheet" href="css/inventory.css">

@extends('layouts.page_default')

@section('background') 


{{-- /////////////////////////////////////////////////////////////////// --}}
<div id="apresentaçãoForm" class="mx-auto mt-4 mb-4">

<div>
    
    {{-- Criar produto--}}
    <form method="post" action="{{ route('product-register-controller') }}" id="criar_um_produto" enctype="multipart/form-data">
      @csrf
      <h2>Informação principal do produto</h2>
        
        <div class="row" >
          <div class="col">
            <label for="nome" class="form-label">Nome do produto:</label>
            <input type="text" class="form-control"  name="nome" id="novo_produto_nome" placeholder="Nome do produto" aria-label="Username" aria-describedby="addon-wrapping" required>
          </div>
  
          <div class="col">
            <label for="path_imagem_produto" class="form-label">Imagem do produto:</label>
            <input type="file" class="form-control" id="novo_produto_imagem" name="path_imagem_produto" aria-label="file">
          </div>
  
          <div class="col">
            <label for="id_armazem" class="form-label">Armazem do produto</label>
            <select class="form-control"  name="id_armazem" id='selected_armazem' list="input-armazens" required>
              <option value="">-- Selecione o armazem do produto --</option>
              @for($i = 0; $i < sizeOf(session()->get('armazens')); $i++)
              <option value=<?php echo session()->get('armazens')[$i]['armazem_id']?>><?php echo session()->get('armazens')[$i]['armazem_nome'] ?></option>
              @endfor
            </select>
          </div>
        </div>
  
          <div class="row" >
            <div class="col">
              <label for="nome_categoria" class="form-label">Categoria do produto</label>
              <select class="form-control" @change="changeSubcat($event)" name="nome_categoria" id="novo_produto_categoria" required>
                <option value="">-- Selecione uma categoria --</option>
                @for($i = 0; $i < sizeOf(session()->get('categories')); $i++)
                <?php $category= session()->get('categories')[$i] ?>
                <option value='<?php echo session()->get('categories')[$i]['category_nome'] ?>'><?php echo session()->get('categories')[$i]['category_nome'] ?></option>              
                @endfor
              </select>
            </div>
  
            <div class="col">
              <input id="routeSubCat" name="{{ route('product-changeSub') }}" hidden>           
              <div id="toChangeOnCmd">
                <label for="nome_subcategoria" class="form-label">Selecione uma subcategoria</label>
              <select class="form-control" disabled name="nome_subcategoria" id="novo_produto_subcategoria" required>
                  <option default value="">-- Selecione uma subcategoria --</option>
                </select>
            </div>       
            </div>
  
          </div>
          
        {{-- Campos extra do produto consoante a sua categoria --}}
        <div id="camposExtra"></div>
  
        <div class="input-group mb-3">
          <span class="input-group-text">€</span>
          <span class="input-group-text">0.00</span>
          <input type="number" step="any" class="form-control" name="preco" placeholder="Preço do seu produto" aria-label="Dollar amount (with dot and two decimal places)" id="novo_produto_preco" required>
        </div>
  
        <div class="row">
          <div class="col">
            <label for="data_producao_do_produto" class="form-label">Data de fabrico do produto:</label>
            <input name="data_producao_do_produto" class="form-control" type="date" id="novo_produto_data_fabrico" required>
          </div>
          
          <div class="col">
            <label for="data_insercao_no_site" class="form-label">Data de inserção no site do produto:</label>
            <input name="data_insercao_no_site" class="form-control" type="date" id="novo_produto_data_insercao" required>
          </div>
        </div>
  
  
        <div class="row">
          <div class="col">
            <label for="kwh_consumidos_por_dia" class="form-label">Kwh consumidos por dia</label>
            <input name="kwh_consumidos_por_dia" class="form-control" type="number" step="any" id="novo_produto_kwh" required>
          </div>
  
          <div class="col">
            <label for="quantidade" class="form-label">Quantidade de produtos</label>
            <input name="quantidade" class="form-control" type="number" step="any" id="novo_produto_quantidade" required>
          </div>
        </div>
  
  
        <div class="input-group mb-3">
          
            <div class="input-group-prepend">
              <span class="input-group-text">Informações adicionais</span>
            </div>
  
            <textarea name="informacoes_adicionais" class="form-control" aria-label="Informações adicionais" id="novo_produto_infos_adicionais" required></textarea>
          
        </div>
  
        
        <button type= "submit" class="w-100 btn btn-lg btn-primary">Criar produto</button>
    
    </form>
  
  </div>
</div>
</div>


  <script src="./js/inventory.js"></script>

    
@endsection