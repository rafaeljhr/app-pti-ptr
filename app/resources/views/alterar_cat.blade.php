<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php

    

    //dd(session()->all());

    ?>

    <link rel="stylesheet" href="css/bases_veiculos.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <div class="container py-5">

        

{{-- /////////////////////////////////////////////////////////////////////////////////// --}}
        <div class="form-div mx-auto my-1 px-3">

            <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">Devido a uma alteração na categoria terá de indicar os novos valores dos campos especificos</h1>
            <div class="px-4">
                <form method="post" action="{{ route('product-edit-campos-extra') }}">
                    @csrf
                    <div class="row">
                        @for($i = 0; $i < sizeOf(session()->get('cat_selected')); $i++)

                        <div class ="col">
                            <label class="mb-2" for="<?php echo session()->get('cat_selected')[$i]['campo'] ?>"><?php echo session()->get('cat_selected')[$i]['nome_campo'] ?></label>
                            <div class="inline-icon">
                                <input type="text" name="<?php echo session()->get('cat_selected')[$i]['campo'] ?>" class="form-control mb-3" required>
                            </div>

                        </div>
                        @endfor

                        
                    </div>
                    
                    <button type="submit" class="btn btn-long btn-warning me-3">GUARDAR ALTERAÇÕES</button>
                </form>
                </div>
            </div>
        </div>  

    




    
@endsection
{{-- <script type = "text/javascript" >
    function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };
</script> --}}