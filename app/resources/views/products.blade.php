<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<?php

//dd(session()->all());

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
                    <button type="button" class="btn btn-outline-primary mb-2">Ver informações do produto</button>
                    <button @click="add2Carrinho('<?php echo session()->get('all_fornecedores_produtos')[$i]['produto_id'] ?>', '<?php echo session()->get('all_fornecedores_produtos')[$i]['produto_nome'] ?>')" id="addCartButton" type="button" class="btn btn-outline-primary" name="{{ route('product-add-carrinho') }}">Adicionar ao carrinho</button> 
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

    <div id="divAvisoCarrinho" class="text-center p-2">
        <p id='avisoCarrinho'></p>
        <button type="button" class="btn-close" aria-label="Close" @click="fecharAlerta()"></button>
    </div>

    <script src="./js/loja.js"></script>

@endsection