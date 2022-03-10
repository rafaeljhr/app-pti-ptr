<?php
session_start();
// print_r($_SESSION);

unset ($_SESSION["sobrenos"]);
unset ($_SESSION["porquevoluntariado"]);
unset ($_SESSION["criar_acoes_voluntariado"]);

    
$_SESSION["zonaLoginRegistar"] = "active";

include "openconn.php";
include "registo_info_array.php";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style-zonaLoginRegistar.css" type="text/css">
    <link rel="stylesheet" href="css/style-cssPartilhado.css" type="text/css">

    <script src="js/script-zonaLoginRegistar.js"> </script>

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
    <div id="divImagem2">
        <img src="imagens/2.jpg" id="imagem2">
        <img src="imagens/3.jpg" id="imagem3" style="display:none;">

        <div id="registar_entrar">

          <div class="container text-center">
            <h2 id="entrar">ZONA LOGIN</h2>
          </div>

          <div id="login_como_voluntario">
          <form class="form-container" action="verificar_existencia_voluntario.php" method="post" >

            
              <div class="container d-flex justify-content-center mt-3">
                <div class="row">

                  <div class="col">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input big-checkbox" name="escolher_tipo_login" id="login_voluntario" checked="checked">
                      <label for="login_voluntario" class="textoCheckbox form-check-label">VOLUNTÁRIO</label>
                    </div>
                  </div>
              

                  <div class="col l-5">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input big-checkbox" name="escolher_tipo_login" id="login_empresa">
                      <label for="login_empresa" class="textoCheckbox form-check-label">EMPRESA</label>
                    </div>
                  </div>

                </div>
              </div> 
              
            <br><br><br>

            <div class="w-75 caixalogin">
            <input class="caixalogin form-control" id="username" type="text" name="username" placeholder="Username" required autofocus><br>
            </div>

            <div class="w-75 caixalogin">

              <div class="div_da_password">
                <input class="caixalogin form-control" id="password" type="password" name="password" placeholder="Password" required>

                <img src="imagens/blackEye.png" id="blackEye3">
                <img src="imagens/redEye.png"  id="redEye3" style="display:none;">

              </div>

            </div>

            

            <div class="text-center">
			        <small style ="color: red;"><?php echo $_SESSION['erro'] ?></small>
            </div>

            <div class="container text-center">
              <p class="h6 mt-2" id="fraseSemConta">Ainda não tem conta? <a href="#" class="link-primary" id="criarConta">Crie uma!</a></p> <br>
            </div>

            <div class="container text-center">
              <input class="btn btn-primary btn-lg" type="submit" value="ENTRAR!" name="submit">
            </div>

          </form>
        </div>

          

          <div id="login_como_empresa" style="display:none;">

          <form class="form-container" action="verificar_existencia_empresa.php" method="post" >

            <div class="container d-flex justify-content-center mt-3">
                <div class="row">

                  <div class="col">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input big-checkbox" name="escolher_tipo_login" id="login_voluntario2">
                      <label for="login_voluntario2" class="textoCheckbox form-check-label">VOLUNTÁRIO</label>
                    </div>
                  </div>
              

                  <div class="col l-5">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input big-checkbox" name="escolher_tipo_login" id="login_empresa2" checked="checked">
                      <label for="login_empresa2" class="textoCheckbox form-check-label">EMPRESA</label>
                    </div>
                  </div>

                </div>
            </div> 
            
            <br><br><br>

            <div class="w-75 caixalogin">
            <input class="caixalogin form-control" id="username_empresa" type="text" name="username_empresa" placeholder="Nome da Empresa" required autofocus><br>
            </div>

            <div class="w-75 caixalogin">

              <div class="div_da_password">
                <input class="caixalogin form-control" id="password_empresa" type="password" name="password_empresa" placeholder="Password" required>

                <img src="imagens/blackEye.png" id="blackEye4">
                <img src="imagens/redEye.png"  id="redEye4" style="display:none;">

              </div>

            </div>

            <div class="text-center">
			        <small style ="color: red;"><?php echo $_SESSION['erro'] ?></small>
            </div>
            
            <div class="container text-center">
              <p class="h6 mt-2" id="fraseSemConta">Ainda não tem conta? <a href="#" class="link-primary" id="criarConta_empresa">Crie uma!</a></p> <br>
            </div>

            <div class="container text-center">
              <input class="btn btn-primary btn-lg" type="submit" value="ENTRAR!" name="submit">
            </div>

          </form>

          </div>

        </div>

        <div class="container" id="div_Registar_Voluntario" style="display:none;"> 
          
          <div class="py-5 text-center">
            <h2 id="criar_novo_vol_titulo">CRIAR NOVO VOLUNTÁRIO</h2>
          </div>

          
          
            <form class="form-container2" action="registar_Voluntario.php" id="registar_voluntario" enctype="multipart/form-data" method="post" onsubmit="return validate_data(<?php echo htmlspecialchars($data); ?>)">

                

                <div class="container w-75">

                  <h4>TIPO DE CONTA A CRIAR:</h4> <br>

                  <div class="container d-flex justify-content-around">
                  <div class="row">

                    <div class="col">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input big-checkbox" name="voluntarioOuEmpresa" id="voluntario" checked="checked">
                        <label for="voluntario" class="form-check-label textoCheckbox">VOLUNTÁRIO</label>
                      </div>
                    </div>

                    <div class="col">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input big-checkbox" name="voluntarioOuEmpresa" id="empresa">
                        <label for="empresa" class="form-check-label textoCheckbox">EMPRESA</label>
                      </div>
                    </div>

                  </div>
                </div> 
                  
                  <br><br>
                  
                  <h4>Dados principais</h4>

                  <label  for="username_vol" class="form-label">Username: </label>
                  <input class="form-control" id="username_vol" type="text" name="username" required>
                  <small id = "form_falha_user" style ="color: red; display:none;">O username já está em uso.</small><br>
            
                  <label for="email_vol" class="form-label">Email: </label>
                  <input class="form-control" id="email_vol" type="email" name="email" required>
                  <small id = "form_falha_email" style ="color: red; display:none;">O email já está em uso</small><br>
                  

                  <div class="div_da_password">
                    <label id = "label_password_voluntario" tabindex="-1" for="password_voluntario" class="form-label">Password: </label>
                    <input class="form-control" type="password" id="password_voluntario" name="password" onchange="verificar_se_password_foi_repetida()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                    title="Deve conter pelo menos 1 número, 1 letra maiúscula, 1 letra minúscula e pelo menos 8 ou mais caracteres!" required><br>

                    <img src="imagens/blackEye.png" id="blackEye1">
                    <img src="imagens/redEye.png" id="redEye1" style="display:none;">

                  </div>


                  <label for="confirmar_password_voluntario" class="form-label">Repita a Password: </label>
                  <input class="form-control" type="password" id="confirmar_password_voluntario" name="confirmar_password" onchange="verificar_se_passwords_iguais()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                  title="Deve conter pelo menos 1 número, 1 letra maiúscula, 1 letra minúscula e pelo menos 8 ou mais caracteres!" required>
                  <small id = "confirmar_password_em_falta" style ="color: red; display:none;">Por favor, repita a password!</small>
                  <small id = "passwords_desiguais" style ="color: red; display:none;">As passwords que introduziu são diferentes</small><br>

                </div>

                <hr class="my-4"> 

                <div class="container w-75">

                  <h4>Dados do voluntário</h4> <br>

                  <label for="nome" class="form-label">Nome Completo: </label>
                  <input class="form-control" id="nome" type="text" name="nome" required><br>

                  <label for="cartao_cidadao_vol" class="form-label">Número do Cartão de cidadão: </label>
                  <input class="form-control" id="cartao_cidadao_vol" type="text" name="cartao_cidadao"  pattern="[0-9]*" 
                  minlength="8" maxlength="8" title="O número do cartão de cidadão possuí 8 dígitos!" required>
                  <small id = "form_falha_cc" style ="color: red; display:none;">O Cartão de cidadão já está em uso</small><br>

                  <label for="telefone_vol" class="form-label">Telemóvel: </label>
                  <input class="form-control" id="telefone_vol" type="text" name="telefone"  pattern="[0-9]*" 
                  minlength="9" maxlength="9" title="O número de telemóvel possuí 9 dígitos!" required>
                  <small id = "form_falha_telemovel" style ="color: red; display:none;">O nº de telefone já está em uso</small><br>

                  <hr class="my-4"> 

                  <h5>COM QUAL SEXO SE IDENTIFICA?</h5><br>

                  <div class="col-12">
                    <div class="form-check">
                      <input  type="checkbox" class="form-check-input" name="masculinoFeminino[]" id="masculinoFeminino1" value="masculino" required>
                      <label for="masculinoFeminino1" class="form-check-label">MASCULINO</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input  type="checkbox" class="form-check-input" name="masculinoFeminino[]" id="masculinoFeminino2" value="feminino" required>
                      <label for="masculinoFeminino2" class="form-check-label">FEMININO</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input  type="checkbox" class="form-check-input" name="masculinoFeminino[]" id="masculinoFeminino3" value="naoDefinido" required>
                      <label for="masculinoFeminino3" class="form-check-label">PREFIRO NÃO DIZER.</label>
                    </div>
                  </div> 
                  
                  <br><br>

                  <h5>POSSUÍ CARTA DE CONDUÇÃO?</h5><br>

                  <div class="col-12">
                    <div class="form-check">
                      <input  type="checkbox" class="form-check-input" name="simOuNao[]" id="simOuNao1" value="sim" required>
                      <label for="simOuNao1" class="form-check-label">SIM</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input  type="checkbox" class="form-check-input" name="simOuNao[]" id="simOuNao2" value="nao" required>
                      <label for="simOuNao2" class="form-check-label">NÃO</label>
                    </div>
                  </div> 
                  
                  <br>

                  <hr class="my-4"> 

                  <label for="freguesia" class="form-label">Freguesia: </label>
                  <input class="form-control" id="freguesia" type="text" name="freguesia" required><br>
                  
                  <label for="concelho" class="form-label">Concelho: </label>
                  <input class="form-control" id="concelho" type="text" name="concelho" required><br>
                  
                  <label for="distrito" class="form-label">Distrito: </label>
                  <input class="form-control" id="distrito" type="text" name="distrito" required><br>
                  
                  <label for="data_nascimento" class="form-label">Data de nascimento: </label>
                  <input class="form-control" id="data_nascimento" type="date" name="data_nascimento" required><br>

                  <label for="file" class="form-label">A sua foto de perfil </label><br>
                  <input class="form-control" id="file" type="file" name="file" accept="image/*"><br>

                </div>
                
                <br><br>

                <div class="zona_dos_botoes container d-flex justify-content-around">

                  <div class="row">

                    <div class="col text-center botao">
                      <input class="btn btn-danger btn-lg" type="submit" value="CANCELAR" name="submit" id="xPng2">
                    </div>

                    <div class="col text-center botao">
                      <input class="btn btn-primary btn-lg" type="submit" value="REGISTAR" name="submit" id="registar">
                    </div>

                  </div>

              </div>
                
              </form>

        </div>

        

        <div class="container" id="div_Registar_Empresa" style="display:none;">
          <div class="py-5 text-center">
            <h2 id="criar_novo_emp_titulo">CRIAR NOVA EMPRESA</h2>
          </div>

          
          
            <form class="form-container2" action="registar_Empresa.php" id="registar_empresa" enctype="multipart/form-data" method="post" onsubmit="return validate_data(<?php echo htmlspecialchars($data); ?>)">

              <div class="container w-75">

                <h4>TIPO DE CONTA A CRIAR:</h4> <br>

                <div class="container d-flex justify-content-around">
                  <div class="row">

                    <div class="col">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input big-checkbox" name="voluntarioOuEmpresa" id="voluntario2">
                        <label for="voluntario2" class="form-check-label textoCheckbox">VOLUNTÁRIO</label>
                      </div>
                    </div>

                    <div class="col">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input big-checkbox" name="voluntarioOuEmpresa" id="empresa2" checked="checked">
                        <label for="empresa2" class="form-check-label textoCheckbox">EMPRESA</label>
                      </div>
                    </div>

                  </div>
                </div> 
                
                <br><br>

                <h4>Dados principais</h4> 

                <label for="nome_empresa" class="form-label">Nome da Empresa: </label>
                <input class="form-control" id="nome_empresa" type="text" name="nome_empresa" maxlength="26" required>
                <small id = "form_falha_nome_empresa" style ="color: red; display:none;">O nome da empresa já está em uso.</small><br>

                <label for="email_empresa" class="form-label">Email da Empresa: </label>
                <input  class="form-control" id="email_empresa" type="email" name="email_empresa" required>
                <small id = "form_falha_email_empresa" style ="color: red; display:none;">Este email já está em uso.</small><br>
                  

                <div class="div_da_password">
                  <label id="label_password_empresa" tabindex="-1" for="password_empresa_registo" class="form-label">Password: </label>
                  <input class="form-control" type="password" id="password_empresa_registo" name="password_empresa" onchange="verificar_se_password_foi_repetida_empresa()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                  title="Deve conter pelo menos 1 número, 1 letra maiúscula, 1 letra minúscula e pelo menos 8 ou mais caracteres!" required> <br>

                  <img src="imagens/blackEye.png" id="blackEye2">
                  <img src="imagens/redEye.png" id="redEye2" style="display:none;">

                </div>


                <label for="confirmar_password_empresa_registo" class="form-label">Repita a Password: </label>
                <input class="form-control" type="password" id="confirmar_password_empresa_registo" name="password_empresa" onchange="verificar_se_passwords_iguais_empresa()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                title="Deve conter pelo menos 1 número, 1 letra maiúscula, 1 letra minúscula e pelo menos 8 ou mais caracteres!" required>
                <small id = "confirmar_password_em_falta_empresa" style ="color: red; display:none;">Por favor, repita a password!</small>
                <small id = "passwords_empresa_desiguais" style ="color: red; display:none;">As passwords que introduziu são diferentes</small>
                 
                <br>

              </div>

              <hr class="my-4"> 

              <div class="container w-75">

                <br>
                <h4>Dados da empresa</h4> <br>

                <label for="nome_representante_empresa" class="form-label">Nome completo do representante da Empresa: </label>
                <input class="form-control" id="nome_representante_empresa" type="text" name="nome_representante_empresa" required><br>

                <label for="email_representante_empresa" class="form-label">Email do representante da Empresa: </label>
                <input class="form-control" id="email_representante_empresa" type="email" name="email_representante_empresa" required>
                <small id = "form_falha_email_repre_empresa" style ="color: red; display:none;">Este email já está em uso.</small><br>

                <label for="telefone_empresa" class="form-label">Telefone da Empresa: </label>
                <input class="form-control" id="telefone_empresa" type="text" name="telefone_empresa" pattern="[0-9]*" 
                minlength="9" maxlength="9" title="O número de telemóvel possuí 9 dígitos!" required>
                <small id = "form_falha_telemovel_empresa" style ="color: red; display:none;">O nº de telefone já está em uso.</small><br>

                <label for="descricao_empresa" class="form-label">Descrição da Empresa: </label>
                <input class="form-control" id="descricao_empresa" type="text" name="descricao_empresa" required><br>
                    
                <label for="morada_empresa" class="form-label">Morada da Empresa: </label>
                <input class="form-control" id="morada_empresa" type="text" name="morada_empresa" required><br>
                    
                <label for="distrito_empresa" class="form-label">Distrito da Empresa: </label>
                <input class="form-control" id="distrito_empresa" type="text" name="distrito_empresa" required><br>
                    
                <label for="concelho_empresa" class="form-label">Concelho da Empresa: </label>
                <input class="form-control" id="concelho_empresa" type="text" name="concelho_empresa" required><br>
                    
                <label for="freguesia_empresa" class="form-label">Freguesia da Empresa: </label>
                <input class="form-control" id="freguesia_empresa" type="text" name="freguesia_empresa" required><br>
                    
                <label for="website_empresa" class="form-label">Website da Empresa: </label>
                <input class="form-control" id="website_empresa" type="text" name="website_empresa" required><br>

                <label for="file_empresa" class="form-label">A sua foto de perfil </label><br>
                <input class="form-control" id="file_empresa" type="file" name="file_empresa" accept="image/*"><br>

              </div>
                
              <br><br>

              <div class="zona_dos_botoes container d-flex justify-content-around">

                <div class="row">

                  <div class="col text-center botao">
                    <input class="btn btn-danger btn-lg" type="submit" value="CANCELAR" name="submit" id="xPng3">
                  </div>

                  <div class="col text-center botao">
                    <input class="btn btn-primary btn-lg" type="submit" value="REGISTAR" name="submit" id="registar_empresa_botao">
                  </div>

                </div>

              </div>

            </form>

        </div>

    <br>
    
    </div>

    </div>
    
    
    <!-- As propriedades de footer desta página constam em style-cssPartilhado.css -->
    <div class="footer">
        <p><em> Voluntário COVID19 <br>  Desenvolvido por: Grupo 20 - Rafael Ribeiro, António Pereira, Gonçalo Miguel | <strong>Copyright©2021</strong> <br>
        Aplicação desenvolvida como parte integrante de um projeto FCUL.</em></p>
    </div>

    

    
  </body>

</html>