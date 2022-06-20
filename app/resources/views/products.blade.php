<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<?php

function isInCarrinho($productID) {

    if (session()->has('carrinho_produtos')) {
        for ($x = 0; $x < sizeOf(session()->get('carrinho_produtos')); $x++) {
            if (session()->get('carrinho_produtos')[$x]['produto_id'] === $productID) {
                return true;
            }
        }

        return false;
    } else {
        return false;
    }
}

?>

<link rel="stylesheet" href="css/inventory.css">

@extends('layouts.page_default')

@section('background') 

    {{-- mostrar todos os produtos --}}
        <div class="Div_Filtros_Produtos">
            ewq
        </div>

        <div id='todosProdutos' class="Div_Produtos">

            @foreach($produtos as $produto)

                <?php 
                    $image_path_filename = $produto->path_imagem;
                    if (!file_exists($image_path_filename)) {
                        $image_path_filename = "images/default_produto.jpg";
                    }
                ?>
                
                <div class="carta">
                    <img src="{{$image_path_filename}}" style="width:100%" />
                    <h4>{{$produto->nome}}</h4>
                    <p class="price">{{$produto->preco}}€</p>
                    <p><button>Add to Cart</button></p>
                </div>

            @endforeach

        </div>


    <div id="divAvisoCarrinho" class="text-center p-2">
        <p id='avisoCarrinho'></p>
        <button type="button" class="btn-close" aria-label="Close" @click="fecharAlerta()"></button>
    </div>

    <script src="./js/loja.js"></script>

    

@endsection