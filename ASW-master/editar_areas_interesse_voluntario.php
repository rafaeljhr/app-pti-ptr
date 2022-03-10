<?php
session_start();
// print_r($_SESSION);
?>

<!doctype html>
<html lang="pt">
    
  <head>
    <!-- Aceder ao site: -->
    <!-- Aceder à base de dados: http://appserver-01.alunos.di.fc.ul.pt/phpmyadmin/ -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/style-areas_interesse_voluntario.css" type="text/css">
    <link rel="stylesheet" href="css/style-cssPartilhado.css" type="text/css">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="js/script-editar_areas_interesse_voluntariado.js"> </script>

    <link rel="icon" type="image/png" href="imagens/logo.png">
    <title>VoluntárioCOVID19</title>
  </head>

  <body>

    <!-- Container onde fica a barra de nav -->
    <?php

      include "template_navbar.php" ;

    ?>
    
    <div id="divImagem">
        <img src="imagens/5.jpg" id="imagem5">
          
        <form class="form-container" action="alterar_areas_interesse_voluntario.php" id="form_alterar_areas_interesse" method="post" onsubmit="return verificar_inputs()">
            <div class="container w-75">
            
                <h4>Definir áreas de interesse</h4>

                <br>

                <label for="labal_area_interesse" class="form-label">Áreas de Interesse<a class="symbol">*</a></label>
				<select name="areas_interesses" class='form-select' id="areas_interesses">
					<?php
						$_SESSION["Estado_Area_Interesse"] = "options";
						include "areas_interesse.php";
					?>
				</select>
				<br>
				<button type="button" class="float-right btn btn-success" name="add_area" id="add_area">Adicionar</button>
				<br><br>
				<div id = "areas_adicionadas" class="d-grid gap-3">
					<?php
						$_SESSION["Estado_Area_Interesse"] = "areas_adicionadas";
						include "areas_interesse.php";
					?>
				</div>
                <small class="smalls" id = "area_interesse_nao_selecionada">Tem de adicionar pelo menos 1 área de interesse!</small>
                
            </div>

            <hr class="my-4"> 

            <div class="container w-75">

                <h4>Definir população alvo</h4> 
                
                <br>

                <label for="populacao_alvo1" class="form-label">População alvo<a class="symbol">*</a></label>
				<select name="populacao_alvo" class='form-select' id="populacao_alvo">
                <?php
                    $_SESSION["Estado_Populacao_Alvo"] = "options";
                    include "populacao_alvo.php";
                ?>
				</select>
				<br>
				<button type="button" class="float-right btn btn-success" name="add_populacao" id="add_populacao">Adicionar</button>
				<br><br>
				<div id = "populacoes_adicionadas" class="d-grid gap-3">
					<?php
						$_SESSION["Estado_Populacao_Alvo"] = "populacao_adicionada";
						include "populacao_alvo.php";
					?>
				</div>
                <small class="smalls" id = "populacao_alvo_nao_selecionada">Tem de selecionar pelo menos 1 população alvo!</small>

            </div>

            <hr class="my-4"> 

            <div class="container w-75">

                <h4>Definir disponibilidade</h4> 

                <br>

                <label class="form-label">Dia da semana <a class="symbol">*</a></label>
				
                <?php
                    $_SESSION["Estado_Horario"] = "options";
                    include "horario.php";
                ?>
				<br>
				<small class="smalls" id = "horarios_iguais">Não pode ter 2 horarios iguais!</small>
				<br>
				<button type="button" class="float-right btn btn-success" name="add_horario" id="add_horario">Adicionar</button>
				</br></br>
				<div id = "horarios_adicionados" class="d-grid gap-3">
					<?php
						$_SESSION["Estado_Horario"] = "horario_adicionado";
						include "horario.php";
					?>
				</div>
                <small class="smalls" id = "horario_nao_adicionado">Tem de adicionar pelo menos 1 horário!</small>

            </div>
            <br>
            <br>
            <div class="zona_dos_botoes container d-flex justify-content-around">
                <button type = "submit" class="btn btn-primary btn-lg" id="guardar">GUARDAR</button>
            </div>

        </form>

    </div>

    <!-- As propriedades de footer desta página constam em style-cssPartilhado.css -->
    <div class="footer">
        <p id="footerP"><em> Voluntário COVID19 <br>  Desenvolvido por: Grupo 20 - Rafael Ribeiro, António Pereira, Gonçalo Miguel | <strong>Copyright©2021</strong> <br>
        Aplicação desenvolvida como parte integrante de um projeto FCUL.</em></p>
    </div>
    
  </body>

</html>