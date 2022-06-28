<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<?php

//dd(session()->all());
//session()->flush();

?>

<link rel="stylesheet" href="css/encomendas.css">

@extends('layouts.page_default')

@section('background')


<div class="encomendas mx-auto">

    <!-- Modal Cancelar Encomenda -->
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
    <div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>


    <!-- Modal Alterar estado encomenda -->
    <div class="modal fade" id="modalAlterarEstadoEncomenda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAlterarEstadoEncomenda" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
                <button type="button" class="btn-close" onclick="hide_modal_alterar()" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem a certeza que deseja alterar o estado da encomenda?</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary">Cancelar</button>
            <form method="post" action="{{ route('update-estado-encomenda') }}" name="alterar_estado" id="alterar_estado" >
                @csrf
                <input id='estado_a_colocar' type="text" value="" name="estado" hidden>
                <button type="submit" class="btn btn-danger">Confirmar</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    <div class="row mt-5 w-100">
        <div class="col">
            <h2>ESTADO DA ENCOMENDA</h2>
        </div>
        <div class="col">
            <a href="{{ URL::to('encomenda/json/'.session()->get('encomenda')['encomenda_id']) }}" class="download"><button class="btn btn-success" id="botao_criar">Download JSON da encomenda</button></a>
            
        </div>
    </div>
    

    <br>

    <div class="row mt-4 mx-auto w-100">

        <div class="col-5">
            <h6>ESTADO DA ENCOMENDA</h6>
        </div>

        <div class="col">
            <h6>DATA E HORA DA ENCOMENDA</h6>
        </div>

        <div class="col">
            <h6>DATA E HORA FINALIZADA</h6>
        </div>

        @if(session()->get('userType') == "consumidor" &&  session()->get('encomenda')['encomenda_estado_encomenda'] == "Cancelamento disponível")
            <div class="col">
            </div>
        @endif

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
            @if(session()->get('encomenda')['encomenda_data_finalizada'] != null)
            <p><?php echo session()->get('encomenda')['encomenda_data_finalizada']?></p>
            @else
            <p>Por entregar</p>
            @endif
        </div>

        @if(session()->get('userType') == "consumidor" && session()->get('encomenda')['encomenda_estado_encomenda'] == "Cancelamento disponível")
            <div class="col">
                <p class="detalhes text-danger" data-bs-toggle="modal" data-bs-target="#modalCancelarEncomenda">Cancelar encomenda</p>
            </div>
        @endif

    </div>

    @if(session()->get('userType') != "consumidor")

    <br>

        @if(session()->get('userType') == "fornecedor" && (session()->get('encomenda')['encomenda_estado_encomenda'] == "Em processamento pelo fornecedor" || session()->get('encomenda')['encomenda_estado_encomenda'] == "A aguardar recolha pela transportadora"))
            <div class="alterar_estado w-100">
                <h5 class="text-danger">ALTERAR ESTADO DA ENCOMENDA</h5>

                <br>
                    
                <div class="row">
                    <div class="col-1 my-auto">
                        <label for="estado" class="form-label">ESTADO</label>
                    </div>
                    <div class="col my-auto">
                        <select onchange="atribuir_estado_ao_input()" class="form-select" id='estado_selecionado'>
                            <option selected value="<?php echo session()->get('encomenda')['encomenda_estado_encomenda']?>"><?php echo session()->get('encomenda')['encomenda_estado_encomenda']?></option>
                            @for($i = 0; $i < sizeOf(session()->get('all_estados')); $i++)

                                @if(session()->get('all_estados')[$i]['estado_nome'] != session()->get('encomenda')['encomenda_estado_encomenda'])
                                    @if(session()->get('all_estados')[$i]['estado_nome'] == "Em processamento pelo fornecedor" || session()->get('all_estados')[$i]['estado_nome'] == "A aguardar recolha pela transportadora"))
                                        <option value="<?php echo session()->get('all_estados')[$i]['estado_nome']?>"><?php echo session()->get('all_estados')[$i]['estado_nome']?></option>
                                    @endif
                                @endif

                            @endfor
                        </select>
                    </div>
                </div>

                <br>

            </div>
        @endif

        @if(session()->get('userType') == "transportadora" && (session()->get('encomenda')['encomenda_estado_encomenda'] == "A aguardar recolha pela transportadora" || session()->get('encomenda')['encomenda_estado_encomenda'] == "Em recolha pela transportadora" || session()->get('encomenda')['encomenda_estado_encomenda'] == "Recolhida pela transportadora" || session()->get('encomenda')['encomenda_estado_encomenda'] == "Em distribuição"))
            <div class="alterar_estado w-100">
                <h5 class="text-danger">ALTERAR ESTADO DA ENCOMENDA</h5>

                <br>
                    
                <div class="row">
                    <div class="col-1 my-auto">
                        <label for="estado" class="form-label">ESTADO</label>
                    </div>
                    <div class="col my-auto">
                        <select onchange="atribuir_estado_ao_input()" class="form-select" id='estado_selecionado'>
                            <option selected value="<?php echo session()->get('encomenda')['encomenda_estado_encomenda']?>"><?php echo session()->get('encomenda')['encomenda_estado_encomenda']?></option>
                            @for($i = 0; $i < sizeOf(session()->get('all_estados')); $i++)

                                @if(session()->get('all_estados')[$i]['estado_nome'] != session()->get('encomenda')['encomenda_estado_encomenda'])
                                    @if(session()->get('all_estados')[$i]['estado_nome'] == "Em recolha pela transportadora" || session()->get('all_estados')[$i]['estado_nome'] == "Recolhida pela transportadora" || session()->get('all_estados')[$i]['estado_nome'] == "Em distribuição" || session()->get('all_estados')[$i]['estado_nome'] == "Concluída" || session()->get('all_estados')[$i]['estado_nome'] == "Encomenda estragou-se")
                                        <option value="<?php echo session()->get('all_estados')[$i]['estado_nome']?>"><?php echo session()->get('all_estados')[$i]['estado_nome']?></option>
                                    @endif
                                @endif

                            @endfor
                        </select>
                    </div>
                </div>

                <br>

            </div>
        @endif


    @endif

    <br>

    <h2 class="mt-5">ARTIGO ENCOMENDADO</h2>

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

    <h2 class="mt-5">FATURA</h2>

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

    <h2 class="mt-5">MORADAS</h2>
    <br>

        <div class="row w-100">
            <div class="col-3">
                <h5>Morada do cliente</h5>
                <hr class="dropdown-divider w-75">
                <p class="campo_morada mt-4"><?php echo session()->get('encomenda')['encomenda_consumidor_nome']?></p>
                <p class="campo_morada"><?php echo session()->get('encomenda')['encomenda_morada'] ?></p>
                <p class="campo_morada"><?php echo session()->get('encomenda')['encomenda_cidade'] ?>, <?php echo session()->get('encomenda')['encomenda_codigo_postal'] ?></p>
                <p class="campo_morada"><?php echo session()->get('encomenda')['encomenda_pais'] ?></p>
                <p class="campo_morada">T: <?php echo session()->get('encomenda_consumidor')['consumidor_numero_telemovel'] ?></p>
                <p class="campo_morada">NIF: <?php echo session()->get('encomenda_consumidor')['consumidor_numero_contribuinte'] ?></p>
    
            </div>
    
            <div class="col-3">
                @if (session()->get('userType') != "consumidor")
                    <h5>Morada do armazém</h5>
                @else
                    <h5>Origem do produto</h5>
                @endif
                
                <hr class="dropdown-divider w-75">
                <p class="campo_morada mt-4"><?php echo session()->get('encomenda')['encomenda_fornecedor_nome']?></p>
                <p class="campo_morada"><?php echo session()->get('encomenda_produto_armazem')['armazem_morada'] ?></p>
                <p class="campo_morada"><?php echo session()->get('encomenda_produto_armazem')['armazem_cidade'] ?>, <?php echo session()->get('encomenda_produto_armazem')['armazem_codigo_postal'] ?></p>
                <p class="campo_morada"><?php echo session()->get('encomenda_produto_armazem')['armazem_pais'] ?></p>
                <p class="campo_morada">T: <?php echo session()->get('encomenda_fornecedor')['fornecedor_numero_telemovel'] ?></p>
                <p class="campo_morada">NIF: <?php echo session()->get('encomenda_fornecedor')['fornecedor_numero_contribuinte'] ?></p>
        
            </div>

            @if (session()->get('userType') != "consumidor")
                <div class="col-3">
                    <h5>Morada da base que recolhe</h5>
                    <hr class="dropdown-divider w-75">
                    <p class="campo_morada mt-4"><?php echo session()->get('encomenda')['encomenda_transportadora_nome']?></p>
                    <p class="campo_morada"><?php echo session()->get('encomenda_base')['base_morada'] ?></p>
                    <p class="campo_morada"><?php echo session()->get('encomenda_base')['base_cidade'] ?>, <?php echo session()->get('encomenda_base')['base_codigo_postal'] ?></p>
                    <p class="campo_morada"><?php echo session()->get('encomenda_base')['base_pais'] ?></p>
                    <p class="campo_morada">T: <?php echo session()->get('encomenda_transportadora')['transportadora_numero_telemovel'] ?></p>
                    <p class="campo_morada">NIF: <?php echo session()->get('encomenda_transportadora')['transportadora_numero_contribuinte'] ?></p>
            
                </div>
            @endif
        </div>

    
    
    <br><br><br>
</div>


<script src="./js/encomenda.js"></script>

@endsection

