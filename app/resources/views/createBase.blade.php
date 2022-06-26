


<link rel="stylesheet" href="css/bases_veiculos.css">

@extends('layouts.page_default')

@section('background') 


{{-- /////////////////////////////////////////////////////////////////// --}}

<div class="loader text-center" id="loader">
    <div class="spinner-border text-light loader-spinner" role="status">
    </div>
</div>

<div id="criar" class="base mx-auto mt-5">
    
    <form @submit.prevent="finishForm" id="baseForm" method="post" action="{{ route('base-register-controller')}}" enctype="multipart/form-data">
        @csrf
        <h1 class="text-center mb-3 mt-2">CRIAR BASE</h1>

       
        <div class="row mt-3">
            <label for="nome" class="form-label">Nome da base</label>
            <div class="input-group mb-3">  
                <input type="text" class="form-control" name="nome" id="morada"  aria-describedby="basic-addon1" required>
            </div>
        </div>

        <div class="row mt-1">
            <label for="preco" class="form-label">Preço cobrado por entrega</label>
            <div class="input-group mb-3">  
                <input type="number" class="form-control" name="preco" id="preco"  aria-describedby="basic-addon1" required>
            </div>
        </div>
        
        <div class="row mt-1">
            <label for="image" class="form-label">Imagem da base:</label>
            <div class="input-group mb-3">       
                <input type="file" class="form-control" name="path_imagem" id="image" aria-label="file" aria-describedby="basic-addon1">
            </div>
        </div>
        
        <div class="row mt-1">
            <label for="morada" class="form-label">Morada da base</label>
            <div class="input-group mb-3">  
                <input type="text" class="form-control" name="morada" id="morada"  aria-describedby="basic-addon1" required>
            </div>
        </div>

        <div class="row mt-1">
            <div class="form-outline">
                <label for="codigo_postal" class="form-label">Código postal da base</label>
                <div class="inline-icon mb-3">
                    <input type="text" name ="codigo_postal_1" id ="codigo_postal_1" class="form-control w-50" maxlength="4" placeholder="xxxx" style="display: inline-block;">
                    <input type="text" name ="codigo_postal_2" id ="codigo_postal_2" class="form-control w-50" maxlength="3" placeholder="xxx" style="display: inline-block;">
                </div>
            </div>
        </div>
        
        <div class="row mt-1">
            <label for="cidade" class="form-label">Cidade</label>
            <div class="input-group mb-3"> 
                <input type="text" id="cidade" name ="cidade" class="form-control">
            </div>
        </div>

        <div class="row mt-1">
            <label for="pais" class="form-label">País</label>
            <div class="input-group mb-3"> 
                <select class="form-control"  name="pais">
                    <option selected>Portugal</option>
                </select>
            </div>
        </div>


        {{-- Hidden inputs para a latitude e longitude da morada do utilizador --}}
        <input ref="latitude" type="hidden" name ="latitude" value="default">
        <input ref="longitude" type="hidden" name ="longitude" value="default">
    
        <button class="w-100 btn btn-lg btn-success mt-3" id ="but-pad" type="submit">Adicionar base</button>
        
    </form>

</div>




<script src="./js/base_veiculo.js"></script>

    
@endsection