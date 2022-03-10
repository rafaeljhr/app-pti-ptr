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
    <script src="js/script-alterar_perfil_voluntario.js"> </script>

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
        include "obter_perfil_voluntario.php";
		
        echo '
        
        <div id="alterarDadosVoluntario" >
        
          <div id="divImagemVoluntario">
            <img src="imagens/2.jpg" id="imagem2">

            

            <form class="form-container3" action="implementar_alterações_voluntario.php" id="alterar_voluntario" enctype="multipart/form-data" method="post" onsubmit="return validate_change_vol('.htmlspecialchars($data).')">
              


              <div class="container text-center">
                <img id="avatarEmpresa" src="' . $foto . '" alt="Avatar">
              </div>

              <br><br>

              <div class="container w-75">

                <h4 id="header_alterar_dados_principais" tabindex="-1">Alterar os dados principais</h4>
                <small id ="btn_registarVol_inativo" style ="color: red; display:none;">Verifique os campos do formulário!</small><br>

                <label for="alterar_username" class="form-label">Username: </label>
                <input class="form-control" id="alterar_username" type="text" name="alterar_username" value='.$username.' onfocus="displayOFF_btn_registarVol_inativo() required">
                <small id = "form_falha_user" style ="color: red; display:none;">O username já está em uso.</small><br>
            
                <label for="alterar_email" class="form-label">Email: </label>
                <input class="form-control" id="alterar_email" type="email" name="alterar_email" value='.$email.' onfocus="displayOFF_btn_registarVol_inativo() required">
                <small id = "form_falha_email" style ="color: red; display:none;">O email já está em uso</small><br>

                <div class="div_da_password">
                  <label for="password_voluntario" class="form-label">Nova Password: </label>
                  <input class="form-control" type="password" id="password_voluntario" name="password" onchange="verificar_se_password_foi_repetida()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                  title="Deve conter pelo menos 1 número, 1 letra maiúscula, 1 letra minúscula e pelo menos 8 ou mais caracteres!"><br>

                  <img src="imagens/blackEye.png" id="blackEye1">
                  <img src="imagens/redEye.png" id="redEye1" style="display:none;">

                </div>

                <label for="confirmar_password_voluntario" class="form-label">Repita a Password: </label>
                <input class="form-control" type="password" id="confirmar_password_voluntario" name="confirmar_password" onchange="verificar_se_passwords_iguais()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                title="Deve conter pelo menos 1 número, 1 letra maiúscula, 1 letra minúscula e pelo menos 8 ou mais caracteres!">
                <small id = "confirmar_password_em_falta" style ="color: red; display:none;">Por favor, repita a password!</small>
                <small id = "passwords_desiguais" style ="color: red; display:none;">As passwords que introduziu são diferentes</small><br>

              </div>

              <hr class="my-4"> 

              <div class="container w-75">


                <h4>Alterar os dados do voluntário</h4> <br>

                <label for="alterar_nome" class="form-label">Nome Completo: </label>
                <input class="form-control" id="alterar_nome" type="text" name="alterar_nome" value='.$nome.' required><br>

                <label for="alterar_cartao_cidadao" class="form-label">Número do Cartão de cidadão: </label>
                <input class="form-control" id="alterar_cartao_cidadao" type="text" name="alterar_cartao_cidadao" value='.$cartao_cidadao.' onfocus="displayOFF_btn_registarVol_inativo()" pattern="[0-9]*" 
                minlength="8" maxlength="8" title="O número do cartão de cidadão possuí 8 dígitos!" required>
                <small id = "form_falha_cc" style ="color: red; display:none;">O Cartão de cidadão já está em uso</small><br>

                <label for="alterar_telefone" class="form-label">Telemóvel: </label>
                <input class="form-control" id="alterar_telefone" type="text" name="alterar_telefone" value='.$telefone.' onfocus="displayOFF_btn_registarVol_inativo()" pattern="[0-9]*" 
                minlength="9" maxlength="9" title="O número de telemóvel possuí 9 dígitos!" required>
                <small id = "form_falha_telemovel" style ="color: red; display:none;">O nº de telefone já está em uso</small><br>


                <hr class="my-4"> 

                <h5>COM QUAL SEXO SE IDENTIFICA?</h5><br>

                <div class="col-12">
                  <div class="form-check">
                    <input  type="checkbox" class="form-check-input" name="masculinoFeminino[]" id="masculinoFeminino1" value="masculino"';
					
					
			echo ($genero == "masculino") ?  " checked" : "";

			echo ' >
                    <label for="masculinoFeminino1" class="form-check-label">MASCULINO</label>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-check">
                    <input  type="checkbox" class="form-check-input" name="masculinoFeminino[]" id="masculinoFeminino2" value="feminino"';
					
			echo ($genero == "feminino") ?  " checked" : "";	
						
			echo '>
                    <label for="masculinoFeminino2" class="form-check-label">FEMININO</label>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-check">
                    <input  type="checkbox" class="form-check-input" name="masculinoFeminino[]" id="masculinoFeminino3" value="naoDefinido"';
					
			echo ($genero == "naoDefinido") ?  " checked" : "";		
					
			echo '>
                    <label for="masculinoFeminino3" class="form-check-label">PREFIRO NÃO DIZER.</label>
                  </div>
                </div> 
                  
                <br><br>

                <h5>POSSUÍ CARTA DE CONDUÇÃO?</h5><br>

                <div class="col-12">
                  <div class="form-check">
                    <input  type="checkbox" class="form-check-input" name="simOuNao[]" id="simOuNao1" value="sim"';
					
			echo ($carta_conducao == "sim") ?  " checked" : "";		
			
			echo '>
                    <label for="simOuNao1" class="form-check-label">SIM</label>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-check">
                    <input  type="checkbox" class="form-check-input" name="simOuNao[]" id="simOuNao2" value="nao"';
					
			echo ($carta_conducao == "nao") ?  " checked" : "";				
					
			echo '>
                    <label for="simOuNao2" class="form-check-label">NÃO</label>
                  </div>
                </div> 
                  
                <br>

                </div>
                

                <hr class="my-4"> 


                <div class="container w-75">

                <label for="alterar_freguesia" class="form-label">Freguesia: </label>
                <input class="form-control" id="alterar_freguesia" type="text" name="alterar_freguesia" value='.$freguesia.' required><br>

                <label for="alterar_concelho" class="form-label">Concelho: </label>
                <input class="form-control" id="alterar_concelho" type="text" name="alterar_concelho" value='.$concelho.' required><br>

                <label for="alterar_distrito" class="form-label">Distrito: </label>
                <input class="form-control" id="alterar_distrito" type="text" name="alterar_distrito" value='.$distrito.' required><br>

                <label for="alterar_data_nascimento" class="form-label">Data de nascimento: </label>
                <input class="form-control" id="alterar_data_nascimento" type="date" name="alterar_data_nascimento" value='.$nascimento.' required><br>

                <label for="alterar_file_voluntario" class="form-label">Nova foto de perfil </label><br>
                <input class="form-control" id="alterar_file_voluntario" type="file" name="alterar_file_voluntario" accept="image/*"><br>


              </div>

              <br>
              <br>

              <div class="zona_dos_botoes container d-flex justify-content-around">

                <div class="row">

                  <div class="col text-center botao">
                    <input class="btn btn-danger btn-lg" type="submit" value="CANCELAR" name="submit" id="xPng4">
                  </div>

                  <div class="col text-center botao">
                    <input class="btn btn-primary btn-lg" type="submit" value="GUARDAR" name="submit" id="alterar_perfil_do_voluntario">
                  </div>

                </div>

              </div>
  
            </form>

          </div>

        </div>
        
        ';

      ?>

    </div>
    
    <!-- As propriedades de footer desta página constam em style-cssPartilhado.css -->
    <div class="footer">
        <p><em> Voluntário COVID19 <br>  Desenvolvido por: Grupo 20 - Rafael Ribeiro, António Pereira, Gonçalo Miguel | <strong>Copyright©2021</strong> <br>
        Aplicação desenvolvida como parte integrante de um projeto FCUL.</em></p>
    </div>

  </body>

</html>