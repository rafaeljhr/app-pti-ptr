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

    @if(session()->get('userType') == "consumidor")
        <h1 class="mt-5">ENCOMENDAS REALIZADAS</h1>
    @endif

    @if(session()->get('userType') == "fornecedor")
        <h1 class="mt-5">ENCOMENDAS A PROCESSAR</h1>
    @endif

    @if(session()->get('userType') == "transportadora")
        <h1 class="mt-5">ENCOMENDAS ATRIBUÍDAS PARA ENTREGA</h1>
    @endif

    @if(sizeOf(session()->get('all_encomendas')) != 0)

        <p  class="mt-5"><?php echo sizeOf(session()->get('all_encomendas')) ?> encomenda(s)</p>


        @for($i = 0; $i < sizeOf(session()->get('all_encomendas')); $i++)

            @if($i == 0)

            <div class="row mt-4 mx-auto w-100">

            @else 

            <div class="row mx-auto w-100">

            @endif

                <div class="col">
                    <h5>Encomenda Nº <?php echo session()->get('all_encomendas')[$i]['encomenda_id'] ?> - <?php echo session()->get('all_encomendas')[$i]['encomenda_estado_encomenda'] ?></h5>
                
                    <br>

                    <div class="row">
                        <div class="col">
                            <h6>Data e Hora</h6>
                        </div>

                        @if(session()->get('userType') == "consumidor")
                        <div class="col">
                            <h6>Fornecedor</h6>
                        </div>

                        <div class="col">
                            <h6>Transportadora</h6>
                        </div>
                        @endif

                        @if(session()->get('userType') != "consumidor")
                        <div class="col">
                            <h6>Cliente</h6>
                        </div>

                            @if(session()->get('userType') == "fornecedor")
                            <div class="col">
                                <h6>Transportadora</h6>
                            </div>
                            @endif

                            @if(session()->get('userType') == "transportadora")
                            <div class="col">
                                <h6>Fornecedor</h6>
                            </div>
                            @endif
                        @endif
                        
                        
                    </div>

                    <div class="row">
                        <div class="col">
                            <p><?php echo session()->get('all_encomendas')[$i]['encomenda_data_realizada']?></p>
                        </div>

                        @if(session()->get('userType') == "consumidor")
                        <div class="col">
                            <p><?php echo session()->get('all_encomendas')[$i]['encomenda_fornecedor_nome']?></p>
                        </div>

                        <div class="col">
                            <p><?php echo session()->get('all_encomendas')[$i]['encomenda_transportadora_nome']?></p>
                        </div>
                        @endif

                        @if(session()->get('userType') != "consumidor")
                        <div class="col">
                            <p><?php echo session()->get('all_encomendas')[$i]['encomenda_consumidor_nome']?></p>
                        </div>

                            @if(session()->get('userType') == "fornecedor")
                            <div class="col">
                                <p><?php echo session()->get('all_encomendas')[$i]['encomenda_transportadora_nome']?></p>
                            </div>
                            @endif

                            @if(session()->get('userType') == "transportadora")
                            <div class="col">
                                <p><?php echo session()->get('all_encomendas')[$i]['encomenda_fornecedor_nome']?></p>
                            </div>
                            @endif
                        @endif
                        
                        
                    </div>

                    <br>
                    
                    <h5 class="text-danger"><?php echo session()->get('all_encomendas')[$i]['encomenda_preco'] ?>€</h5>
                </div>

                <div class="col mx-auto my-auto">
                    <a href="{{ URL::to('encomenda/'.session()->get('all_encomendas')[$i]['encomenda_id']) }}">
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

