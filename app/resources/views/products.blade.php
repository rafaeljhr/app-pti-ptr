<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<link rel="stylesheet" href="css/inventory.css">

@extends('layouts.page_default')

@section('background') 
    
        

<!-- Modal Comparar produtos -->
<div class="modal fade" id="modalComparar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCompararProdutos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalApagarLabel">Comparar produtos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <br>
        <div class="modal-body">
            <form method="post" action="{{ route('comparar-produtos-loja') }}">
              @csrf
    
              <label for="comparar_categoria" class="form-label">Qual a categoria de produtos que deseja comparar?</label>
              <div class="input-group mb-3">
                <select class="form-control" name="comparar_categoria" id="novo_produto_categoria" required>
                  <option value="">-- Selecione uma categoria --</option>
                  @for($i = 0; $i < sizeOf(session()->get('categories')); $i++)
                  <?php $category= session()->get('categories')[$i] ?>
                  <option value='<?php echo session()->get('categories')[$i]['category_nome'] ?>'><?php echo session()->get('categories')[$i]['category_nome'] ?></option>              
                  @endfor
                </select>
              </div>
  
              <br>
              <hr>
  
              <button type="submit" class="btn btn-success">Confirmar</button>
          </form>
        </div>
    </div>
    </div>
  </div>

    {{-- mostrar todos os produtos --}}
    <div class="row w-100 row_loja">

        <div class="col-2">
            <div class="w-100 h-100 Div_Filtros_Produtos">
                <form action="javascript:;" onsubmit="Filtros(this, '{{ route('ProductFilter') }}' )">
                    <h2 class="text-center mt-3">Filtros</h2>
                    <br>
                    <div class="text-center">
                        <button type="submit">Pesquisar</button>
                    </div>
                    @if (session()->has("user_id"))
                        <br>
                        <input type="checkbox" id="favoritos" name="favoritos">
                        <label for="favoritos">Favoritos</label>
                        <br>
                    @endif
                    <br>
                    <div class = "Div_Campos">
                        <label for="Nome">Nome &nbsp;</label>
                        <input type="text" id="Nome" name="Nome">
    
                        <br>
                        <br>
    
                        <label for="Preco">Preço&nbsp;</label>
                        <input type="range" id="Preco" name="Preco" step="10" min="1" max="1500" value="750" oninput="this.nextElementSibling.value = this.value">
                        &nbsp; 
                        <output>750</output>
                    
    
                        <br>
                        <br>
    
                        <div id = "Div_Categorias">
                            {!! $data['categorias'] !!}
                        </div>
    
                        <br>
    
                        <div id = "Div_SubCategorias">
                    
                        </div>
    
                        <br>
    
                        <div id = "Div_CamposExtra">
    
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-9">

            <div id='todosProdutos' class="w-100 h-100">

                <div class="row w-100 mt-4">
    
                    <div class="col">
                      <h3>Loja de produtos</h3>
                    </div>
                    <div class="col-auto">
                      <button class="btn btn-success botao_criar" id="botao_comparar" data-bs-toggle="modal" data-bs-target="#modalComparar">Comparar produtos</button>
                    </div>
                    
                  </div>
    
                {!! $data['produtos'] !!}
    
            </div>

        </div>

    </div>


    <div id="divAvisoCarrinho" class="text-center p-2">
        <p id='avisoCarrinho'></p>
        <button type="button" class="btn-close" aria-label="Close" @click="fecharAlerta()"></button>
    </div>
    
    <script src="./js/loja.js"></script>
    

@endsection