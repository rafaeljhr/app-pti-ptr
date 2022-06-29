<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bases_veiculos.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

@extends('layouts.page_default')

@section('background')
    
<?php

// dd(session()->all());

$co2 = 0;
$kwhCadeias = 0;

for($i = 0; $i < sizeOf(session()->get('cadeias_produto_atual'));  $i++){
    $co2 = $co2 + session()->get('cadeias_produto_atual')[$i]['evento_co2_produzido'];
    $kwhCadeias = $kwhCadeias + session()->get('cadeias_produto_atual')[$i]['evento_kwh_consumidos'];
}

$now = time(); // or your date as well
$your_date = strtotime(session()->get('produto_atual')['produto_data_insercao_no_site']);
$datediff = ceil(($now - $your_date)/86400);
$kwhStorage = session()->get('produto_atual')['produto_kwh_consumidos_por_dia'] * $datediff;

$kwh_consumidos = $kwhCadeias + $kwhStorage;

?>


<div class="container py-5">

    <!-- Modal Apagar Produto -->
    <div class="modal fade" id="modalApagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalApagarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem a certeza que deseja apagar o seu produto?</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form method="post" action="{{ route('product-remove') }}">
                @csrf
                <input hidden value="<?php echo session()->get('produto_atual')['produto_id']?>" name="id_produto">
                <button type="submit" class="btn btn-danger">Confirmar</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal Mudar Avatar -->
    <div class="modal fade" id="modalMudarAvatar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalMudarPassLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMudarPassLabel">Alterar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div ref="tab_imagem" class="tab" id='tab_da_imagem'>
                <div class="form-outline mb-4 text-center">
                    <br>
                    <h3 id="titulo_imagem" class="mb-3">Imagem Atual</h3>
                    <img src="<?php echo session()->get('produto_atual')['produto_path_imagem'] ?>" id="imagem_a_alterar" class="mx-auto" alt="">
                </div>
            </div>

            <form id="changeAvatar" method="post" action="{{ route('update-imagem-produto-controller') }}" enctype="multipart/form-data">
                @csrf
                <input onchange="alterarImagem(event)" ref="redUploadImagem" type="file" name="mudar_path_imagem" class="w-50 adicionar-foto d-grid mx-auto">
            </form>

            <div id="submitChangeAvatar" class="modal-footer" style="display: none">
                <button type="submit" form="changeAvatar" class="btn btn-danger">Confirmar</button>
                
            </div>

        </div>
        </div>
    </div>

