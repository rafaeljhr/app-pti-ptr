

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

<p class="text-center"><img src="{{$image_path_filename}}" ></p>
<div class="row">
    <div class="col">
        <p>Preço: <?php echo session()->get('produto_detalhes')['produto_preco']?></p>
        <p>Quantidade disponivel: <?php echo session()->get('produto_detalhes')['produto_quantidade']?></p>
        <p>Categoria: <?php echo session()->get('produto_detalhes')['produto_nome_categoria']?></p>
        <p>Subcategoria: <?php echo session()->get('produto_detalhes')['produto_nome_subcategoria']?></p>
    </div>
    <div class="col">
        <p>Data de produção: <?php echo session()->get('produto_detalhes')['produto_data_producao_do_produto']?></p>
        <p>Data de inserção no site: <?php echo session()->get('produto_detalhes')['produto_data_insercao_no_site']?></p>
        <p>KWH que consome no armazém em que se encontra: <?php echo session()->get('produto_detalhes')['produto_kwh_consumidos_por_dia_no_armazem']?></p>
        <p>Informações adicionais: <?php echo session()->get('produto_detalhes')['produto_informacoes_adicionais']?></p>
    </div>
</div>





  {{--   ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  {{-- ////////////////////////////////////////////////////////// --}}
  @if(Session::get('cadeias_produto_info') != [])
  

      <h3 class="mt-3 mb-5 text-center">Cadeias associadas ao produto</h3>

      <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
        
          @for($i = 0; $i < sizeOf(session()->get('cadeias_produto_info')); $i++)
          <div class="col">
              <div class="evento-size card">
                <h5 class="card-title"><?php echo session()->get('cadeias_produto_info')[$i]['evento_nome'] ?></h5>
                <h4 class="card-text ">CO2 criados: <?php echo session()->get('cadeias_produto_info')[$i]['evento_co2'] ?></h4>             
                <h4 class="card-text ">Kwh consumidos: <?php echo session()->get('cadeias_produto_info')[$i]['evento_kwh'] ?></h4>
                <div class="card-body text-center">
                  <h5 class="card-title"><?php echo session()->get('cadeias_produto_info')[$i]['evento_desc'] ?></h5>
                </div>
  
              </div>
            </div>
          @endfor

      
    </div>
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