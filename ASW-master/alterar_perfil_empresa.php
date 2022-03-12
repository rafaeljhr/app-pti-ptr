<?php
session_start();
//print_r($_SESSION);
include "alterar_info_array.php";
?>

<!doctype html>
<html lang="pt">
    
  <head>
    <!-- Aceder ao site: http://appserver-01.alunos.di.fc.ul.pt/~asw020/projetoASW/ -->
    <!-- Aceder à base de dados: http://appserver-01.alunos.di.fc.ul.pt/phpmyadmin/ -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-perfil_voluntario_empresa.css" type="text/css">
    <link rel="stylesheet" href="css/style-cssPartilhado.css" type="text/css">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="js/script-alterar_perfil_empresa.js"> </script>

    <link rel="icon" type="image/png" href="imagens/logo.png">
    <title>VoluntárioCOVID19</title>
  </head>

  <body>

    <!-- Container onde fica a barra de nav -->
    <?php

      include "template_navbar.php" ;

    ?>

    <!-- As propriedades da classe corpo constam em style-cssPartilhado.css -->
    <div id="corpo">

        <?php
          include "obter_perfil_empresa.php";

          echo '

          <div id="alterarDadosEmpresa" >
          
            <div id="divImagemEmpresa">
              <img src="imagens/3.jpg" id="imagem3">

              <form class="form-container3" action="implementar_alterações_empresa.php" id="alterar_empresa" enctype="multipart/form-data" method="post" onsubmit="return validate_change_inst('.htmlspecialchars($data).')">
                
                <div class="container text-center">
                  <img id="avatarUtilizador" src="' . $foto . '" alt="Avatar">
                </div>

                <br><br>

                <div class="container w-75">

                  <h4 id="header_alterar_dados_principais" tabindex="-1">Alterar os dados principais</h4>
                  <small id = "btn_registarEmp_inativo" style ="color: red; display:none;">Verifique os campos do formulário!</small><br>

                  <label for="alterar_nome_empresa" class="form-label">Nome da Empresa: </label>
                  <input class="form-control" id="alterar_nome_empresa" type="text" name="alterar_nome_empresa" value='.$nome.'>
                  <small id = "form_falha_nome_empresa" style ="color: red; display:none;">O nome da empresa já está em uso.</small><br>

                  <label for="alterar_email_empresa" class="form-label">Email da Empresa: </label>
                  <input class="form-control" id="alterar_email_empresa" type="text" name="alterar_email_empresa" value='.$email.'>
                  <small id = "form_falha_email_empresa" style ="color: red; display:none;">Este email já está em uso.</small><br>

                  <div class="div_da_password">
                    <label for="password_empresa_registo" class="form-label">Nova Password: </label>
                    <input class="form-control" type="password" id="password_empresa_registo" onchange="verificar_se_password_foi_repetida_empresa()" name="alterar_password_empresa" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                    title="Deve conter pelo menos 1 número, 1 letra maiúscula, 1 letra minúscula e pelo menos 8 ou mais caracteres!"><br>

                    <img src="imagens/blackEye.png" id="blackEye2">
                    <img src="imagens/redEye.png" id="redEye2" style="display:none;">

                  </div>

                  <label for="confirmar_password_empresa_registo" class="form-label">Repita a Password: </label>
                  <input class="form-control" type="password" id="confirmar_password_empresa_registo" onchange="verificar_se_passwords_iguais_empresa()" name="alterar_password_empresa" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                  title="Deve conter pelo menos 1 número, 1 letra maiúscula, 1 letra minúscula e pelo menos 8 ou mais caracteres!">
                  <small id = "confirmar_password_em_falta_empresa" style ="color: red; display:none;">Por favor, repita a password!</small>
                  <small id = "passwords_empresa_desiguais" style ="color: red; display:none;">As passwords que introduziu são diferentes</small><br>

                </div>

                <hr class="my-4"> 

                <div class="container w-75">

                  <h4>Alterar os dados da empresa</h4> <br>

                  <label for="alterar_nome_representante_empresa" class="form-label">Nome Completo do representante da Empresa: </label>
                  <input class="form-control" id="alterar_nome_representante_empresa" type="text" name="alterar_nome_representante_empresa" value='.$nome_representante.'><br>

                  <label for="alterar_email_representante_empresa" class="form-label">Email do representante da Empresa: </label>
                  <input class="form-control" id="alterar_email_representante_empresa" onfocus="displayOFF_btn_registarEmp_inativo()" type="text" name="alterar_email_representante_empresa" value='.$email_representante.'>
                  <small id = "form_falha_email_repre_empresa" style ="color: red; display:none;">Este email já está em uso.</small><br>

                  <label for="alterar_telefone_empresa" class="form-label">Telefone da Empresa: </label>
                  <input class="form-control" id="alterar_telefone_empresa" onfocus="displayOFF_btn_registarEmp_inativo()" type="text" name="alterar_telefone_empresa" value='.$telefone.' pattern="[0-9]*" 
                minlength="9" maxlength="9" title="O número de telemóvel possuí 9 dígitos!">
                  <small id = "form_falha_telefone_empresa" style ="color: red; display:none;">O nº de telefone já está em uso.</small><br>

                  <label for="alterar_descricao_empresa" class="form-label">Descrição da Empresa: </label>
                  <input class="form-control" id="alterar_descricao_empresa" type="text" name="alterar_descricao_empresa" value='.$descricao.'><br>

                  <label for="alterar_morada_empresa" class="form-label">Morada da Empresa: </label>
                  <input class="form-control" id="alterar_morada_empresa" type="text" name="alterar_morada_empresa" value='.$morada.'><br>

                  <label for="alterar_distrito_empresa" class="form-label">Distrito da Empresa: </label>
                  <input class="form-control" id="alterar_distrito_empresa" type="text" name="alterar_distrito_empresa" value='.$distrito.'><br>

                  <label for="alterar_concelho_empresa" class="form-label">Concelho da Empresa: </label>
                  <input class="form-control" id="alterar_concelho_empresa" type="text" name="alterar_concelho_empresa" value='.$concelho.'><br>

                  <label for="alterar_freguesia_empresa" class="form-label">Freguesia da Empresa: </label>
                  <input class="form-control" id="alterar_freguesia_empresa" type="text" name="alterar_freguesia_empresa" value='.$freguesia.'><br>

                  <label for="alterar_website_empresa" class="form-label">Website da Empresa: </label>
                  <input class="form-control" id="alterar_website_empresa" type="text" name="alterar_website_empresa" value='.$website.'><br>

                  <label for="alterar_file_empresa" class="form-label">Nova foto de perfil </label><br>
                  <input class="form-control" id="alterar_file_empresa" type="file" name="alterar_file_empresa" accept="image/*"><br>

                </div>
                
                  
                <br>
                <br>

                <div class="zona_dos_botoes container d-flex justify-content-around">

                  <div class="row">

                    <div class="col text-center botao">
                      <input class="btn btn-danger btn-lg" type="submit" value="CANCELAR" name="submit" id="xPng5">
                    </div>

                    <div class="col text-center botao">
                      <input class="btn btn-primary btn-lg" type="submit" value="GUARDAR" name="submit" id="registar_empresa">
                    </div>

                  </div>

                </div>

              </form>

            </div>

          </div>

          
          
          ';

        ?>

    </div>

    <div class="footer">
        <p><em> Voluntário COVID19 <br>  Desenvolvido por: Grupo 20 - Rafael Ribeiro, António Pereira, Gonçalo Miguel | <strong>Copyright©2021</strong> <br>
        Aplicação desenvolvida como parte integrante de um projeto FCUL.</em></p>
    </div>

  </body>

</html>