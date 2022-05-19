<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<?php
$subTotal = 0;
$custoEntrega = 5;
/* session()->forget('carrinho_produtos'); */
/* dd(session()->all()); */
?>

<link rel="stylesheet" href="css/carrinho.css">

@extends('layouts.page_default')

@section('background') 

    <div class="container mt-5 px-4">

    <div class="row">

        <div class="col-md-8">

            <div class="card overflow-auto p-3 mb-3 lista-produtos">

                {{-- mostrar todos os produtos --}}
                <div class="container px-2 mt-2 mb-5">
                    
                    <h5>O teu carrinho</h5>

                    <hr>

                    <div id='todosProdutos'>
            
                        @if(session()->get('carrinho_produtos')!=null)
                        @for($i = 0; $i < sizeOf(session()->get('carrinho_produtos')); $i++) 

                        <?php
                            $subTotal += session()->get('carrinho_produtos')[$i]['produto_preco']; 
                        ?>

                            <div id="<?php echo $i ?>" class="row px-2">
                                <div class="col-md-4">
                                    <img src='<?php echo session()->get('carrinho_produtos')[$i]['produto_path_imagem'] ?>' class="imagemProduto card-img-top">
                                </div>

                                <div class="col-md-6">
                                    <h5 class="card-title"><?php echo session()->get('carrinho_produtos')[$i]['produto_nome'] ?></h5>
                                    <h4 class="card-text text-danger"><?php echo session()->get('carrinho_produtos')[$i]['produto_preco'] ?> €</h4>
                                    <h5 class="card-title"><?php echo session()->get('carrinho_produtos')[$i]['produto_informacoes_adicionais'] ?></h5>
                                    <label for="quantity">Qtd.</label>
                                    <input class="ms-2" type="number" id="quantity" name="quantity" min="1" max="99" value="1">
                                </div>
                                    
                                <div class="col-md-2">  
                                    <button id="removeCartButton" type="button" class="btn-close" aria-label="Close" name="{{ route('product-remove-carrinho') }}" @click="removeProduto('<?php echo $i ?>', '<?php echo session()->get('all_fornecedores_produtos')[$i]['produto_nome'] ?>')"></button>
                                </div>

                                <hr>

                            </div>
                                
                        @endfor
                        @endif
                
                    </div>
                </div>
            </div>
        </div>
    

        <div class="col-md-4">

            <div class="card p-3 mt-2 mb-3">

                <h5>TOTAL</h5>  

                <hr>

                <div class="row">

                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Sub-total:</h6>
                    </div>

                    <div class="col-md-6 text-end">
                        <p><?php echo $subTotal ?>€</p>
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
                        <p><?php echo ($custoEntrega + $subTotal) ?>€</p>
                    </div>
                </div>

                <button type="button" class="btn btn-success">CHECKOUT</button>
                
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