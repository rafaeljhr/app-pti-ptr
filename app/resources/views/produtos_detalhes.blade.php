<link rel="stylesheet" href="css/inventory.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@extends('layouts.page_default')

@section('background') 

<?php
$produtoAtual = session()->get('produto_detalhes')['produto_id'];
function isInCarrinho() {

    if(session()->get('carrinho_produtos')!=null) {

        $cart = session()->get('carrinho_produtos');
        foreach ($cart as $key=>$prod){
            
            if ($cart[$key]->id == session()->get('produto_detalhes')['produto_id']){
                return true; 
            }
        } 
        return false;
    }
}


$co2 = 0;
$kwhCadeias = 0;

for($i = 0; $i < sizeOf(session()->get('cadeias_produto_atual'));  $i++){
    $co2 = $co2 + session()->get('cadeias_produto_atual')[$i]['evento_co2_produzido'];
    $kwhCadeias = $kwhCadeias + session()->get('cadeias_produto_atual')[$i]['evento_kwh_consumidos'];
}

$now = time(); // or your date as well
$your_date = strtotime(session()->get('produto_detalhes')['produto_data_insercao_no_site']);
$datediff = ceil(($now - $your_date)/86400);
$kwhStorage = session()->get('produto_detalhes')['produto_kwh_consumidos_por_dia_no_armazem'] * $datediff;

$kwh_consumidos = $kwhCadeias + $kwhStorage;

?>

<div class="container py-5">

    <div class="form-div mx-auto my-1 px-3">

        <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">INFORMAÇÕES DO PRODUTO</h1>
        
        <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('produto_detalhes')['produto_path_imagem'] ?>" referrerpolicy="no-referrer">

        <br>

        <div class="px-4">
            <form id="prod-edit" method="post" action="#">
                @csrf

                <div class="row">

                    <div class="col">
                        <label class="form-label" for="nome">Nome</label>
                        <div class="input-group mb-3">
                            <input type="text" name="nome" class="form-control mb-3" value="<?php echo session()->get('produto_detalhes')['produto_nome'] ?>" disabled>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col">
                        <label class="form-label" for="preco">Preço</label>
                        <div class="input-group mb-3">
                            <input type="number" name="preco" class="form-control mb-3" value="<?php echo session()->get('produto_detalhes')['produto_preco'] ?>" disabled>
                        </div>
                    </div>

                    <div class="col">
                        <label class="form-label" for="quantidade">Quantidade</label>
                        <div class="input-group mb-3">
                            <input type="number" name="quantidade" class="form-control w-50" value="<?php echo session()->get('produto_detalhes')['produto_quantidade'] ?>" disabled>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col">
                        <label for="form-label" class="mb-2">Data de produção</label>
                        <div class="input-group mb-3">
                            <input type="date" name="data_p" class="form-control" value="<?php echo session()->get('produto_detalhes')['produto_data_producao_do_produto']  ?>" disabled>
                        </div>
                    </div>

                    <div class="col">
                        <label for="data_i" class="mb-2">Data de inserção</label>
                        <div class="input-group mb-3">
                            <input type="date" name="data_i" class="form-control" value="<?php echo session()->get('produto_detalhes')['produto_data_insercao_no_site'] ?>" disabled>
                        </div>
                    </div>
                </div>


                <div class ="row">
                    <label class="form-label" for="kwh">Consumo energético diário pelo armazenamento em armazém</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">KWh</span>
                        <input type="number" step="any" class="form-control" name="kwh" value="<?php echo session()->get('produto_detalhes')['produto_kwh_consumidos_por_dia_no_armazem'] ?>" id="novo_produto_preco" disabled>
                    </div>

                </div>

                <div class ="row">
                    <label class="form-label" for="info">Informações complementares</label>
                    <div class="input-group mb-3">
                        <textarea name="info" class="form-control" aria-label="Informações adicionais" value="<?php echo session()->get('produto_detalhes')['produto_informacoes_adicionais'] ?>" rows="5" id="novo_produto_infos_adicionais" disabled></textarea>
                    </div>
                </div>


                <div class="row" >
                    <div class="col">
                        <label for="nome_categoria" class="form-label">Categoria do produto</label>
                        <div class="input-group mb-3">
                            <select ref="cat" @input="checkForm()" class="form-control" @change="changeSubcat($event)" name="nome_categoria" id="novo_produto_categoria" value="<?php echo session()->get('produto_detalhes')['produto_nome_categoria'] ?>" disabled >
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
                                <select ref="subcat" class="form-control" name="nome_subcategoria" id="novo_produto_subcategoria" disabled>
                                <option selected value="<?php echo session()->get('produto_detalhes')['produto_nome_subcategoria'] ?>"><?php echo session()->get('produto_detalhes')['produto_nome_subcategoria'] ?></option>
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
                                    <input oninput="checkCampoExtra()" type="text" name="<?php echo session()->get('campos_extra_atuais')[$i]['campo_extra'] ?>" class="form-control mb-3" value="<?php echo session()->get('campos_extra_atuais')[$i]['valor_campo'] ?>" disabled>
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

                <div class="position-relative my-1 text-center">
                    @if (!isInCarrinho())
                        <p><button id="buttonAdd" class="BtnAddDelProd" onclick="AdicionarApagarProdutoCarrinho(this, '{{ $produtoAtual }}', '{{ route('Add-Del-Carrinho') }}')">Adicionar ao Carrinho</button></p>
                    @else
                        <p><button id="buttonDel" class="BtnAddDelProd" style="background-color:red" onclick="AdicionarApagarProdutoCarrinho(this, '{{ $produtoAtual }}', '{{ route('Add-Del-Carrinho') }}')">Remover do Carrinho</button></p>
                    @endif
                </div>

            </form>
            </div>
        </div>
    </div>  

</div>


<script src="./js/loja.js"></script>

    
@endsection