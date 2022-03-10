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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
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
      include "obter_perfil_voluntario.php";

      echo '
      <div id="divImagem2">
        <img src="imagens/2.jpg" id="imagem2">

        <div class="container profile-container">
          
            <div class="container text-center">
              <img id="avatarEmpresa" src="' . $foto . '" alt="Avatar">
            </div>

            <br><br>

            <div class="container w-75">

              <h4>Dados principais</h4><br>

              <label for="username" class="form-label">Username: </label>
              <input class="form-control" id="username" type="text" value='.$username.' readonly><br>
          
              <label for="email" class="form-label">Email: </label>
              <input class="form-control" id="email" type="email" value='.$email.' readonly><br>

            </div>

            <hr class="my-4"> 

            <div class="container w-75">

              <h4>Dados do voluntário</h4> <br>

              <label for="nome" class="form-label">Nome Completo: </label>
              <input class="form-control" id="nome" type="text" value='.$nome.' readonly><br>

              <label for="cartao_cidadao" class="form-label">Número do Cartão de cidadão: </label>
              <input class="form-control" id="cartao_cidadao" type="text" value='.$cartao_cidadao.' readonly><br>

              <label for="telefone" class="form-label">Telemóvel: </label>
              <input class="form-control" id="telefone" type="text" value='.$telefone.' readonly><br>

              <label for="genero" class="form-label">Genero: </label>
              <input class="form-control" id="genero" type="text" value='.$genero.' readonly><br>

              <label for="carta_conducao" class="form-label">Carta de Condução: </label>
              <input class="form-control" id="carta_conducao" type="text" value='.$carta_conducao.' readonly><br>
              

              <label for="freguesia" class="form-label">Freguesia: </label>
              <input class="form-control" id="freguesia" type="text" value='.$freguesia.' readonly><br>

              <label for="concelho" class="form-label">Concelho: </label>
              <input class="form-control" id="concelho" type="text" value='.$concelho.' readonly><br>

              <label for="distrito" class="form-label">Distrito: </label>
              <input class="form-control" id="distrito" type="text" value='.$distrito.' readonly><br>

              <label for="data_nascimento" class="form-label">Data de nascimento: </label>
              <input class="form-control" id="data_nascimento" type="date" value='.$nascimento.' readonly><br>

            </div>

            <br>
            <br>

            <div class="container text-center">
              <a href="alterar_perfil_voluntario.php"><button class="btn btn-primary btn-lg">ALTERAR PERFIL</button></a>
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