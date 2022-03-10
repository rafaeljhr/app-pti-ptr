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
    <link rel="stylesheet" href="css/style-porquevoluntariado.css" type="text/css">
    <link rel="stylesheet" href="css/style-cssPartilhado.css" type="text/css">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>


    <link rel="icon" type="image/png" href="imagens/logo.png">
    <script>
      !function(){for(var l=document.querySelectorAll(".my-accordion .menu"),e=0;e<l.length;e++)l[e].addEventListener("click",n);function n(){for(var e=document.querySelectorAll(".my-accordion .panel"),n=0;n<e.length;n++)e[n].className="panel close";if(-1==this.className.indexOf("active")){for(n=0;n<l.length;n++)l[n].className="menu";this.className="menu active",this.nextElementSibling.className="panel open"}else for(n=0;n<l.length;n++)l[n].className="menu"}}();
    </script>
    <title>VoluntárioCOVID19</title>
  </head>

  <body>

    <!-- Container onde fica a barra de nav -->
    <?php

      include "template_navbar.php" ;

    ?>
  
  <div id="divImagem">
        <img src="imagens/7.jpg" id="imagem1">

        <div class="body_container">

          <div id="sub-inicio">
            <center><h3>Porquê Voluntariado?</h3></center><br>
          Olá! Estar aqui é o primeiro passo para encontrares o projeto ideal para que te possas desenvolver enquanto ajudas quem mais precisa.
          Assim vamos começar por te explicar o que é um Voluntário e quais as vantagens de o ser! <br>
          Voluntário é aquele que de forma responsável e sem segundas intenções, para além de ajudar, se compromete a realizar ações de cariz social e comunitário de modo a ajudar quem precisa. O voluntário faz uso das suas capacidades e usa o seu tempo com o propósito de ajudar e fazer parte de um projeto maior.
          De seguida iremos apresentar algumas das vantagens de te tornares um voluntário connosco!
          </div>

          <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center">Permite-te colocar as tuas dificuldades em perspetiva.
          <li class="list-group-item d-flex justify-content-between align-items-center">Ajuda a promover a tua carreira.</li>
          <li class="list-group-item d-flex justify-content-between align-items-center">Dá-te um sentido de propósito.</li>
          <li class="list-group-item d-flex justify-content-between align-items-center">Melhora a tua saúde física e mental.</li>
          <li class="list-group-item d-flex justify-content-between align-items-center">Ajuda na construção da tua confiança e autoestima.</li>
          <li class="list-group-item d-flex justify-content-between align-items-center">Possibilita a aquisição de novas competências.. e muito mais!</li>

          </ul>

          
<a href="https://ionline.sapo.pt/artigo/681192/voluntarios-testemunhos-de-quem-da-o-seu-tempo-aos-outros-?seccao=Portugal_i">
<div class="card border-primary mb-3 float" style="max-width: 18rem;">
  <div class="card-header">Notícia</div>
  <div class="card-body text-primary">
    <h5 class="card-title">Testemunhos</h5>
    <p class="card-text">Em tempo de partilha, falámos com voluntários sobre os desafios que os chamaram a dar um pouco mais de si a diferentes projetos...</p>
  </div>
</div>
</a>
<a href="https://www.publico.pt/2021/03/01/sociedade/noticia/pandemia-nao-travou-voluntariado-pessoas-nao-fome-so-dia-sim-dia-nao-1951799">
<div class="card border-secondary mb-3 float" style="max-width: 18rem;">
  <div class="card-header">Notícia</div>
  <div class="card-body text-secondary">
    <h5 class="card-title">Pandemia</h5>
    <p class="card-text">A crise pandémica veio iluminar, e agravar, as desigualdades sociais. Numa altura em que não se pode sair de casa, há quem se mova...</p>
  </div>
</div>
</a>
<a href="https://agencia.ecclesia.pt/portal/covid-19-confederacao-portuguesa-do-voluntariado-apela-a-vacinacao-de-mais-voluntarios/">
<div class="card border-success mb-3 float" style="max-width: 18rem;">
  <div class="card-header">Notícia</div>
  <div class="card-body text-success">
    <h5 class="card-title">Apelo</h5>
    <p class="card-text">Lisboa, 27 fev 2021 (Ecclesia) – A Confederação Portuguesa do Voluntariado (CPV) apelou que sejam considerados “prioritários”...</p>
  </div>
</div>
</a>
<a href="https://omirante.pt/sociedade/2021-03-09-Os-desafios-de-ser-voluntario-em-tempo-de-pandemia">
<div class="card border-danger mb-3 float" style="max-width: 18rem;">
  <div class="card-header">Notícia</div>
  <div class="card-body text-danger">
    <h5 class="card-title">Desafios</h5>
    <p class="card-text">O Banco de Voluntariado do Entroncamento organizou uma conferência online onde se falou de resiliência, coragem, do...</p>
  </div>
</div>
</a>
<a href=https://caritas.pt/covid-19-donativo-online>
<div class="card border-warning mb-3 float" style="max-width: 18rem;">
  <div class="card-header">Notícia</div>
  <div class="card-body text-warning">
    <h5 class="card-title">Donativos</h5>
    <p class="card-text">EMERGÊNCIA SOCIAL COVID-19... Contribua - Estamos a assegurar a resposta a todos os que, em emergência necessitam de ajuda</p>
  </div>
</div>
</a>

</div>
</div>

    <div class="footer">
        <p><em> Voluntário COVID19 <br>  Desenvolvido por: Grupo 20 - Rafael Ribeiro, António Pereira, Gonçalo Miguel | <strong>Copyright©2021</strong> <br>
        Aplicação desenvolvida como parte integrante de um projeto FCUL.</em></p>
    </div>
  </body>

</html>