{{-- /////////////////////////////////////////////////////////////////////////////////// --}}
    <div class="form-div mx-auto my-1 px-3">

        <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">INFORMAÇÕES DO PRODUTO</h1>
        
        <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('produto_atual')['produto_path_imagem'] ?>" referrerpolicy="no-referrer">
        <div class="mt-2 w-25 mx-auto">
            <button type="button" class="btn form-control alterar_imagem_botao" data-bs-toggle="modal" data-bs-target="#modalMudarAvatar">ALTERAR IMAGEM</button>
        </div>

        <br>

        <div class="px-4">
            <form id="prod-edit" method="post" action="{{ route('product-edit-controller') }}">
                @csrf

                <div class="row">

                    <div class="col">
                        <label class="form-label" for="nome">Nome</label>
                        <div class="input-group mb-3">
                            <input ref="nome" type="text" name="nome" class="form-control mb-3" value="<?php echo session()->get('produto_atual')['produto_nome'] ?>" :disabled="!editable" required>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col">
                        <label class="form-label" for="preco">Preço</label>
                        <div class="input-group mb-3">
                            <input ref="preco" type="number" name="preco" class="form-control mb-3" value="<?php echo session()->get('produto_atual')['produto_preco'] ?>" :disabled="!editable" required>
                        </div>
                    </div>

                    <div class="col">
                        <label class="form-label" for="quantidade">Quantidade</label>
                        <div class="input-group mb-3">
                            <input ref="quantidade" type="number" name="quantidade" class="form-control w-50" value="<?php echo session()->get('produto_atual')['produto_quantidade'] ?>" :disabled="!editable" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col">
                        <label for="form-label" class="mb-2">Data de produção</label>
                        <div class="input-group mb-3">
                            <input ref="data_p" type="date" name="data_p" class="form-control" value="<?php echo session()->get('produto_atual')['produto_data_producao_do_produto']  ?>" :disabled="!editable" required>
                        </div>
                    </div>

                    <div class="col">
                        <label for="data_i" class="mb-2">Data de inserção</label>
                        <div class="input-group mb-3">
                            <input ref="data_i" type="date" name="data_i" class="form-control" value="<?php echo session()->get('produto_atual')['produto_data_insercao_no_site'] ?>" :disabled="!editable" required>
                        </div>
                    </div>
                </div>


                <div class ="row">
                    <label class="form-label" for="kwh">Consumo energético diário pelo armazenamento em armazém</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">KWh</span>
                        <input type="number" ref="kwh" step="any" class="form-control" name="kwh" value="<?php echo session()->get('produto_atual')['produto_kwh_consumidos_por_dia'] ?>" id="novo_produto_preco" :disabled="!editable" required>
                    </div>

                </div>

                <div class ="row">
                    <label class="form-label" for="info">Informações complementares</label>
                    <div class="input-group mb-3">
                        <textarea ref="info" name="info" class="form-control" aria-label="Informações adicionais" value="<?php echo session()->get('produto_atual')['produto_informacoes_adicionais'] ?>" rows="5" id="novo_produto_infos_adicionais" :disabled="!editable" required></textarea>
                    </div>
                </div>


                <div class="row" >
                    <div class="col">
                        <label for="nome_categoria" class="form-label">Categoria do produto</label>
                        <div class="input-group mb-3">
                            <select ref="cat" @input="checkForm()" class="form-control" @change="changeSubcat($event)" name="nome_categoria" id="novo_produto_categoria" value="<?php echo session()->get('produto_atual')['produto_nome_categoria'] ?>" disabled >
                                <option value="">-- Selecione uma categoria --</option>
                                @for($i = 0; $i < sizeOf(session()->get('categories')); $i++)
                                <?php $category= session()->get('categories')[$i] ?>
                                <option value='<?php echo session()->get('categories')[$i]['category_nome'] ?>'><?php echo session()->get('categories')[$i]['category_nome'] ?></option>              
                                @endfor
                            </select>
                        </div>
                    </div>
            
                    <div class="col">
                        <input id="routeSubCat" name="{{ route('product-changeSub') }}" hidden>           
                        <div id="toChangeOnCmd">
                            <label for="nome_subcategoria" class="form-label">Subcategoria do produto</label>
                            <div class="input-group mb-3">
                                <select ref="subcat" class="form-control" name="nome_subcategoria" id="novo_produto_subcategoria" :disabled="!editable" required>
                                <option selected value="<?php echo session()->get('produto_atual')['produto_nome_subcategoria'] ?>"><?php echo session()->get('produto_atual')['produto_nome_subcategoria'] ?></option>
                                </select>
                            </div>
                        </div>       
                    </div>
            
                </div>

                <br>

                <h3>Campos específicos do produto</h3>

                <div id="camposExtraNone">
                    <div class="row mt-3">
                        @for($i = 0; $i < sizeOf(session()->get('campos_extra_atuais')); $i++)
                            <div class ="col">
                                <label class="mb-2" for="<?php echo session()->get('campos_extra_atuais')[$i]['campo_extra'] ?>"><?php echo session()->get('campos_extra_atuais')[$i]['nome_campo_extra'] ?></label>
                                <div class="input-group mb-3">
                                    <input oninput="checkCampoExtra()" type="text" name="<?php echo session()->get('campos_extra_atuais')[$i]['campo_extra'] ?>" class="form-control mb-3" value="<?php echo session()->get('campos_extra_atuais')[$i]['valor_campo'] ?>" :disabled="!editable" required>
                                </div>
                            </div>

                            @if($i > 0 && ($i+1) % 3==0)
                            </div>
                            <div class="row">
                            @endif

                        @endfor
                    </div>    
                </div>

                <br>

                <h3>Poluição e recursos consumidos</h3>

                <div class="row">
                    <label class="mb-2" for="kwh_consumidos">Energia consumida com o produto até agora</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">KWh</span>
                        <input type="number" step="any" class="form-control" name="kwh_consumidos" disabled value="<?php echo $kwh_consumidos ?>">
                        </div>
                </div>

                <div class="row">
                    <label class="mb-2" for="co2_emissao">CO2 emitido pelo produto até agora</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">kg</span>
                        <input type="number" step="any" class="form-control" name="co2_emissao" disabled value="<?php echo $co2 ?>">
                        </div>
                </div>

                <br>

                <div id='armazem _do_produto' class="text-center">

                    <h3 class="mt-3 mb-2 text-center">Armazém do produto</h3>
                    <br>

                    <div class="card solo_veiculo mx-auto">
                        <img class="card-img-top imagem_da_card" src='<?php echo session()->get('produto_atual_armazem')['armazem_path_imagem'] ?>'>
    
                        <h4 class="card-title mt-3 text-center"><?php echo session()->get('produto_atual_armazem')['armazem_nome'] ?></h4>
    
                        <div class="card-body text-center">
                        <div class="row">
                            <div class="col">
                            <p>
                                <?php
        
                                $num_produtos = 0;
                                foreach (session()->get('all_fornecedor_produtos') as $produto) {

                                    if ($produto['produto_id_armazem'] == session()->get('produto_atual_armazem')['armazem_id']) {
                                    $num_produtos += $produto['produto_quantidade'];
                                    }

                                }
        
                                echo 'Quantidade de produtos no armazém: ' . $num_produtos;
        
                                ?>
                            </p>
                            </div>
                        </div>
                        
                        <a href="{{ URL::to('storage/'.session()->get('produto_atual_armazem')['armazem_id']) }}">
                            <button type="button" class="btn btn-info botoes_veiculos">Detalhes</button>
                        </a>
                        </div>
        
                    </div>
                </div>

                <br>

                <div class="position-relative my-1">
                    <button v-show="!editable" type="button" class="btn btn-long btn-success" @click="editable = true">EDITAR PRODUTO</button>
                    <button v-show="editable" type="submit" class="btn btn-long btn-warning me-3" id="guardar_alteracoes">GUARDAR ALTERAÇÕES</button>
                    <button v-show="editable" type="button" class="btn btn-long btn-primary" @click="cancelChanges()">CANCELAR ALTERAÇÕES</button>
                    <button type="button" class="btn btn-danger position-absolute end-0" data-bs-toggle="modal" data-bs-target="#modalApagar">APAGAR PRODUTO</button>
                </div>

            </form>
            </div>
        </div>
    </div>  

</div>


<script src="./js/informacoes_produto.js"></script>
    
@endsection