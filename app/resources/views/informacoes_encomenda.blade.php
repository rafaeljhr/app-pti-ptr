<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

//dd(session()->all());
//session()->forget('bases');

?>

<link rel="stylesheet" href="css/encomendas.css">

@extends('layouts.page_default')

@section('background')


<div class="encomendas mx-auto">

    <!-- Modal Apagar Conta -->
    <div class="modal fade" id="modalCancelarEncomenda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCancelarEncomendaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem a certeza que deseja cancelar a sua encomenda?</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form method="post" action="{{ route('cancelar-encomenda') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Confirmar</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    <h3 class="mt-5">ESTADO DA ENCOMENDA</h3>

    <br>

    <div class="row mt-4 mx-auto w-100">

        <div class="col-5">
            <h6>ESTADO DA ENCOMENDA</h6>
        </div>

        <div class="col">
            <h6>DATA E HORA DA ENCOMENDA</h6>
        </div>

    </div>

    <br>

    <hr class="dropdown-divider" style="margin: auto;">

    <br>

    <div class="row mx-auto w-100">

        <div class="col-5">
            <p><?php echo session()->get('encomenda')['encomenda_estado_encomenda']?></p>
        </div>

        <div class="col">
            <p><?php echo session()->get('encomenda')['encomenda_data_realizada']?></p>
        </div>

        <div class="col">
            @if(session()->get('encomenda')['encomenda_estado_encomenda'] == "Cancelamento disponível")
                <p class="detalhes text-danger" data-bs-toggle="modal" data-bs-target="#modalCancelarEncomenda">Cancelar encomenda</p>
            @else
                <p>Cancelamento de encomenda indisponível</p>
            @endif
        </div>

    </div>

    <br>

    <hr class="dropdown-divider" style="margin: auto;">

    <br>

    <h3 class="mt-5">ARTIGO ENCOMENDADO</h3>

    <br>

    <div class="row mt-4 mx-auto w-100">

        <div class="col-5">
            <h6>PRODUTO</h6>
        </div>

        <div class="col">
            <h6>CATEGORIA</h6>
        </div>


        <div class="col">
            <h6>SUBCATEGORIA</h6>
        </div>

        <div class="col">
            <h6>PREÇO</h6>
        </div>

        <div class="col">
            <h6>QUANTIDADE</h6>
        </div>

    </div>

    <br>

    <hr class="dropdown-divider" style="margin: auto;">

    <br>

    <div class="row mx-auto w-100">

        <div class="col-5">
            <p><?php echo session()->get('encomenda_produto')['produto_nome'] ?></p>
        </div>

        <div class="col">
            <p><?php echo session()->get('encomenda_produto')['produto_nome_categoria'] ?></p>
        </div>


        <div class="col">
            <p><?php echo session()->get('encomenda_produto')['produto_nome_subcategoria'] ?></p>
        </div>

        <div class="col">
            <p class="text-danger"><?php echo session()->get('encomenda_produto')['produto_preco'] ?>€</p>
        </div>

        <div class="col">
            <p><?php echo session()->get('encomenda')['encomenda_quantidade'] ?></p>
        </div>

    </div>

    <br>

    <hr class="dropdown-divider" style="margin: auto;">

    <br>

    <h3 class="mt-5">FATURA</h3>

    <br>

    <div class="recibo">
        <br>

        <div class="row mx-auto w-100" >
            <div class="col-6">

            </div>
            <div class="col">
                <p class="preco_info">Subtotal</p>
            </div>
            <div class="col">
                <p><?php echo session()->get('encomenda')['encomenda_preco']?>€</p>
            </div>

        </div>
        <div class="row mt-2 mx-auto w-100" >
            <div class="col-6">

            </div>
            <div class="col">
                <p class="preco_info">Custo de envio</p>
            </div>
            <div class="col">
                <p class=><?php echo session()->get('encomenda')['encomenda_preco_transporte']?>€</p>
            </div>

        </div>
        <div class="row mt-2 mx-auto w-100" >
            <div class="col-6">

            </div>
            <div class="col">
                <p class="preco_info">Total (s/IVA)</p>
            </div>
            <div class="col">
                <p><?php echo round((session()->get('encomenda')['encomenda_preco'])/1.23, 2)?>€</p>
            </div>

        </div>
        <div class="row mt-2 mx-auto w-100" >
            <div class="col-6">

            </div>
            <div class="col">
                <p class="preco_info">IVA (23%)</p>
            </div>
            <div class="col">
                <p><?php echo round(session()->get('encomenda')['encomenda_preco']-((session()->get('encomenda')['encomenda_preco'])/1.23), 2)?>€</p>
            </div>

        </div>
        <div class="row mt-2 mx-auto w-100" >
            <div class="col-6">

            </div>
            <div class="col">
                <p class="preco_info">Total (c/IVA)</p>
            </div>
            <div class="col">
                <h5 class="text-danger"><?php echo session()->get('encomenda')['encomenda_preco']?>€</h5>
            </div>

        </div>

        <br>
    </div>


    <br>

    <h3 class="mt-5">ENTREGA</h3>

    <br>

    <div class="row mt-4 mx-auto w-100">

        <div class="col-5">
            <h6>MORADA</h6>
        </div>

        <div class="col">
            <h6>CÓDIGO POSTAL</h6>
        </div>


        <div class="col">
            <h6>CIDADE</h6>
        </div>

        <div class="col">
            <h6>PAÍS</h6>
        </div>

    </div>

    <br>

    <hr class="dropdown-divider" style="margin: auto;">

    <br>

    <div class="row mx-auto w-100">

        <div class="col-5">
            <p><?php echo session()->get('encomenda')['encomenda_morada'] ?></p>
        </div>

        <div class="col">
            <p><?php echo session()->get('encomenda')['encomenda_codigo_postal'] ?></p>
        </div>


        <div class="col">
            <p><?php echo session()->get('encomenda')['encomenda_cidade'] ?></p>
        </div>

        <div class="col">
            <p><?php echo session()->get('encomenda')['encomenda_pais'] ?></p>
        </div>

    </div>

    <hr class="dropdown-divider" style="margin: auto;">
    


    <br><br><br><br>
</div>


@endsection

