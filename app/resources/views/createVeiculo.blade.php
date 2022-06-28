


<link rel="stylesheet" href="css/bases_veiculos.css">

@extends('layouts.page_default')

@section('background') 


{{-- /////////////////////////////////////////////////////////////////// --}}

<div class="loader text-center" id="loader">
    <div class="spinner-border text-light loader-spinner" role="status">
    </div>
</div>

<div id="criar" class="base mx-auto mt-5">
    
    <form method="post" action="{{ route('veiculo-register-controller')}}" enctype="multipart/form-data">
        @csrf
        <h1 class="text-center mb-3 mt-2">CRIAR VEÍCULO</h1>

            <div class="row mt-3">
                <label for="nome" class="form-label">Nome do veículo</label>
                <div class="input-group mb-3">  
                    <input type="text" class="form-control" name="nome" id="morada"  aria-describedby="basic-addon1" required>
                </div>
            </div>
            
            <div class="row mt-3">
                <label for="image" class="form-label">Imagem do veículo:</label>
                <div class="input-group mb-3">       
                    <input type="file" class="form-control" name="path_imagem" id="image" aria-label="file" aria-describedby="basic-addon1">
                </div>
            </div>

            <div class="row mt-3">
                <label for="tipo_combustivel" class="form-label">Combustível</label>
                <div class="input-group mb-3"> 
                    <select class="form-control" name="tipo_combustivel" required>
                        <option value="">-- Selecione o tipo de combustível --</option>
                        @for($i = 0; $i < sizeOf(session()->get('tipos_combustivel')); $i++)
                        <option value='<?php echo session()->get('tipos_combustivel')[$i]['tipos_combustivel_nome'] ?>'><?php echo session()->get('tipos_combustivel')[$i]['tipos_combustivel_nome'] ?></option>              
                        @endfor
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <label for="consumo_por_100km" class="form-label">Consumo (L) por 100Km</label>
                <div class="input-group mb-3">  
                    <input name="consumo_por_100km" class="form-control" type="number" step="any" required>
                </div>
            </div>
            

            
            <div class="row mt-3">
                <label for="id_base" class="form-label">Base do veículo</label>
                <div class="input-group mb-3"> 
                    <select class="form-control" name="id_base" list="input-bases" required>
                        <option value="">-- Selecione a base do veículo --</option>
                        @for($i = 0; $i < sizeOf(session()->get('bases')); $i++)
                        <option value=<?php echo session()->get('bases')[$i]['base_id']?>><?php echo session()->get('bases')[$i]['base_nome'] ?></option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <label for="quantidade" class="form-label">Número de veículos</label>
                <div class="input-group mb-3">  
                    <input name="quantidade" class="form-control" type="number" step="any" required>
                </div>
            </div>
        
            <button class="w-100 btn btn-lg btn-success mt-3" id ="but-pad" type="submit">Adicionar veículo</button>

        </form>

</div>




<script src="./js/base_veiculo.js"></script>

    
@endsection