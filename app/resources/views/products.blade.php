<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  </head>

<?php

// dd(session()->all());

?>

<link rel="stylesheet" href="css/inventory.css">

@extends('layouts.page_default')

@section('background') 

    {{-- mostrar todos os produtos --}}
    <div class="container p-0 mt-5 mb-5">
    <div id='todosProdutos'>

        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">

        @if(session()->get('all_fornecedores_produtos')!=null)
            @for($i = 0; $i < sizeOf(session()->get('all_fornecedores_produtos')); $i++) 
            
            <div class="col">
                <div class="card">
                <h5 class="card-title"><?php echo session()->get('all_fornecedores_produtos')[$i]['produto_nome'] ?></h5>
                <h4 class="card-text text-danger"><?php echo session()->get('all_fornecedores_produtos')[$i]['produto_preco'] ?> €</h4>
                <img src='<?php echo session()->get('all_fornecedores_produtos')[$i]['produto_path_imagem'] ?>' class="imagemProduto card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo session()->get('all_fornecedores_produtos')[$i]['produto_informacoes_adicionais'] ?></h5>
                    <button type="button" class="btn btn-outline-primary">Ver informações do produto</button>   
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

    </div>
    </div>

@endsection