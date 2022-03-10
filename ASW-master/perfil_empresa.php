<?php
session_start();
//print_r($_SESSION);

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

      <div id="divImagem3">
        <img src="imagens/3.jpg" id="imagem3">

        <div class="container profile-container">    

          <div class="container text-center">
            <img id="avatarUtilizador" src="' . $foto . '" alt="Avatar">
          </div>

          <br><br>

          <div class="container w-75">

            <h4>Dados principais</h4><br>

            <label for="nome_empresa" class="form-label">Nome da Empresa: </label>
            <input class="form-control" id="nome_empresa" type="text" value='.$nome.' readonly><br>

            <label for="email_empresa" class="form-label">Email da Empresa: </label>
            <input class="form-control" id="email_empresa" type="text" value='.$email.' readonly><br>

          </div>

          <hr class="my-4"> 

          <div class="container w-75">

            <h4>Dados da empresa</h4> <br>

            <label for="nome_representante_empresa" class="form-label">Nome Completo do representante da Empresa: </label>
            <input class="form-control" id="nome_representante_empresa" type="text" value='.$nome_representante.' readonly><br>

            <label for="email_representante_empresa" class="form-label">Email do representante da Empresa: </label>
            <input class="form-control" id="email_representante_empresa" type="text" value='.$email_representante.' readonly><br>

            <label for="telefone_empresa" class="form-label">Telefone da Empresa: </label>
            <input class="form-control" id="telefone_empresa" type="text" value='.$telefone.' readonly><br>

            <label for="descricao_empresa" class="form-label">Descrição da Empresa: </label>
            <input class="form-control" id="descricao_empresa" type="text" value='.$descricao.' readonly><br>

            <label for="morada_empresa" class="form-label">Morada da Empresa: </label>
            <input class="form-control" id="morada_empresa" type="text" value='.$morada.' readonly><br>

            <label for="distrito_empresa" class="form-label">Distrito da Empresa: </label>
            <input class="form-control" id="distrito_empresa" type="text" value='.$distrito.' readonly><br>

            <label for="concelho_empresa" class="form-label">Concelho da Empresa: </label>
            <input class="form-control" id="concelho_empresa" type="text" value='.$concelho.' readonly><br>

            <label for="freguesia_empresa" class="form-label">Freguesia da Empresa: </label>
            <input class="form-control" id="freguesia_empresa" type="text" value='.$freguesia.' readonly><br>

            <label for="website_empresa" class="form-label">Website da Empresa: </label>
            <input class="form-control" id="website_empresa" type="text" value='.$website.' readonly><br>

          </div>
          
            
          <br>
          <br>

          <div class="container text-center">
            <a href="alterar_perfil_empresa.php"><button class="btn btn-primary btn-lg">ALTERAR PERFIL</button></a>
          </div> 

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