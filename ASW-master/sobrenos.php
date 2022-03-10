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
    <link rel="stylesheet" href="css/style-sobrenos.css" type="text/css">
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

<div id="divImagem">
        <img src="imagens/8.jpg" id="imagem1">

        <div class="body_container">
          <div id="corpo">
            <div class="inicio-sobre">
              <h3>Sobre Nós?</h3>
              <p>Aqui na nossa platafora VoluntárioCOVID19 temos como missão a junção de disponibilidade e necessidade.
              Temos como principal objetivo criar um espaço onde quem promove atividades de voluntariado pode facilmente achar quem esteja disposto para se inserir nas mesmas.
              Para além desta funcionalidade será ainda possível a utilização de filtros de modo a que os voluntários possam escolher as suas àreas de maior interesse, facilitando também assim a escolha aos criadores destes projetos de cariz social e comunitário. </p>
            </div>

            <div id="sobrenos">
              <h2 style="text-align:center">A Nossa Equipa</h2>
              <br>
              <div class="row">
                <div class="col-sm">
                  <div class="card">
                    <div class="container">
                      <h4>Gonçalo Miguel</h4>
                      <p class="titulo">Fundador</p>
                      <p>fc54944@alunos.fc.ul.pt</p>
                      <p><a href="mailto:fc54944@alunos.fc.ul.pt"><button class="button">Contactar</button></a></p>
                    </div>
                  </div>
                </div>

                <div class="col-sm">
                  <div class="card">
                    <div class="container">
                      <h4>António Pereira</h4>
                      <p class="titulo">Fundador</p>
                      <p>fc54956@alunos.fc.ul.pt</p>
                      <p><a href="mailto:fc54956@alunos.fc.ul.pt"><button class="button">Contactar</button></a></p>
                    </div>
                  </div>
                </div>

                <div class="col-sm">
                  <div class="card">
                    <div class="container">
                      <h4>Rafael Ribeiro</h4>
                      <p class="titulo">Fundador</p>
                      <p>fc54960@alunos.fc.ul.pt</p>
                      <p><a href="mailto:fc54960@alunos.fc.ul.pt"><button class="button">Contactar</button></a></p>
                    </div>
                  </div>
                </div> 
              </div>
            </div>

              <br>

              <div class="final-sobre">
                Para qualquer dúvida que tenha sobre este projeto poderá sempre utilizar os contactos fornecidos acima.<br>
                Obrigado Pela Sua Ajuda!
              </div>

        </div>    
    </div>
</div>

    <div class="footer">
        <p><em> Voluntário COVID19 <br>  Desenvolvido por: Grupo 20 - Rafael Ribeiro, António Pereira, Gonçalo Miguel | <strong>Copyright©2021</strong> <br>
        Aplicação desenvolvida como parte integrante de um projeto FCUL.</em></p>
    </div>
  </body>

</html>