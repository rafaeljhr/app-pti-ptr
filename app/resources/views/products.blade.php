<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

            @foreach($produtos[0] as $produto)

                <?php 


                    $image_path_filename = $produto->path_imagem;
                    $tagFavoritos = "fa fa-star";
                    if (!file_exists($image_path_filename)) {
                        $image_path_filename = "images/default_produto.jpg";
                    }
                    if($produtos[1] != 0 and get_class($produtos[1]) != 'Illuminate\Database\Eloquent\Collection' and $produtos[1]->contains($produto->id)) {
                        $tagFavoritos = "fa fa-star checked";
                    }
                ?>
                
                <div class="carta">
                    @if ($produtos[1] != 0)
                        <a id="hideAnchor" class="Estrela_Favoritos" onclick="AdicionarApagarFavorito(this, '{{ $produto->id }}', '{{ route('Add-Del-Fav') }}')">
                            <span class="{{$tagFavoritos}}"></span>
                        </a>
                    @endif
                    <a id="hideAnchor" class="Estrela_Favoritos" href="{{ URL::to('produtoDetalhes/'.$produto->id)}}">
                    
                        <img src="{{$image_path_filename}}" style="width:100%" />
                    </a>
                    <a id="hideAnchor" class="Estrela_Favoritos" onclick="AdicionarApagarFavorito(this, '{{ $produto->id }}', '{{ route('Add-Del-Fav') }}')">
                        <span class="{{$tagFavoritos}}"></span>
                    </a>
                    
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