<link rel="stylesheet" href="css/bases_veiculos.css">

@extends('layouts.page_default')

@section('background') 


{{-- /////////////////////////////////////////////////////////////////// --}}

<div class="loader text-center" id="loader">
    <div class="spinner-border text-light loader-spinner" role="status">
    </div>
</div>

<div id="criar" class="base mx-auto mt-5">
    
    <form method="post" action="{{ route('armazem-register-controller')}}" enctype="multipart/form-data">
        @csrf
        <h1 class="text-center mb-3 mt-2">CRIAR ARMAZÉM</h1>
    
        <div class="row">
            <label for="nome" class="form-label">Nome</label>
            <div class="input-group mb-3">  
                <input type="text" class="form-control" name="nome" id="nome"  aria-describedby="basic-addon1" required>
            </div>
        </div>
        
        <div class="row">
            <label for="image" class="form-label">Imagem do seu armazém:</label>
            <div class="input-group mb-3">       
                <input type="file" class="form-control" name="path_imagem_armazem" id="image" aria-label="file" aria-describedby="basic-addon1">
            </div>
        </div>
    
        <div class="row">
            <label for="morada" class="form-label">Morada do armazém</label>
            <input type="text" class="form-control" name="morada" id="morada"  aria-describedby="basic-addon1" required>
        </div>

        <div class="row">
            <label for="codigo_postal" style="display: table-cell;" class="text-dark">Código Postal</label>
            <div class="inline-icon">
                <input  type="text" id ="codigo_postal_1" name ="codigo_postal_1" class="form-control w-50" style="display: inline-block;" maxlength="4" placeholder="xxxx">
                <input  type="text" id ="codigo_postal_2" name ="codigo_postal_2" class="form-control w-50" style="display: inline-block;" maxlength="3" placeholder="xxx">
            </div>
        </div>
    
        
        <div class="row">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" name="cidade" id="cidade"  aria-describedby="basic-addon1" required>
        </div>

        <div class="row">
            <label for="pais" class="form-label">País</label>
            <input type="text" name ="pais"  id="pais" class="form-control" aria-describedby="basic-addon1" required>
        </div>


    
          {{-- Hidden inputs para a latitude e longitude da morada do utilizador --}}
          <input ref="latitude" type="hidden" name ="latitude" value="default">
          <input ref="longitude" type="hidden" name ="longitude" value="default">
        
      
        <button class="w-100 btn btn-lg btn-success mt-3" id ="but-pad" type="submit">Adicionar armazém</button>
      
      </form>

</div>




<script src="./js/base_veiculo.js"></script>

    
@endsection