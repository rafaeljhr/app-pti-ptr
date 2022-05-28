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

    <h1 class="mt-5">As suas encomendas</h1>

    @if(sizeOf(session()->get('all_encomendas')) != 0)

        <p  class="mt-5"><?php echo sizeOf(session()->get('all_encomendas')) ?> encomenda(s)</p>


        @for($i = 0; $i < sizeOf(session()->get('all_encomendas')); $i++)

            <?php

                if (session()->get('all_encomendas')[$i]['encomenda_estado_encomenda'] == "cancelamento") {
                    $estado = "Cancelamento disponível";

                } else if (session()->get('all_encomendas')[$i]['encomenda_estado_encomenda'] == "processamento") {
                    $estado = "Em processamento pelo fornecedor";

                } else if (session()->get('all_encomendas')[$i]['encomenda_estado_encomenda'] == "pronta a recolher") {
                    $estado = "A aguardar recolha pela transportadora";
                    
                } else if (session()->get('all_encomendas')[$i]['encomenda_estado_encomenda'] == "recolhida") {
                    $estado = "Recolhida pela transportadora";
                    
                } else if (session()->get('all_encomendas')[$i]['encomenda_estado_encomenda'] == "em distribuição") {
                    $estado = "Em distribuição";
                    
                } else if (session()->get('all_encomendas')[$i]['encomenda_estado_encomenda'] == "entregue") {
                    $estado = "Concluída";
                    
                }

            ?>

            @if($i == 0)

            <div class="row mt-4 mx-auto w-100 encomenda">

            @else 

            <div class="row mx-auto w-100 encomenda">

            @endif

                <div class="col">
                    <h5>Encomenda Nº <?php echo session()->get('all_encomendas')[$i]['encomenda_id'] ?> - <?php echo $estado ?></h5>
                
                    <p><?php echo session()->get('all_encomendas')[$i]['encomenda_data_realizada'] ?></p>
                    <p class="text-danger"><?php echo session()->get('all_encomendas')[$i]['encomenda_preco'] ?>€</p>
                </div>

                <div class="col mx-auto my-auto">
                    <a href="">
                        <h5 class="detalhes">VER DETALHES</h5>
                    </a>
                </div>

            </div>

            <br>

            <hr class="dropdown-divider" style="margin: auto;">

            <br>
        
        
        
        @endfor

    @else 

        <br><br>
        <h5>Não possui qualquer encomenda realizada!</h5>

    @endif

</div>


@endsection

