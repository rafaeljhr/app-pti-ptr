<?php
    session_start();
?>

<div id="primeiroDivNavbar">
      <a href="index.php" id="anchorImgNavbar">
        <img src="imagens/navbar.png" alt="Símbolo Voluntário Covid 19" id="imgNavbar">
      </a>
        
        <ul id="mainNav">
            <li class="mainNavLi colocar_inline_block"><a href="porquevoluntariado.php" class="linkMainNav">PORQUÊ VOLUNTARIADO?</a></li>
            <li class="mainNavLi colocar_inline_block"><a target="_blank" href="https://covid19.min-saude.pt/" class="linkMainNav">COVID-19</a></li>
            <li class="mainNavLi colocar_inline_block"><a href="sobrenos.php" class="linkMainNav">SOBRE NÓS</a></li>
            <li class="mainNavLi colocar_inline_block"><a href="acoes_das_instituicoes.php" class="linkMainNav">AÇÕES VOLUNTARIADO</a></li>
        </ul>

        <?php 
          if ($_SESSION["utilizador"]) {
            
            if ($_SESSION["voluntario_ou_empresa"] == "perfil_voluntario.php") {

              echo '

              <ul id="secNavVol">
                  
                <li class="colocar_inline_block">
                
                  <div class="dropdown">

                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      <a class="linkSecNav">O MEU PERFIL </a>
                    </button>

                    <ul class="dropdown-menu dropdown_menu_personalizar" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="'. $_SESSION["voluntario_ou_empresa"] .'">VER PERFIL</a></li>
                      <li><a class="dropdown-item" href="areas_interesse_voluntario.php">ÁREAS DE INTERESSES</a></li>
                    </ul>

                  </div>

                </li>

                <li class="secNavLi colocar_inline_block"><a href="logout_da_conta.php" class="linkSecNav">LOGOUT</a></li>

              </ul>

              ';

            } elseif ($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {

              echo '

              <ul id="secNavVol">
                  
                <li class="colocar_inline_block">
                
                  <div class="dropdown">

                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      <a class="linkSecNav">O MEU PERFIL </a>
                    </button>

                    <ul class="dropdown-menu dropdown_menu_personalizar" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="'. $_SESSION["voluntario_ou_empresa"] .'">VER PERFIL</a></li>
                    </ul>

                  </div>

                </li>

                <li class="secNavLi colocar_inline_block"><a href="logout_da_conta.php" class="linkSecNav">LOGOUT</a></li>

              </ul>

              ';

            }

          } else {
            
            echo "

            <ul id='secNav'>
              <li class='secNavLi colocar_inline_block'><a href='zonaLoginRegistar.php' class='linkSecNav'>ESPAÇO UTILIZADOR</a></li>
            </ul>
            
            ";

          }
        ?>
    </div>