
<link rel="stylesheet" href="css/inventory.css">
<?php 
//dd(session()->all());
?>
@extends('layouts.page_default')

@section('background') 


{{-- /////////////////////////////////////////////////////////////////// --}}
<div id="apresentaçãoForm" class="mx-auto mt-4 mb-4">
<h3 class="text-center">Detalhes do produto <?php echo session()->get('produto_detalhes')['produto_nome']?></h3>
<p class="text-center"><img src="<?php echo session()->get('produto_detalhes')['produto_path_imagem']?>" ></p>
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
</div>
</div>


  <script src="./js/inventory.js"></script>

    
@endsection