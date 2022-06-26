


<link rel="stylesheet" href="css/inventory.css">

@extends('layouts.page_default')

@section('background') 


<div id="noCadeias">
    <div id="apresentaçãoForm" class="mx-auto mt-4 mb-4">

        <form method="post" action="{{ route('product-add-event-controller')}}">
            @csrf
            
            <h3 class="mt-5">Criando novo evento logístico associado ao produto <b><?php echo session()->get('prod_nome_cadeia_actual')?></b></h3>

            <br>

            <div class="row mt-3">
                <label for="image" class="form-label">Nome do evento logístico</label>
                <div class="input-group mb-3">  
                    <input type="text" class="form-control" name="nomeCadeia" id="image"  aria-describedby="basic-addon1" required>
                </div>
            </div>
            
            <div class="row mt-3">
                <label for="co2_produzido" class="form-label">CO2(kg) produzido pelo evento</label>
                <div class="input-group mb-3">       
                    <input type="number" min="0" step  ="any" class="form-control" name="co2_produzido" id="co2_produzido" aria-describedby="basic-addon1" >
                </div>
            </div>
            
            <div class="row mt-3">
                <label for="kwh_consumidos" class="form-label">KWh consumidos pelo evento</label>
                <div class="input-group mb-3">       
                    <input type="number"  min="0" step ="any" class="form-control" name="kwh_consumidos" id="kwh_consumidos" aria-describedby="basic-addon1">
                </div>
            </div>

            <div class="row mt-3">
                <div class="input-group mb-3"> 
                    <span class="input-group-text">Descrição</span>
                    <textarea class="form-control" name="descricaoCadeia" aria-label="With textarea" rows="10" required></textarea>
                </div>
            </div>
            
            
            <button class="w-100 btn btn-lg btn-success" id='botaoAdicionarEvento' type="submit">Criar</button>
            
            
        </form>

    </div>
</div>


<script src="./js/inventory.js"></script>

    
@endsection