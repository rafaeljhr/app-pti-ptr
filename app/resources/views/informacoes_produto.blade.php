<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
@extends('layouts.page_default')

@section('background')
    
    <?php

    

    //dd(session()->all());


    $co2 = 0;
    $kwhCadeias = 0;
    for($i = 0; $i < sizeOf(session()->get('cadeias_produto_atual'));  $i++){
        $co2 = $co2 + session()->get('cadeias_produto_atual')[$i]['evento_co2'];
        $kwhCadeias = $kwhCadeias + session()->get('cadeias_produto_atual')[$i]['evento_kwh'];
        
    }
    
    

   
  


    $now = time(); // or your date as well
    $your_date = strtotime(session()->get('produto_atual')['produto_data_insercao_no_site']);
    $datediff = ceil(($now - $your_date)/86400);
    $kwhStorage = session()->get('produto_atual')['produto_kwh_consumidos_por_dia'] * $datediff;
    
    
    ?>

    <link rel="stylesheet" href="css/bases_veiculos.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <div class="container py-5">

        <!-- Modal Apagar Base -->
        <div class="modal fade" id="modalApagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalApagarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalApagarLabel">Atenção!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem a certeza que deseja apagar o seu produto?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="post" action="{{ route('product-remove') }}">
                    @csrf
                    <input hidden value="<?php echo session()->get('produto_atual')['produto_id']?>" name="id_produto">
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </form>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal Mudar Avatar -->
        <div class="modal fade" id="modalMudarAvatar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalMudarPassLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMudarPassLabel">Alterar Imagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div ref="tab_imagem" class="tab" id='tab_da_imagem'>
                    <div class="form-outline mb-4 text-center">
                        <br>
                        <h3 id="titulo_imagem" class="mb-3">Imagem Atual</h3>
                        <img src="<?php echo session()->get('produto_atual')['produto_path_imagem'] ?>" id="imagem_a_alterar" class="mx-auto" alt="">
                    </div>
                </div>

                <form id="changeAvatar" method="post" action="{{ route('update-imagem-produto-controller') }}" enctype="multipart/form-data">
                    @csrf
                    <input onchange="alterarImagem(event)" ref="redUploadImagem" type="file" name="mudar_path_imagem" class="w-50 adicionar-foto d-grid mx-auto">
                </form>

                <div id="submitChangeAvatar" class="modal-footer" style="display: none">
                    <button type="submit" form="changeAvatar" class="btn btn-danger">Confirmar</button>
                    
                </div>

            </div>
            </div>
        </div>

