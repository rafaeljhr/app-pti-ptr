<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<link rel="stylesheet" href="css/inventory.css">

@extends('layouts.page_default')

@section('background') 

    {{-- mostrar todos os produtos --}}
        <div class="Div_Filtros_Produtos">
            <form action="javascript:;" onsubmit="Filtros(this, '{{ route('ProductFilter') }}' )">
                <h3>Filtros</h3>
                <br>
                <button type="submit">Pesquisar</button>
                <br>
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

        <div id='todosProdutos' class="Div_Produtos">

            {!! $data['produtos'] !!}

        </div>


    <div id="divAvisoCarrinho" class="text-center p-2">
        <p id='avisoCarrinho'></p>
        <button type="button" class="btn-close" aria-label="Close" @click="fecharAlerta()"></button>
    </div>
    
    <script src="./js/loja.js"></script>
    

@endsection