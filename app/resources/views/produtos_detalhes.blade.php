

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

?>
<link rel="stylesheet" href="css/inventory.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

{{-- /////////////////////////////////////////////////////////////////// --}}
<div id="apresentaçãoForm" class="mx-auto mt-4 mb-4">
<h3 class="text-center">Detalhes do produto <?php echo session()->get('produto_detalhes')['produto_nome']?></h3>
<?php 
    $image_path_filename = session()->get('produto_detalhes')['produto_path_imagem'];                
    if (!file_exists(session()->get('produto_detalhes')['produto_path_imagem'])) {
        $image_path_filename = "images/default_produto.jpg";
    }
                   
?>

<p class="text-center"><img class="imagemProduto"  src="{{$image_path_filename}}" ></p>
<div class="row">
    <div class="col">
        <p><b>Preço: </b><?php echo session()->get('produto_detalhes')['produto_preco']?></p>
        <p><b>Quantidade disponivel: </b> <?php echo session()->get('produto_detalhes')['produto_quantidade']?></p>
        <p><b>Categoria: </b> <?php echo session()->get('produto_detalhes')['produto_nome_categoria']?></p>
        <p><b>Subcategoria: </b> <?php echo session()->get('produto_detalhes')['produto_nome_subcategoria']?></p>
    </div>
    <div class="col">
        <p><b>Data de produção: </b> <?php echo session()->get('produto_detalhes')['produto_data_producao_do_produto']?></p>
        <p><b>Data de inserção no site: </b> <?php echo session()->get('produto_detalhes')['produto_data_insercao_no_site']?></p>
        <p><b>KWH que consome no armazém em que se encontra: </b> <?php echo session()->get('produto_detalhes')['produto_kwh_consumidos_por_dia_no_armazem']?></p>
        <p><b>Informações adicionais: </b><?php echo session()->get('produto_detalhes')['produto_informacoes_adicionais']?></p>
    </div>
</div>





  {{--   ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  @if(Session::get('cadeias_produto_info') != [])
  <h2 class="text-center"><?php $produtoAtual ?> Evento(s) logistíco(s)</h2>

  @for($i = 0; $i < sizeOf(session()->get('cadeias_produto_info')); $i++)

    @if($i == 0)

      <div class="row mt-4 mx-auto w-100">

    @else 

      <div class="row mx-auto w-100">

    @endif

        <div class="col">
            <h5>Evento logístico Nº <?php echo $i+1 ?> - <?php echo session()->get('cadeias_produto_info')[$i]['evento_nome'] ?></h5>
            <br>
            <div class="row">
                <div class="col-4">
                    <h6>CO2(kg) produzido pelo evento</h6>
                </div>

                <div class="col-4">
                    <h6>KWh consumidos pelo evento</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <p><?php echo session()->get('cadeias_produto_info')[$i]['evento_co2'] ?> kg</p>
                </div>

                <div class="col-4">
                    <p><?php echo session()->get('cadeias_produto_info')[$i]['evento_kwh'] ?> KWh</p>
                </div>
            </div>

            <div class="row">
              <h6>Descrição</h6>
            </div>

            <div class="row">
              <p><?php echo session()->get('cadeias_produto_info')[$i]['evento_desc'] ?></p>
            </div>
        </div>

    </div>

    <br>

    <hr class="dropdown-divider" style="margin: auto;">

    <br>
@endfor
@else
    <h3 class="mt-3 mb-5 text-center">Este produto nao possui cadeias associadas</h3>
    @endif



 
  

    {{--   ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}

@if (!isInCarrinho())
    <p><button id="buttonAdd" class="BtnAddDelProd" onclick="AdicionarApagarProdutoCarrinho(this, '{{ $produtoAtual }}', '{{ route('Add-Del-Carrinho') }}')">Adicionar ao Carrinho</button></p>
@else
    <p><button id="buttonDel" class="BtnAddDelProd" style="background-color:red" onclick="AdicionarApagarProdutoCarrinho(this, '{{ $produtoAtual }}', '{{ route('Add-Del-Carrinho') }}')">Remover do Carrinho</button></p>
@endif
</div>

                   

</div>


<script src="./js/loja.js"></script>

    
@endsection