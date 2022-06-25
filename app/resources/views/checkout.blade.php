<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<?php
$subTotal = 0;
$kwhConsumidos = 0;
$custoEntrega = 0;

$basesDistancias = session()->get('basesDistancias');

/* session()->forget('carrinho_produtos'); */
/* dd(session()->all()); */
?>

<link rel="stylesheet" href="css/carrinho.css">

@extends('layouts.page_default')

@section('background') 

    <div class="container mt-5 px-4">

    <div class="row">

        <div class="col-md-8">

            <div class="card overflow-auto p-3 mt-1 lista-produtos">

                {{-- mostrar todos os produtos --}}
                <div id="productsContainer" class="container px-2 mt-2 mb-5">

                    @if(session()->get('carrinho_produtos')!=null)
                        <h5 id="msgCarrinho">O teu carrinho</h5>
                    @else
                        <h5>O teu carrinho está vazio, <a href="{{ route('products') }}"> adiciona</a> algo para o fazer feliz!</h5>
                    @endif

                    <hr>

                    <form id="checkout" method="post" action="{{ route('submit-nova-encomenda') }}" enctype="multipart/form-data">
                        @csrf
                        <div id='todosProdutos'>
                    @if(session()->get('carrinho_produtos')!= null)
                        @for($i = 0; $i < sizeOf(session()->get('carrinho_produtos')); $i++) 

                            <?php
                                $subTotal += session()->get('carrinho_produtos')[$i]['preco'];
                                $kwhConsumidos += session()->get('carrinho_produtos')[$i]['kwh_consumidos_por_dia_no_armazem'];
                            ?>

                            <div id="<?php echo $i ?>" class="row px-2">
                                <div class="col-md-4 mb-2">
                                    <img src='<?php echo session()->get('carrinho_produtos')[$i]['produto_path_imagem'] ?>' class="imagemProduto card-img-top">
                                </div>

                                <div class="col-md-6">
                                    <h5 id="name<?php echo $i ?>" class="card-title"><?php echo session()->get('carrinho_produtos')[$i]['nome'] ?></h5>
                                    <h4 class="card-text text-danger productPrice"><?php echo session()->get('carrinho_produtos')[$i]['preco'] ?> €</h4>
                                    <h5 class="card-title"><?php echo session()->get('carrinho_produtos')[$i]['informacoes_adicionais'] ?></h5>
                                    <label for="quantidade">Qtd.</label>
                                    <input @input="calculatePrices" class="ms-2 quantity" type="number" id="quantity<?php echo $i ?>" name="quantity<?php echo $i ?>" min="1" max="99" value="1">
                                    <br>
                                    <label for="transportadoras<?php echo $i ?>">Base de Transporte:</label>
                                    <select class="mb-2" name="id_base<?php echo $i ?>" id="base<?php echo $i ?>">
                                        @for($x = 0; $x < (sizeOf($basesDistancias[$i])); $x++)
                                            <option value="<?php echo $basesDistancias[$i][$x]["id_base"] ?>">Nome: <?php echo $basesDistancias[$i][$x]["nome"] ?> | Distância: <?php echo $basesDistancias[$i][$x]["dist"] ?>m | Preço: <?php echo $basesDistancias[$i][$x]["price"] ?> €</option>
                                        @endfor
                                    </select>
                                </div>
                                    
                                <div class="col-md-2">  
                                    <button id="removeCartButton" type="button" class="btn-close" aria-label="Close" name="{{ route('Add-Del-Carrinho') }}" @click="removeProduto('<?php echo $i ?>', '<?php echo session()->get('carrinho_produtos')[$i]['id'] ?>')"></button>
                                </div>

                                <hr>

                            </div>
                            
                        @endfor
                    @else
                
                        <img class="mx-auto emptyCart" src="images/empty_cart.png" alt="Empty Box">
                    
                    @endif

                        <img v-show="emptyCart" class="mx-auto emptyCart" src="images/empty_cart.png" alt="Empty Box">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    

        <div class="col-md-4">

            <div class="card p-3 mt-2 mb-3">

                <h5>TOTAL</h5>  

                <hr>

                <div class="row">

                    <div class="col-md-6">
                        <h6 class="font-weight-bold">kWh consumidos:</h6>
                    </div>

                    <div class="col-md-6 text-end">
                        <p ref="kwConsumed" id="kwConsumed"><?php echo $kwhConsumidos ?> KW/H</p>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Sub-total:</h6>
                    </div>

                    <div class="col-md-6 text-end">
                        <p ref="subTotal" id="subTotal"><?php echo $subTotal ?>€</p>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Custo de Entrega:</h6>
                    </div>

                    <div class="col-md-6 text-end">
                        <p><?php echo $custoEntrega ?>€</p>
                    </div>
                </div>

                <hr>

                <div class="row">

                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Custo Total:</h6>
                    </div>

                    <div class="col-md-6 text-end">
                        <p ref="totalCost"><?php echo ($custoEntrega + $subTotal) ?>€</p>
                    </div>
                </div>

                @if(session()->get('loggedIn')=="yes")
                    <button type="submit" form="checkout" class="btn btn-success">CHECKOUT</button>
                @else
                    <button type="submit" form="checkout" class="btn btn-success" disabled>CHECKOUT</button>
                    <p class="mt-2 text-danger">É necessário registar-se / fazer login antes de poder realizar a encomenda</p>
                @endif
                
                
            </div>
            
        </div>
        
    </div>
    
    </div>

    <div id="divAvisoCarrinho" class="text-center p-2">
        <p id='avisoCarrinho'></p>
        <button type="button" class="btn-close" aria-label="Close" @click="fecharAlerta()"></button>
    </div>

    <script src="./js/carrinho.js"></script>
@endsection