@if($filtroCat  != "")  
@for($i = 0; $i < sizeOf(session()->get('all_fornecedor_produtos')); $i++) 

  @if($filtroCat == session()->get('all_fornecedor_produtos')[$i]['produto_nome_categoria'] || $filtroCat  ==  session()->get('all_fornecedor_produtos')[$i]['produto_nome_subcategoria'])  
        <?php
        $comCadeia = 0;
        $id = session()->get('all_fornecedor_produtos')[$i]['produto_id'];
        if(session()->get('produto_cadeia_logistica')  !=  null)
          for($c = 0; $c < sizeOf(session()->get('produto_cadeia_logistica')); $c++)
            if($id == session()->get('produto_cadeia_logistica')[$c]['evento_id_produto']) 
              $comCadeia = 1;
        ?>
        <div>
          
          <div class="col">
            <div class="card">
              @if($comCadeia == 0)
              <i  class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Este produto não possui cadeias logisticas"></i>
                                                
              @else
                <i class="bi bi-check check-icon"></i>
              @endif
              <?php $idProd = session()->get('all_fornecedor_produtos')[$i]['produto_id'] ?>
              <p>Achou  match</p>
              <input onclick="countCompare(<?php echo $idProd?>)" type="checkbox" name="<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_id'] ?>" value="<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_id']?>":hidden="!editable">
              <img src="<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_path_imagem'] ?>" class="imagemProduto card-img-top" alt="...">
              <h5 class="card-title mt-3 text-center"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_nome'] ?></h5>
              <h4 class="card-text text-center"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_preco'] ?> €</h4>
              
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_informacoes_adicionais'] ?></h5>
                <a id="hideAnchor" href="{{ URL::to('produtosEdit/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
                <button type="button" id="showProductInfo"  class="btn btn-outline-primary">Ver informações do produto</button>
                </a>
                <br>
                
                <a id="hideAnchor" href="{{ URL::to('cadeias/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
                <button type="button" id="addCadeia" class="btn btn-info">Adicionar cadeias</button>
                </a>
                <br>
                <button type="button" id='buttonApagarProdutoWarning' name="{{ route('product-delete-warning')}}" onclick="deleteWarning('<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_id'] ?>','<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_nome'] ?>')" data-bs-toggle="modal" data-bs-target="#modalApagar" class="btn btn-outline-danger">Apagar</button>
                
              </div>

            </div>
          
        </div>

        </div>

          @if($i > 0 && $i % 3==0)
            </div>
            <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
          @endif
          @endif
          @endfor

        </form>




          @else

          @for($i = 0; $i < sizeOf(session()->get('all_fornecedor_produtos')); $i++) 
              
          <?php
          $comCadeia = 0;
          $id = session()->get('all_fornecedor_produtos')[$i]['produto_id'];
          if(session()->get('produto_cadeia_logistica')  !=  null)
            for($c = 0; $c < sizeOf(session()->get('produto_cadeia_logistica')); $c++)
              if($id == session()->get('produto_cadeia_logistica')[$c]['evento_id_produto']) 
                $comCadeia = 1;
          ?>
          <div>
            
            <div class="col">
              <div class="card">
                @if($comCadeia == 0)
                  <i class="bi bi-x x-icon text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Este produto não possui cadeias logisticas"></i>
                                                  
                @else
                  <i class="bi bi-check check-icon"></i>
                @endif
                <p>nao  Achou  match</p>
                <?php $idProd = session()->get('all_fornecedor_produtos')[$i]['produto_id'] ?>
                <input onclick="countCompare(<?php echo $idProd?>)" type="checkbox" name="<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_id'] ?>" value="<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_id']?>":hidden="!editable">
                <img src="<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_path_imagem'] ?>" class="imagemProduto card-img-top" alt="...">
                <h5 class="card-title mt-3 text-center"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_nome'] ?></h5>
                <h4 class="card-text text-center"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_preco'] ?> €</h4>
                
                <div class="card-body text-center">
                  <h5 class="card-title"><?php echo session()->get('all_fornecedor_produtos')[$i]['produto_informacoes_adicionais'] ?></h5>
                  <a id="hideAnchor" href="{{ URL::to('produtosEdit/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
                  <button type="button" id="showProductInfo"  class="btn btn-outline-primary">Ver informações do produto</button>
                  </a>
                  <br>
                  
                  <a id="hideAnchor" href="{{ URL::to('cadeias/'.session()->get('all_fornecedor_produtos')[$i]['produto_id']) }}">
                  <button type="button" id="addCadeia" class="btn btn-info">Adicionar cadeias</button>
                  </a>
                  <br>
                  <button type="button" id='buttonApagarProdutoWarning' name="{{ route('product-delete-warning')}}" onclick="deleteWarning('<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_id'] ?>','<?php echo session()->get('all_fornecedor_produtos')[$i]['produto_nome'] ?>')" data-bs-toggle="modal" data-bs-target="#modalApagar" class="btn btn-outline-danger">Apagar</button>
                  
                </div>
  
              </div>
            
          </div>
  
          </div>
  
            @if($i > 0 && $i % 3==0)
              </div>
              <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4">
            @endif
            
            @endfor

          @endif
        </form>
        