{{-- /////////////////////////////////////////////////////////////////////////////////// --}}
        <div class="form-div mx-auto my-1 px-3">

            <h1 class="h3 mx-auto d-flex justify-content-center font-weight-normal mt-5 mb-5">INFORMAÇÕES DO PRODUTO</h1>
            
            <div class="container">
                <div class="row">
                  <div class="col-sm">
                    <div class="d-inline p-2 bg-primary text-white">Kwh consumidos de cadeias: <?php echo  $kwhCadeias  ?></div>
            
                  </div>
                  <div class="col-sm">
                    <div class="d-inline p-2 bg-primary text-white">Co2 provenientes de cadeias: <?php echo  $co2  ?></div>
            
                  </div>
                  <div class="col-sm">
                    <div class="d-inline p-2 bg-primary text-white">Kwh consumidos de armazenamento: <?php echo $kwhStorage ?></div>

                  </div>
                </div>
              </div>
            
            



            <img class="logo mx-auto my-3 d-flex justify-content-center" id="foto" src="<?php echo session()->get('produto_atual')['produto_path_imagem'] ?>" referrerpolicy="no-referrer">
            <div class="mt-2 w-25 mx-auto">
                <button type="button" class="btn form-control alterar_imagem_botao" data-bs-toggle="modal" data-bs-target="#modalMudarAvatar">ALTERAR IMAGEM</button>
            </div>

            <br>

            <div class="px-4">
                <form id="prod-edit" method="post" action="{{ route('product-edit-controller') }}">
                    @csrf

                    <div class="row">

                        <div class="col">
                            <label class="mb-2" for="nome">Nome</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="nome" type="text" name="nome" class="form-control mb-3" value="<?php echo session()->get('produto_atual')['produto_nome'] ?>" :disabled="!editable">
                                <i v-show="nome_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um nome"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <label class="mb-2" for="preco">Preço</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="preco" type="number" name="preco" class="form-control mb-3" value="<?php echo session()->get('produto_atual')['produto_preco'] ?>" :disabled="!editable">
                                <i v-show="preco_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um preço"></i>
                            </div>
                        </div>

                        <div class="col">
                            <label class="mb-2" for="quantidade">Quantidade</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="quantidade" type="number" name="quantidade" class="form-control w-50" value="<?php echo session()->get('produto_atual')['produto_quantidade'] ?>" :disabled="!editable" >
                                <i v-show="quantidade_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Quantidade inválida"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <label for="data_p" class="mb-2">Data de produção</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="data_p" type="date" name="data_p" class="form-control" value="<?php echo session()->get('produto_atual')['produto_data_producao_do_produto']  ?>" :disabled="!editable">
                                <i v-show="data_p_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir uma data correta"></i>
                            </div>
                        </div>

                        <div class="col">
                            <label for="data_i" class="mb-2">Data de inserção</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="data_i" type="date" name="data_i" class="form-control" value="<?php echo session()->get('produto_atual')['produto_data_insercao_no_site'] ?>" :disabled="!editable">
                                <i v-show="data_i_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir uma data correta"></i>
                            </div>
                        </div>

                        

                    </div>

                    <div class="row">

                        <div class ="col">
                            <label class="mb-2" for="kwh">Kwh consumidos por dia</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="kwh" type="number" name="kwh" class="form-control mb-3" value="<?php echo session()->get('produto_atual')['produto_kwh_consumidos_por_dia'] ?>" :disabled="!editable">
                                <i v-show="kwh_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir um valor"></i>
                            </div>

                        </div>

                        <div class ="col">

                            <label class="mb-2" for="info">Informação adicional</label>
                            <div class="inline-icon">
                                <input @input="checkForm()" ref="info" type="text" name="info" class="form-control mb-3" value="<?php echo session()->get('produto_atual')['produto_informacoes_adicionais'] ?>" :disabled="!editable">
                                <i v-show="info_valid === false" class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Tem de introduzir informação"></i>
                            </div>
                        </div>
                    
                    </div>


                    <div class="row" >
                        <div class="col">
                          <label for="nome_categoria" class="form-label">Categoria do produto</label>
                          <select ref="cat" @input="checkForm()" class="form-control" @change="changeSubcat($event)" name="nome_categoria" id="novo_produto_categoria" value="<?php echo session()->get('produto_atual')['produto_nome_categoria'] ?>" :disabled="!editable" required>
                            <option value="">-- Selecione uma categoria --</option>
                            @for($i = 0; $i < sizeOf(session()->get('categories')); $i++)
                            <?php $category= session()->get('categories')[$i] ?>
                            <option value='<?php echo session()->get('categories')[$i]['category_nome'] ?>'><?php echo session()->get('categories')[$i]['category_nome'] ?></option>              
                            @endfor
                          </select>
                        </div>
              
                        <div class="col">
                          <input id="routeSubCat" name="{{ route('product-changeSub') }}" hidden>           
                          <div id="toChangeOnCmd">
                            <label for="nome_subcategoria" class="form-label">Selecione uma subcategoria</label>
                          <select ref="subcat" class="form-control" name="nome_subcategoria" id="novo_produto_subcategoria"  disabled required>
                              <option selected value="<?php echo session()->get('produto_atual')['produto_nome_subcategoria'] ?>"><?php echo session()->get('produto_atual')['produto_nome_subcategoria'] ?></option>
                            </select>
                        </div>       
                        </div>
              
                      </div>

                   
                    <div id="camposExtraNone">
                    <div class="row">
                        @for($i = 0; $i < sizeOf(session()->get('campos_extra_atuais')); $i++)
                        
                        <div class ="col">
                            <label class="mb-2" for="<?php echo session()->get('campos_extra_atuais')[$i]['nome_campo'] ?>"><?php echo session()->get('campos_extra_atuais')[$i]['nome_campo'] ?></label>
                            <div class="inline-icon">
                                <input oninput="checkCampoExtra()" type="text" name="<?php echo session()->get('campos_extra_atuais')[$i]['nome_campo'] ?>" class="form-control mb-3" value="<?php echo session()->get('campos_extra_atuais')[$i]['valor_campo'] ?>" :disabled="!editable" required>
                                
                            </div>

                        </div>
                        @endfor

                    </div>    
                    </div>

                    <br> <br>

                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    @if(Session::get('cadeias_produto_atual') != [])
                    

                        <h3 class="mt-3 mb-5 text-center">Cadeias associadas ao seu produto</h3>

                        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
                          
                            @for($i = 0; $i < sizeOf(session()->get('cadeias_produto_atual')); $i++)
                            <div class="col">
                                <div class="evento-size card">
                                  <h5 class="card-title"><?php echo session()->get('cadeias_produto_atual')[$i]['evento_nome'] ?></h5>
                                  <h4 class="card-text ">CO2 criados: <?php echo session()->get('cadeias_produto_atual')[$i]['evento_co2'] ?></h4>             
                                  <h4 class="card-text ">Kwh consumidos: <?php echo session()->get('cadeias_produto_atual')[$i]['evento_kwh'] ?></h4>
                                  <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo session()->get('cadeias_produto_atual')[$i]['evento_desc'] ?></h5>
                                  </div>
                    
                                </div>
                              </div>
                            @endfor
                  
                        
                      </div>
                      @endif
                    



                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////////////// --}}

                    <br><br>

                    <div class="position-relative my-1">
                        <button v-show="!editable" type="button" class="btn btn-long btn-success" @click="editable = true">EDITAR PRODUTO</button>
                        <button v-show="editable" type="submit" class="btn btn-long btn-warning me-3" id="guardar_alteracoes" disabled>GUARDAR ALTERAÇÕES</button>
                        <button v-show="editable" type="button" class="btn btn-long btn-primary" @click="cancelChanges()">CANCELAR ALTERAÇÕES</button>
                        <button type="button" class="btn btn-danger position-absolute end-0" data-bs-toggle="modal" data-bs-target="#modalApagar">APAGAR PRODUTO</button>
                    </div>

                </form>
                </div>
            </div>
        </div>  

    </div>


<script src="./js/informacoes_produto.js"></script>
    
@endsection