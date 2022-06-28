<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bases_veiculos.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

@extends('layouts.page_default')

@section('background')
    
<?php
// dd(session()->all());
?>

<div class="container py-3">

    <div class="row">
        <div class="col">
            <div class="form-div mx-auto my-1 px-3">

                <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">PRODUTO <?php echo session()->get('produto_1_atributos')['produto_nome'] ?></h1>
                
                <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('produto_1_atributos')['produto_path_imagem'] ?>" referrerpolicy="no-referrer">
        
                <br>
        
                <div class="px-4">

                    <div class ="row">
                        <label class="form-label" for="kwh">Fornecedor</label>
                        <div class="input-group mb-3">
                            <input class="form-control text-danger" value="<?php echo session()->get('produto_1_atributos')['produto_id_fornecedor_nome'] ?>" disabled>
                        </div>
                    </div>
        
                    <div class ="row">
                        <label class="form-label" for="kwh">Consumo energético pelo armazenamento diário em armazém</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">KWh</span>
                            <input class="form-control text-danger" value="<?php echo session()->get('produto_1_atributos')['produto_kwh_consumidos_por_dia'] ?>" disabled>
                        </div>
        
                    </div>
        
                    <br>
        
                    @for($i = 0; $i < sizeOf(session()->get('campos_extra_produto_1')); $i++)
                        <div class ="row">
                            <label for="<?php echo session()->get('campos_extra_produto_1')[$i]['campo_extra'] ?>"><?php echo session()->get('campos_extra_produto_1')[$i]['nome_campo_extra'] ?></label>
                            <div class="input-group mb-3">
                                <input class="form-control mb-3 text-danger" value="<?php echo session()->get('campos_extra_produto_1')[$i]['valor_campo'] ?>" disabled>
                            </div>
                        </div>
                    @endfor
        
                </div>
            </div>
        </div>

        <div class="col">
            <div class="form-div mx-auto my-1 px-3">

                <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">PRODUTO <?php echo session()->get('produto_2_atributos')['produto_nome'] ?></h1>
                
                <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('produto_2_atributos')['produto_path_imagem'] ?>" referrerpolicy="no-referrer">
        
                <br>
        
                <div class="px-4">

                    <div class ="row">
                        <label class="form-label" for="kwh">Fornecedor</label>
                        <div class="input-group mb-3">
                            <input class="form-control text-danger" value="<?php echo session()->get('produto_2_atributos')['produto_id_fornecedor_nome'] ?>" disabled>
                        </div>
                    </div>
        
                    <div class ="row">
                        <label class="form-label" for="kwh">Consumo energético pelo armazenamento diário em armazém</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">KWh</span>
                            <input type="number"  class="form-control text-danger" name="kwh" value="<?php echo session()->get('produto_2_atributos')['produto_kwh_consumidos_por_dia'] ?>" id="novo_produto_preco" disabled >
                        </div>
        
                    </div>
        
                    <br>
        
                    @for($i = 0; $i < sizeOf(session()->get('campos_extra_produto_2')); $i++)
                        <div class ="row">
                            <label for="<?php echo session()->get('campos_extra_produto_2')[$i]['campo_extra'] ?>"><?php echo session()->get('campos_extra_produto_2')[$i]['nome_campo_extra'] ?></label>
                            <div class="input-group mb-3">
                                <input oninput="checkCampoExtra()" type="text" name="<?php echo session()->get('campos_extra_produto_2')[$i]['campo_extra'] ?>" class="form-control mb-3 text-danger" value="<?php echo session()->get('campos_extra_produto_2')[$i]['valor_campo'] ?>" disabled >
                            </div>
                        </div>
                    @endfor
        
                </div>
            </div>
        </div>
    </div>
  
</div>
    
@endsection